@extends('layouts.app')
@section('content')
	<script>
		var area = getQueryString('area');
		var menuType = getQueryString('menuType');
		var count = 0;
		$(window).scroll(function (){
            var height1 = $("div[class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main']").height();
            var height2 = $("div[class='col-sm-3 col-md-2 sidebar']").height();
            var start = $("div[class='col-md-3 resent-grid recommended-grid']").length;
            var type =  $('#typesearch').val();
            if($(window).scrollTop()>=height1-height2-0.5){
                count++;
                if(count%2!=0){
                    return;
				}
                if($('#loadingTip').is(":visible")){
					return;
				}
                showLoading();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
					url:"{{url('films/show')}}",
					type:'get',
					dataType:'json',
					data:{'start':start,'area':area,'menuType':menuType,'type':((type==-1)?'':type)},
					success:function (json){
					    if(json.num==0){hideLoading();return;}
                        var data = json.data;
                        var str = '<div class="recommended-grids">';
						for (var i= 0;i<json.num;i++){
						    if(i==5){
                                str += '</div>';
                                str += '<div class="clearfix"> </div>';
                                str += '<div class="recommended-grids">';
							}
						    str += '<div class="col-md-3 resent-grid recommended-grid" style="width: 20%">';
                            str += '<div class="resent-grid-img recommended-grid-img">';
                            str += '<a href="{{url('films/single')}}'+'/'+data[i].code+'">';
                            str += '<img src="'+data[i].img_url+'" alt="" />';
                            if(data[i].menu_type!=1){
                                str += '<span class="live-galleryDuration">'+data[i].seasons+'</span>';
							}
							str += '</a>';
                            str += '<div class="time small-time">';
                            str += '<p>'+data[i].time+'</p>';
                            str += '</div>';
                            str += '<div class="clck small-clck">';
                            str += '<span class="glyphicon glyphicon-time" aria-hidden="true"></span>';
                            str += '</div>';
                            str += '</div>';
                            str += '<div class="resent-grid-info recommended-grid-info video-info-grid">';
                            str += '<h5><a href="{{url('films/single')}}'+'/'+data[i].code+'" class="title">'+(('{{session()->get('lan')}}'=='en')?data[i].en_name:data[i].name)+'</a></h5>';
                            str += '<ul>';
                            str += '<li><p class="author author-info"><a href="#" class="author">'+data[i].upload_user+'</a></p></li>';
                            str += '<li class="right-list"><p class="views views-info">'+data[i].views+((data[i].views>1||data[i].views.length>2)?' views':' view')+'</p></li>';
                            str += '</ul>';
                            str += '</div>';
                            str += '</div>';
                        }
                        str += '</div>';
                        str += '<div class="clearfix"> </div>';
                        $('div[class="recommended-grids"]').last().next().after(str);
                        hideLoading();
					},
				})
            }
        })
	</script>
	<div class="recommended">
		<div class="top-grids">
			<div class="recommended-info">
				<h3>{{$h2?$h2:__('动漫(连载)')}}{{$h3?'('.$h3.')':''}}</h3>
			</div>

			@foreach($data as $value)
				<div class="recommended-grids">
				@foreach($value as $val)
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
			@endforeach
		</div>
	</div>
@endsection
