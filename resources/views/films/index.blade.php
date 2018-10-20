@extends('layouts.app')
@section('content')
	<div class="top-grids">
		<div class="top-grids">
			<div class="recommended-info">
				<h3>{{__('最近更新')}}</h3>
			</div>
			<script src="{{asset('js/responsiveslides.min.js')}}"></script>
			<script>
                // You can also use "$(window).load(function() {"
                $(function () {
                    // Slideshow 4
                    $("#slider3").responsiveSlides({
                        auto: true,
                        pager: false,
                        nav: true,
                        speed: 500,
                        namespace: "callbacks",
                        before: function () {
                            $('.events').append("<li>before event fired.</li>");
                        },
                        after: function () {
                            $('.events').append("<li>after event fired.</li>");
                        }
                    });

                });
			</script>
			<div  id="top" class="callbacks_container">
				<ul class="rslides" id="slider3">
					@foreach($recentFilms as $recentFilmLine)
						<li>
						<div class="animated-grids">
							@if($recentFilmLine)
							@foreach($recentFilmLine as $recentFilm)
								<div class="col-md-3 resent-grid recommended-grid slider-first">
									<div class="resent-grid-img recommended-grid-img">
										<a href="{{url('films/single',[$recentFilm->code])}}">
											<img src="{{$recentFilm->img_url}}" alt="" />
											@if($recentFilm->menu_type!=1)
												<span class="live-galleryDuration">{{$recentFilm->seasons}}</span>
											@endif
										</a>
										<div class="time small-time slider-time">
											<p>{{$recentFilm->time}}</p>
										</div>
										<div class="clck small-clck">
											<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
										</div>
									</div>
									<div class="resent-grid-info recommended-grid-info">
										<h5><a href="{{url('films/single').'/'.$recentFilm->code}}" class="title">{{(session()->get('lan')=='en')?$recentFilm->en_name:$recentFilm->name}}</a></h5>
										<div class="slid-bottom-grids">
											<div class="slid-bottom-grid">
												<p class="author author-info"><a href="#" class="author">{{$recentFilm->upload_user}}</a></p>
											</div>
											<div class="slid-bottom-grid slid-bottom-right">
												<p class="views views-info">{{number_format($recentFilm->views).(($recentFilm->views>1)?' views':' view')}}</p>
											</div>
											<div class="clearfix"> </div>
										</div>
									</div>
								</div>
							@endforeach
							@endif
							<div class="clearfix"> </div>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	@foreach($menu as $val)
		<?php
        	if($val->en_name=='movies')
				$mFilms = $moFilms;
			elseif($val->en_name=='shows')
                $mFilms = $shFilms;
			elseif($val->en_name=='entertainments')
                $mFilms = $enFilms;
		?>
		<div class="recommended">
		<div class="recommended-grids">
			<div class="recommended-info">
				<h3>{{(session()->get('lan')=='en')?$val->en_name:$val->name}}</h3>
			</div>

			@foreach($mFilms as $key=>$mFilmsLine)
				@if($key==1)
					<div class="recommended-grids">
				@endif
					@foreach($mFilmsLine as $mFilm)
						<div class="col-md-3 resent-grid recommended-grid">
							<div class="resent-grid-img recommended-grid-img">
								<a href="{{url('films/single',[$mFilm->code])}}">
									<img src="{{$mFilm->img_url}}" alt="" />
									@if($mFilm->menu_type!=1)
										<span class="live-galleryDuration">{{$mFilm->seasons}}</span>
									@endif
								</a>
								<div class="time small-time">
									<p>{{$mFilm->time}}</p>
								</div>
								<div class="clck small-clck">
									<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
								</div>
							</div>
							<div class="resent-grid-info recommended-grid-info video-info-grid">
								<h5><a href="{{url('films/single').'/'.$mFilm->code}}" class="title">{{(session()->get('lan')=='en')?$mFilm->en_name:$mFilm->name}}</a></h5>
								<ul>
									<li><p class="author author-info"><a href="#" class="author">{{$mFilm->upload_user}}</a></p></li>
									<li class="right-list"><p class="views views-info">{{number_format($mFilm->views).(($mFilm->views>1)?' views':' view')}}</p></li>
								</ul>
							</div>
						</div>
					@endforeach
					@if($key==1)
						</div>
					@endif
					<div class="clearfix"> </div>
			@endforeach
		</div>
		</div>
	@endforeach
	<?php
    	$mFilms = $anFilms;
	?>
	<div class="recommended">
		<div class="recommended-grids">
			<div class="recommended-info">
				<h3>{{__('动漫(连载)')}}</h3>
			</div>
			@foreach($mFilms as $key=>$mFilmsLine)
				@if($key==1)
					<div class="recommended-grids">
				@endif
				@foreach($mFilmsLine as $mFilm)
					<div class="col-md-3 resent-grid recommended-grid">
						<div class="resent-grid-img recommended-grid-img">
							<a href="{{url('films/single',[$mFilm->code])}}">
								<img src="{{$mFilm->img_url}}" alt="" />
									<span class="live-galleryDuration">{{$mFilm->seasons}}</span>
							</a>
							<div class="time small-time">
								<p>{{$mFilm->time}}</p>
							</div>
							<div class="clck small-clck">
								<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
							</div>
						</div>
						<div class="resent-grid-info recommended-grid-info video-info-grid">
							<h5><a href="{{url('films/single').'/'.$mFilm->code}}" class="title">{{(session()->get('lan')=='en')?$mFilm->en_name:$mFilm->name}}</a></h5>
							<ul>
								<li><p class="author author-info"><a href="#" class="author">{{$mFilm->upload_user}}</a></p></li>
								<li class="right-list"><p class="views views-info">{{number_format($mFilm->views).(($mFilm->views>1)?' views':' view')}}</p></li>
							</ul>
						</div>
					</div>
				@endforeach
				@if($key==1)
					</div>
				@endif
				<div class="clearfix"> </div>
			@endforeach
		</div>
	</div>
@endsection