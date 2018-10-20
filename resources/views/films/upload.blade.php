@extends('layouts.app')
@section('content')
	<style>
		.upload-right-bottom-left input {
			float:right;
			margin-right: 20%;
		}
		.upload-right-bottom-left select {
			float:right;
			margin-right: 20%;
		}
	</style>
	<div class="upload" style="margin-top: -2%;">
		<!-- container -->
		<div class="container">
			<div class="upload-grids">
				<div class="upload-right">
					<!--div模拟进度条-->
					<div id="progressNumber" style="width: 0%; height: 8px; background-color: #21DEEF"></div>
					<br><br>
					<div class="upload-file">
						<div class="services-icon">
							<span class="glyphicon glyphicon-open" aria-hidden="true"></span>
						</div>
						<input type="file" id="uploadMovieInput" style="left:47%;top:30%" name="movie" value="">
					</div>
					<div class="upload-info">
						<h5>{{__('选择电影文件上传')}}</h5>
					</div>
					<div class="upload-info" style="margin-left: 3%">
						<div class="signin">
							<a href="#" id="a_tags" onclick="javascript:uploadsMovie();" class="play-icon popup-with-zoom-anim">{{__('上传电影')}}</a>
						</div>
					</div>
				</div>
				<form action="{{url('films/upload')}}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div id="div_tag" class="upload-right-bottom-grids" style="display: none">
						<div class="col-md-4 upload-right-bottom-left">
							<h4>{{__('电影图片')}}</h4><br>
							<div class="upload-right-top-list">
								<input id="uploadImgInput" name="img" type="file" style="float:left;">
							</div>
							<image id="uploadImg" src="" style="width:60%;display:none"></image>
						</div>
						<div class="col-md-4 upload-right-bottom-left">
							<h4>{{__('详细信息')}}</h4>
							<div class="upload-right-top-list" style="color:#9E9E9E;font-size:130%!important;">
								<ul>
									<li>
										<span>{{__('类型')}}:</span>
										<select name="upload[type]" >
										</select>
									</li>
									<li>
										<span>{{__('地区')}}:</span>
										<select name="upload[areas]">
											@foreach($areas as $v)
												<option value="{{$v->code}}">{{session()->get('lan')=='en'?$v->en_name:$v->name}}</option>
											@endforeach
										</select>
									</li>
									<li>
										<span>{{__('类别')}}:</span>
										<select name="upload[menu_type]">
											<option value="1">{{__('电影')}}</option>
											<option value="2">{{__('电视剧')}}</option>
											<option value="3">{{__('综艺娱乐')}}</option>
											<option value="0">{{__('动漫(连载)')}}</option>

										</select>
									</li>
									<div id="tvFlag" style="display: none">
										<li><span>{{__('第几季')}}:</span><input type="text" name="upload[seasons]" value="{{old('upload')['seasons']}}"></li>
										<li><span>{{__('第几集')}}:</span><input type="text" name="upload[episodes]" value="{{old('upload')['episodes']}}"></li>
									</div>
									<input type="hidden" name="upload[movies_url]" id="hidden">
									<li><span>{{__('影片中文名')}}:</span><input type="text" name="upload[name]" value="{{old('upload')['name']}}" required="required"></li>
									<li><span>{{__('影片英文名')}}:</span><input type="text" name="upload[en_name]" value="{{old('upload')['en_name']}}"></li>
									<li><span>{{__('主演')}}:</span><input type="text" name="upload[main_performer]" value="{{old('upload')['main_performer']}}"></li>
									<li><span>{{__('导演')}}:</span><input type="text" name="upload[director]" value="{{old('upload')['director']}}"></li>
									<li><span>{{__('上映时间')}}:</span><input type="text" name="upload[show_date]" value="{{old('upload')['show_date']}}"></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4 upload-right-bottom-left">
							<h4>{{__('电影描述')}}</h4>
							<div class="upload-right-top-list"><br>
								<textarea name="upload[comment]" style="width:80%;height:280px;font-size:130%"></textarea>
							</div>
						</div>

						<div class="clearfix"> </div>
						<div class="upload-info">
							<div class="signin">
								<a href="#" onclick="javascript:$('form').submit();" class="play-icon popup-with-zoom-anim">{{__('更新电影信息')}}</a>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
				</form>



			</div>
		</div>
		<!-- //container -->
	</div>
	<script>
		$(function(){
		    $('#uploadImgInput').change(function (){
		        var file = $(this);
                if(file.val()==''){
                    $('#uploadImg').hide();
                    return;
                }
                var fileObj = file[0];
				var windowURL = window.URL || window.webkitURL;
                var dataURL;
				if (fileObj && fileObj.files && fileObj.files[0]) {
                    dataURL = windowURL.createObjectURL(fileObj.files[0]);
                    $('#uploadImg').show();
                    $('#uploadImg').attr('src', dataURL);
                }
			});

		    $('#uploadMovieInput').change(function (){
		        if($(this).val()==''){
		            $('div[class="upload-info"]').find('h5').text('{{__('选择电影文件上传')}}');
		            return;
				}
				$('div[class="upload-info"]').find('h5').text($(this).val().substr($(this).val().search(/\\[^\\]+\.[\s\S]*$/)+1));
			});

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('films/data')}}",
                type:'get',
                dataType:'json',
                success:function (json){
                    var str;
                    for(var key in json){
                        str = '<option value="'+key+'">'+json[key]+'</option>'
                        $('select[name="upload[type]"]').append(str);
                    }
                }
            })
			$('select[name="upload[menu_type]"]').change(function (){
			    if($(this).val()!=1){
					$('#tvFlag').show();
				}else{
                    $('#tvFlag').hide();
				}
			})

			@if($errors->has('movieError'))
				alert('{{$errors->first("movieError")}}');
			@endif
			@if($errors->has('imgError'))
				alert('{{$errors->first("imgError")}}');
			@endif
			@if($errors->has('name'))
				alert('{{$errors->first("name")}}');
			@endif
			@if($errors->has('movies_url'))
				alert('{{$errors->first("movies_url")}}');
            @endif
            @if($errors->has('dbError'))
