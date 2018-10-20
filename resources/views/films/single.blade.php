@extends('layouts.app')
@section('content')
    <style>
        #changecolor a:hover {background: #0076CC!important;color:#FFFFFF!important}
    </style>
    <div style="padding-left: 2%;">
        <div class="l info">
            <img style="float:left;width:24%" class="pic l" style="display: block;" src="{{$data[0]->img_url}}">
            <div style="padding-left:30%;font-size:20px">
                <h1>{{(app('request')->session()->get('lan')=='en')?$data[0]->en_name:$data[0]->name}}</h1><br>
                <div>{{__('类型')}}：{{getFilmsStyleNameByCode($data[0]->type)}}</div><br>
                <div>{{__('导演')}}：{{$data[0]->director}}</div><br>
                <div>{{__('地区')}}：{{(app('request')->session()->get('lan')=='en')?getNameByAreaCode($data[0]->areas)['en_name']:getNameByAreaCode($data[0]->areas)['name']}}</div><br>
                <div>{{__('年代')}}：{{$data[0]->show_date}}</div><br>
                <div>{{__('上传用户')}}：{{$data[0]->upload_user}}</div><br>
                <div>{{__('更新时间')}}：{{$data[0]->created_at}}</div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div style="margin-top:4%;margin-bottom:4%;border: 1px solid #ddd;width: 96%">
            <div style="padding-bottom: 1%">
                <ul>
                    @foreach($data as $val)
                        <li id="changecolor" style="display: block;padding:1.5%;float:left;font-size:14px;font-weight:bold;">
                            <a style="text-decoration: none;color: #000;display: block;width:100px;padding: 4px;background:#ddd;border: 1px solid #ddd;text-align: center;"href="{{url('films/player',[base64_encode($val->movies_url)])}}" target="_blank">
                                @if($val->menu_type!=1)
                                    @if($val->episodes>1000)
                                        {{$val->episodes}}
                                    @else
                                        {{__('第')}}{{$val->episodes}}{{__('集')}}
                                    @endif
                                @else
                                    {{__('播放')}}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="clearfix"> </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
@endsection