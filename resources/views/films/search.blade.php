@extends('layouts.app')
@section('content')
	<div class="recommended">
		<div class="top-grids">
			<div class="recommended-info">
				<h3>{{__('搜索内容')}}</h3>
			</div>
				<div class="recommended-grids">
					@foreach($data as $key=>$val)
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
@endsection