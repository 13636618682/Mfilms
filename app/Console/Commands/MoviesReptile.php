<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use phpQuery;
use Illuminate\Support\Facades\Log;
use App\Movies;
use Illuminate\Support\Facades\DB;

class MoviesWorm extends Command
{
    protected $counter = 1;
    protected $totalNum = 7000;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:MoviesWorm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $requests = function ($total) {
            $uri1 = 'http://www.yse123.com/vod/';
            $uri3 = '.html';
            for ($i = 0; $i <= $total; $i++) {
                $uri2 = '16'.sprintf('%04s',$i)+8410;
                $uri = $uri1.$uri2.$uri3;
                yield new Request('GET', $uri);
            }
        };

        $pool = new Pool($client, $requests($this->totalNum), [
            'concurrency' => 10,
            'fulfilled' => function ($response, $index) use($client) {
                $body = $response->getBody();
                if(!$body){
                    Log::info("[$index]has not body;");
                    $this->info("[$index]has not body;");
                }else{
                    $this->working((string)$body,$index,$client);
                }
                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index) {
                Log::error("[$index]rejected reason: " . $reason);
                $this->error("[$index]rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);
        Log::info('爬虫开始工作');
        $this->info("爬虫开始工作");
        $promise = $pool->promise();

        $promise->wait();
    }

    public function countedAndCheckEnded() {
        if ($this->counter < $this->totalNum){
            $this->counter++;
            return;
        }
        $this->info("请求结束！");
    }

    public function working($html,$index,$client){
        $eg=phpQuery::newDocument($html);
        $title = pq('title',$eg)->html();
        $title = mb_convert_encoding($title, "UTF-8", "GBK");
        if(mb_strpos($title, '页面不存在')!==false){
            Log:info("[$index]页面不存在");
            return;
        }
        $liNum = pq('#vlink_1',$eg)->find("li")->length;
        $moviesOrTv = 0;
        if($liNum!=1){
            $moviesOrTv = 1;
        }
        $imgUrl = pq("div[class='l info']",$eg)->find('img')->attr('original');
        if(!$imgUrl){
            Log::info("[$index]imgUrl non-existent");
            return;
        }
        $name = pq("div[class='l info']",$eg)->find('h1')->html();
        if(!$name){
            Log::info("[$index]name non-existent");
            return;
        }
        $name = mb_convert_encoding($name, "UTF-8", "GBK");
        preg_match("/(第[\x{4e00}-\x{9fa5}]+季)/u",$name,$preg);
        $seasons = $preg?$preg[1]:'';
        $areas = pq("div[class='l info']",$eg)->find('label')->eq(0)->html();
        if(!$areas){
            Log::info("[$index]areas non-existent");
            return;
        }
        $areas = mb_convert_encoding($areas, "UTF-8", "GBK");
        $lengthareas=mb_strlen($areas);
        $areas=mb_substr($areas,$lengthareas-2);
        $areas=getCodeByAreaName($areas);

        $time = pq("div[class='l info']",$eg)->find('label')->eq(1)->html();
        if(!$time){
            Log::info("[$index]time non-existent");
            return;
        }
        $lengthtime=mb_strlen($time);
        $time=mb_substr($time,$lengthtime-4);

        $style = pq("h3[class='position']",$eg)->eq(0)->find('a')->eq(1)->html();
        $style = mb_convert_encoding($style, "UTF-8", "GBK");
        $style=mb_substr($style,0,2);
        if($moviesOrTv){
            if($style=='动画'){
                $menuType = 0;
                $proCode = 'A';
            }
            elseif ($style=='综艺') {
                $menuType = 3;
                $proCode = 'E';
            }
            else {
                $menuType = 2;
                $proCode = 'T';
            }
        }else{
            $menuType = 1;
            $proCode = 'M';
        }
        $tvCode = $proCode.uniqid();
        $style = getFilmsStyleCodeByName($style);

        $a = pq('#vlink_1',$eg)->find('a');
        $aLength = $a->length;

        foreach ($a as $key=>$val){
            $movieUrl = $a->eq($key)->attr('href');
            $episodes = $a->eq($key)->text();
            $episodes = mb_convert_encoding($episodes, "UTF-8", "GBK");
            $episodes = (int)$episodes;
            if(!$movieUrl){
                Log::info("[$index]movieUrl non-existent");
                return;
            }
            $movieUrl = 'http://www.yse123.com'.$movieUrl;


            //获取原电影页面url
            $response = $client->request('GET', $movieUrl);
            $body = $response->getBody();
            if(!$body){
                Log::info("[$index]movies has not body;");
                $this->info("[$index]movies has not body;");
                return;
            }
            $eg1 = phpQuery::newDocument((string)$body);
            $playerSrc = pq('div[class="player"]',$eg1)->find('script')->attr('src');
            if(!$playerSrc){
                Log::info("[$index]playerSrc non-existent");
                return;
            }
            $playerSrc = 'http://www.yse123.com'.$playerSrc;
            //根据playerSrc获取真实电影url
            $response = $client->request('GET', $playerSrc);
            $body = $response->getBody();
            $body = mb_convert_encoding((string)$body, "UTF-8", "GBK");
            $num = preg_match_all('/(https\S*m3u8)\$m3u8/U',$body,$matchArr,PREG_SET_ORDER);
            if($num==0){
                Log::info("[$index]".'not match movieSrc');
                return;
            }
            $movieSrc = $matchArr[$aLength-$key-1][1];
            $tvData[$key] = [
                'name' => $name,
                'tv_code' => $tvCode,
                'code' => $proCode.uniqid(time()),
                'upload_user' => 'admin',
                'type' => $style,
                'menu_type' => $menuType,
                'seasons' => $seasons,
                'episodes' => ($episodes>10000)?$episodes:($liNum-$key),
                'areas' => $areas,
                'show_date' => $time,
                'img_url' => $imgUrl,
                'movies_url' => $movieSrc,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ];
        }

        if(!$moviesOrTv){
            unset($tvData[0]['tv_code']);
            unset($tvData[0]['seasons']);
            unset($tvData[0]['episodes']);
            $movie = Movies::create($tvData[0]);
            if($movie){
                Log::info("[$index]DB操作成功");
            }else{
                Log::info("[$index]DB操作失败");
            }
        }else{
            $flag = DB::table('tv_shows')->insert($tvData);
            if($flag){
                Log::info("[$index]DB操作成功");
            }else{
                Log::info("[$index]DB操作失败");
            }
        }
    }


}
