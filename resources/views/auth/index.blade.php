@extends('layouts.app')
@section('content')
	<div style="padding-left: 2%;">
		<div class="l info">
			<img style="float:left;width:24%" class="pic l" style="display: block;" src="{{asset('images/person.jpg')}}">
			<div style="padding-left:30%;font-size:20px"><br><br>
				<div>{{__('姓名')}}：{{$data[0]->name}}</div><br>
				<div>{{__('邮箱账号')}}：{{$data[0]->email}}</div><br>
				<div>{{__('手机')}}：{{$data[0]->telephone}}</div><br>
				<a href="{{url('user/logout')}}"  class="play-icon popup-with-zoom-anim">{{ __('退出登录') }}</a>
			</div>
		</div>
		<div class="clearfix"> </div><br><br><br><br><br><br>
		<div class="recommended">
			<div class="top-grids">
				<div class="recommended-info">
					<h3>{{__('上传历史')}}</h3>
				</div>
				<div class="recommended-grids">
					@foreach($dataF as $key=>$val)
						@if($key!=0&&$key%5==0)
				</div>
				<div class="clearfix"> </div>
				<div class="recommended-grids">
					@endif
					<div class="col-md-3 resent-grid recommended-grid" style="width: 20%">
						<div class="resent-grid-img recommended-grid-img">
							<a href="{{url('films/single',[$val->code])}}">
								<img src="{{$val->img_url}}" alt="" />
								@if($val->menu_type!=1)
									<span class="live-galleryDuration">{{$val->seasons}}</span>
								@endif
							</a>
							<div class="time small-time">
								<p>{{$val->time}}</p>
							</div>
							<div class="clck small-clck">
								<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
							</div>
						</div>
						<div class="resent-grid-info recommended-grid-info video-info-grid">
							<h5><a href="{{url('films/single').'/'.$val->code}}" class="title">{{(session()->get('lan')=='en')?$val->en_name:$val->name}}</a></h5>
							<ul>
								<li><p class="author author-info"><a href="#" class="author">{{$val->upload_user}}</a></p></li>
								<li class="right-list"><p class="views views-info">{{number_format($val->views).(($val->views>1)?' views':' view')}}</p></li>
							</ul>
						</div>
					</div>
					@endforeach
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<br><br><br><br><br>
@endsection