alert('{{$errors->first("dbError")}}');
			@endif
		})

		//上传电影 切割循环
		var start = 0;
		var LENGTH = 2*1024*1024;
        var end = start+LENGTH;
		var current_page = 0;
		var counts = 0;
		var limit = 20;
		var progress = 0;
        function uploadsAction(){
            start = 0;
            end = start+LENGTH;
            current_page = 0;
            counts = 0;
            progress = 0;
            var file = $('#uploadMovieInput');
		    var fileObj = file[0].files[0];
		    var pages = Math.ceil(fileObj.size/LENGTH);
            sendFileByAJAX(fileObj,pages);
		}

        //切割文件
        function cutFile(file){
            var file_blob = file.slice(start,end);
            start = end;
            end = start + LENGTH;
            return file_blob;
        }
		//发送文件
		function sendFileByAJAX(fileObj,pages) {
            var file_blob = cutFile(fileObj);
            var fileName = $('div[class="upload-info"]').find('h5').text();
            current_page++;
            /*var reader = new FileReader();
            reader.readAsBinaryString(file_blob);
            reader.onload = function (e) {
                file_blob=this.result;
			};*/
            var form_data = new FormData();
            form_data.append('pages',pages);
            form_data.append('current_page',current_page);
            form_data.append('name',fileName);
            form_data.append('file',file_blob);
			/*$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('films/uploadsMovie')}}",
                type:'post',
				//data:form_data,
                data:{file_blob:file_blob,pages:pages,current_page:current_page,name:fileName},
				dataType:'json',
                success:function (json){
                    if(json.code==-1){
                        alert('{{__("文件格式不正确")}}');
                    }
                    if(json.code==1){
                        sendFileByAJAX(fileObj,pages);
					}
					if(json.code==0){
                        counts++;
                        if(counts>limit){
                            alert('{{__("上传失败")}}');
                            return;
						}
                        current_page--;
                        start -= LENGTH;
                        end -= LENGTH;
                        sendFileByAJAX(fileObj,pages);
					}
                    if(json.code==2){
                        $('#a_tags').text('{{_("已上传")}}');
                        $('#a_tags').attr('disabled','true');
                        $('#hidden').val(json.src);
                        $('#div_tag').show();
                    }
                }
			});*/
            var xhr = new XMLHttpRequest();
            xhr.open('POST','{{url('films/uploadsMovie')}}',true);
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {//
                    var responseText = xhr.responseText;

					var json = JSON.parse(responseText);
                    if (json.code == -1) {
                        alert('{{__("文件格式不正确")}}');
                    }
                    if (json.code == 1) {
                        progress = Math.min(100,(current_page/pages)* 100 ) +'%';
                        $('#progressNumber').css('width',progress);
                        sendFileByAJAX(fileObj, pages);
                    }
                    if (json.code == 0) {
                        counts++;
                        if (counts > limit) {
                            alert('{{__("上传失败")}}');
                            return;
                        }
                        current_page--;
                        start -= LENGTH;
                        end -= LENGTH;
                        sendFileByAJAX(fileObj, pages);
                    }
                    if (json.code == 2) {
                        $('#progressNumber').css('width','0%');
                        $('#a_tags').text('{{_("已上传")}}');
                        $('#a_tags').attr('onclick', 'javascript:return false;');
                        $('#a_tags').css('opacity','0.2');
                        $('#hidden').val(json.src);
                        $('#div_tag').show();
                    }
                }
			}
            xhr.send(form_data);
        }

		function uploadsMovie(){
		    if($('#uploadMovieInput').val()==''){
		        alert('{{__("请选择电影文件")}}');
		        return;
			}
			$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('films/delDir')}}",
                type:'get',
                success:function (json){
                    uploadsAction();
                }
			});

		}


	</script>

@endsection