<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use phpQuery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class YMoviesReptile extends Command
{
    protected $counter = 1;
    protected $totalNum = 5000;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:YMoviesReptile';

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
            $uri1 = 'http://www.gdfrx.com/?m=vod-detail-id-';
            $uri3 = '.html';
            for ($i = 0; $i <= $total; $i++) {
                //$uri2 = sprintf('%04s',$i);
                $uri2 = $i+22077;
                $uri = $uri1.$uri2.$uri3;
                yield new Request('GET', $uri,['allow_redirects' => true,'connect_timeout' => 2,'timeout' => 2]);
            }
        };

        $pool = new Pool($client, $requests($this->totalNum), [
            'concurrency' => 300,
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
        $type = pq("span[class='cat_pos_l']",$eg)->find('a')->eq(1)->text();
        if(!$type){
            Log::info("[$index]type non-existent");
            return;
        }
        $name = pq("span[class='cat_pos_l']",$eg)->find('a')->eq(2)->text();
        if(!$name){
            Log::info("[$index]name non-existent");
            return;
        }
        $img_src = pq("div[class='film_info clearfix']",$eg)->find('img')->attr('src');
        if(!$img_src){
            Log::info("[$index]img_src non-existent");
            return;
        }

        $movies_src = pq("div[class='film_info clearfix']",$eg)->find('a')->eq(0)->attr('href');
        if(!$movies_src){
            Log::info("[$index]movies_src non-existent");
            return;
        }

        //获取原电影页面url
        $response = $client->request('GET', $movies_src,['connect_timeout' => 2,'timeout' => 2]);
        $body = $response->getBody();
        if(!$body){
            Log::info("[$index]movies has not body;");
            $this->info("[$index]movies has not body;");
            return;
        }
        $eg1 = phpQuery::newDocument((string)$body);
        $playerSrc = pq('div[class="video-js-box"]',$eg1)->find('script')->eq(0)->html();
        if(!$playerSrc){
            Log::info("[$index]playerSrc non-existent");
            return;
        }
        $num = preg_match('/http\S*m3u8/U',$playerSrc,$matchArr);
        if($num==0){
            Log::info("[$index]".'not match playerSrc');
            return;
        }
        $playerSrc = $matchArr[0];
        $playerSrc = urldecode($playerSrc);

        $data = [
            'name' => $name,
            'code' => 'Y'.uniqid(time()),
            'upload_user' => 'admin',
            'type' => $type,
            'img_url' => $img_src,
            'movies_url' => $playerSrc,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ];

        $movie = DB::table('y_movies')->insert($data);
        if($movie){
            Log::info("[$index]DB操作成功");
        }else{
            Log::info("[$index]DB操作失败");
        }

    }
}
