<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'MFilms') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="My Play Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel='stylesheet' type='text/css' media="all" />
    <!-- //bootstrap -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Custom Theme files -->
    <link href="{{ asset('css/style.css') }}" rel='stylesheet' type='text/css' media="all" />
    <style>
        .live-galleryDuration {
            position: absolute;
            top: 8px;
            right: 8px;
            color: #ffffff;
            line-height: 1.5;
            padding: 0 5px;
            border-radius: 20px;
            background-color: #000000;
            opacity: 0.7;
            filter: alpha(opacity=70);
        }
        .overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 10001;
            display:none;
            filter:alpha(opacity=60);
            background-color: #777;
            opacity: 0.5;
            -moz-opacity: 0.5;
        }
        .loading-tip {
            z-index: 10002;
            position: fixed;
            display:none;
        }
        .loading-tip img {
            width:50px;
            height:50px;
        }
        .invalid {
            border-color: #dc3545!important;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }
    </style>
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script language="javascript" type="text/javascript">
        // 浏览器兼容 取得浏览器可视区高度
        function getWindowInnerHeight() {
            var winHeight = window.innerHeight
                || (document.documentElement && document.documentElement.clientHeight)
                || (document.body && document.body.clientHeight);
            return winHeight;

        }

        // 浏览器兼容 取得浏览器可视区宽度
        function getWindowInnerWidth() {
            var winWidth = window.innerWidth
                || (document.documentElement && document.documentElement.clientWidth)
                || (document.body && document.body.clientWidth);
            return winWidth;

        }
        /**
         * 显示遮罩层
         */
        function showOverlay() {
            // 遮罩层宽高分别为页面内容的宽高
            $('.overlay').css({'height':$(document).height(),'width':$(document).width()});
            $('.overlay').show();
        }

        /**
         * 显示Loading提示
         */
        function showLoading() {
            // 先显示遮罩层
            showOverlay();
            // Loading提示窗口居中
            $("#loadingTip").css('top',
                (getWindowInnerHeight() - $("#loadingTip").height()) / 2 + 'px');
            $("#loadingTip").css('left',
                (getWindowInnerWidth() - $("#loadingTip").width()) / 2 + 'px');

            $("#loadingTip").show();

        }

        /**
         * 隐藏Loading提示
         */
        function hideLoading() {
            $('.overlay').hide();
            $("#loadingTip").hide();

        }

    </script>
    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script>
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }

        function getNewUrl(val) {
            var url = location.href;
            if(url.indexOf('?')==-1){
                url += '?lan='+val;
            }else{
                if(url.indexOf('lan=')==-1){
                    url += '&lan='+val;
                }else{
                    url = url.replace('lan='+getQueryString('lan'),'lan='+val);
                }
            }
            return url;
        }
        $(function (){
            $('select[class="form-control bfh-countries"]').change(function (obj) {
                var val = $(this).children('option:selected').val();
                if(!val){
                    return;
                }
                location.href = getNewUrl(val);
            })
        })

    </script>
</head>
<body>
<!-- 遮罩层DIV -->
<div id="overlay" class="overlay"></div>
<!-- Loading提示 DIV -->
<div id="loadingTip" class="loading-tip">
    <img src="{{asset('images/loading.gif')}}" />
</div>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html"><h1><img src="{{ asset('images/logo.png') }}" alt="" /></h1></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="top-search">
                <form onsubmit="javascript:return false;" class="navbar-form navbar-right"  style="width:60%;">
                    <input type="text" id="search" class="form-control" style="width:70%;float:left" placeholder="{{ __('搜索') }}...">
                    <input type="submit"  id="searchaction" style="left:66%;float:left" value="">
                    <div style="position: absolute !important;left:84%;">
                        <select class="form-control" id="typesearch" style="width:100%;display:none">
                            <option value="-1">{{ __('类型') }}</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="header-top-right">
                <div class="file">
                    @if(auth()->check())
                        <a href="{{url('films/upload')}}">{{ __('上传') }}</a>
                    @endif
                </div>
                @if(!auth()->check())
                <div class="signin">
                    <a href="#small-dialog3" class="play-icon popup-with-zoom-anim">{{ __('注册') }}</a>
                    <!-- pop-up-box -->
                    <script type="text/javascript" src="{{ asset('js/modernizr.custom.min.js') }}"></script>
                    <link href="{{ asset('css/popuo-box.css') }}" rel="stylesheet" type="text/css" media="all" />
                    <script src="{{ asset('js/jquery.magnific-popup.js') }}" type="text/javascript"></script>

                    <div id="small-dialog3" class="mfp-hide">
                        <h3>{{ __('创建账号') }}</h3>
                        <div class="social-sits">
                            <img width="60%" src="{{ asset('images/account.png') }}" alt="" />
                            <div class="button-bottom">
                                <p><a href="#" onclick="javascript:sendEmail()">{{ __('获取验证码') }}</a></p>
                            </div>
                            <div id="emailStatus" class="button-bottom" style="color:red;display: none">
                                <p style="color: red">{{ __('验证码已发送，请在邮件中查收。') }}</p>
                            </div>
                            <div class="button-bottom">
                                <p>{{ __('已经有账号了，') }}<a href="#small-dialog" class="play-icon popup-with-zoom-anim">{{ __('登录') }}</a></p>
                            </div>
                        </div>
                        <div class="signup">
                            <form method="POST" action="{{ url('user/register') }}">
                                {{ csrf_field() }}
                                <input type="text" name="email" value="{{old('email')}}" class="email{{ $errors->has('email') ? ' invalid' : '' }}" placeholder="{{ __('邮箱账号') }}" required="required" pattern="\w+\@{1}\w+\.{1}\w{2,}" title="{{ __('请输入有效邮箱账号') }}"/>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <input type="password" name="password_confirmation" class="{{ $errors->has('password_confirmation') ? ' invalid' : '' }}" placeholder="{{ __('密码') }}" required="required" pattern=".{6,}" title="{{ __('至少六位有效符号') }}" autocomplete="off" />
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                                <input type="password" name="password" class="{{ $errors->has('password') ? ' invalid' : '' }}" placeholder="{{ __('重复密码') }}" required="required" pattern=".{6,}" title="{{ __('至少六位有效符号') }}" autocomplete="off" />
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <input type="text" class="email{{ $errors->has('telephone') ? ' invalid' : '' }}" name="telephone" value="{{old('telephone')}}" placeholder="{{ __('手机号') }}" required="required" maxlength="12" pattern="[1-9]{1}\d{9,10}" title="{{ __('请输入有效手机号') }}" />
                                @if ($errors->has('telephone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                @endif
                                <input type="password" name="validate_code" placeholder="{{ __('验证码') }}" class="{{ $errors->has('validate_code') ? ' invalid' : '' }}" maxlength="10" required="required" pattern=".{4}" title="{{ __('请输入验证码') }}" />
                                @if ($errors->has('validate_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validate_code') }}</strong>
                                    </span>
                                @endif
                                <input type="submit"  value="{{ __('注册') }}"/>
                            </form>
                        </div>

                        <div class="clearfix"> </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('.popup-with-zoom-anim').magnificPopup({
                                type: 'inline',
                                fixedContentPos: false,
                                fixedBgPos: true,
                                overflowY: 'auto',
                                closeBtnInside: true,
                                preloader: false,
                                midClick: true,
                                removalDelay: 300,
                                mainClass: 'my-mfp-zoom-in'
                            });

                        });
                    </script>
                </div>
                @endif
                @if(auth()->check())
                    <div class="signin">
                        <a href="{{url('user/index',auth()->user()->id)}}" class="play-icon popup-with-zoom-anim">{{ auth()->user()->email }}</a>
                    </div>
                    <div class="clearfix"> </div>

                @endif
                @if(!auth()->check())
                <div class="signin">
                    <a href="#small-dialog" class="play-icon popup-with-zoom-anim">{{ __('登录') }}</a>
                    <div id="small-dialog" class="mfp-hide">
                        <h3>{{ __('登录') }}</h3>
                        <div class="social-sits">
                            <img width="60%" src="{{ asset('images/account.png') }}" alt="" />
                            <div class="button-bottom">
                                <p>{{ __('新账号') }}? <a href="#small-dialog3" class="play-icon popup-with-zoom-anim">{{ __('注册') }}</a></p>
                            </div>
                        </div>
                        <div class="signup">
                            <form method="POST" action="{{url('user/login')}}">
                                {{ csrf_field() }}
                                <input value="{{old('email')}}" type="text" name="email" class="email{{ $errors->has('email')&&($errors->first('errorsShowType')!='register') ? ' invalid' : '' }}" placeholder="{{ __('邮箱账号') }}" required="required" pattern="([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?"/>
                                @if ($errors->has('email')&&$errors->first('errorsShowType')!='register')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <input type="password" name="password" class="{{ $errors->has('password')&&($errors->first('errorsShowType')!='register') ? ' invalid' : '' }}" placeholder="{{ __('密码') }}" required="required" pattern=".{6,}" title="{{ __('至少六位有效符号') }}" autocomplete="off" />
                                @if ($errors->has('password')&&$errors->first('errorsShowType')!='register')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <input type="submit"  value="{{ __('登录') }}"/>
                            </form>
                            <div class="forgot">
                                <a href="#">{{ __('忘记密码') }}?</a>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                @endif
                <div class="clearfix"> </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
</nav>

<div class="col-sm-3 col-md-2 sidebar">
    <div class="drop-navigation drop-navigation">
        <ul class="nav nav-sidebar">
            <li class="{{basename(app('request')->getpathinfo())=='index'?'active':''}}"><a href="{{url('films/index')}}" class="home-icon"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>{{ __('主页') }}</a></li>
            @foreach($menu as $val)
            <li class="{{basename(app('request')->getpathinfo())==$val->en_name?'active':''}}"><a href="#" class="menu1 {{$val->a_class}}"><span class="{{$val->s_class}}" aria-hidden="true"></span>{{ __($val->name) }}</a></li>
            <ul class="cl-effect-2">
                @foreach($areas as $areao)
                <li><a href="{{url('films/show').'?menuType='.$val->id.'&area='.$areao->code}}">{{__($areao->name)}}</a></li>
                @endforeach
            </ul>
            @endforeach
            <script>
                $( "li a.menu1" ).click(function() {
                    $(this).parent().next().slideToggle( 300, function() {
                        // Animation complete.
                    });
                });
            </script>
            <li class="{{basename(app('request')->getpathinfo())=='animes'?'active':''}}"><a href="{{url('films/show').'?menuType=0'}}" class="animes-icon"><span class="glyphicon glyphicon-home glyphicon-picture" aria-hidden="true"></span>{{ __('动漫(连载)') }}</a></li>
            {{--<li class="{{basename(app('request')->getpathinfo())=='history'?'active':''}}"><a href="{{url('films/history')}}" class="history-icon"><span class="glyphicon glyphicon-home glyphicon-hourglass" aria-hidden="true"></span>{{ __('观看历史') }}</a></li>--}}
        </ul>


        <div class="side-bottom">
            <div class="copyright">
                <p> © 2018 My Films. All rights reserved </p>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    @yield('content')
    <!-- footer -->
    <div class="footer">
        <div class="footer-grids">
            <div class="footer-top">
                <div class="footer-top-nav">
                    <ul>
                        <li><a href="#">{{ __('关于我们') }}</a></li>
                        <li><a href="#">{{ __('版权声明') }}</a></li>
                        <li><a href="#">{{ __('网站地图') }}</a></li>
                        <li><a href="#">{{ __('友情链接') }}</a></li>
                        <li><a href="#">{{ __('联系我们') }}</a></li>
                    </ul>
                </div>

            </div>
            <div class="footer-bottom">
                <ul>
                    <li class="languages">
                        <select class="form-control bfh-countries" data-country="US">
                            <option value="">{{ __('选择语言') }}</option>
                            <option value="en">English</option>
                            <option>Spanish</option>
                            <option>French</option>
                            <option>German</option>
                            <option>Italian</option>
                            <option value="zh_cn">Chinese</option>
                            <option>Tagalog</option>
                            <option>Polish</option>
                            <option>Korean</option>
                            <option>Vietnamese</option>
                            <option>Portuguese</option>
                            <option>Japanese</option>
                            <option>Greek</option>
                            <option>Arabic</option>
                            <option>Hindi (urdu)</option>
                            <option>Russian</option>
                            <option>Yiddish</option>
                            <option>Thai (laotian)</option>
                            <option>Persian</option>
                            <option>French Creole</option>
                            <option>Armenian</option>
                            <option>Navaho</option>
                            <option>Hungarian</option>
                            <option>Hebrew</option>
                            <option>Dutch</option>
                            <option>Mon-khmer (cambodian)</option>
                            <option>Gujarathi</option>
                            <option>Ukrainian</option>
                            <option>Czech</option>
                            <option>Pennsylvania Dutch</option>
                            <option>Miao (hmong)</option>
                            <option>Norwegian</option>
                            <option>Slovak</option>
                            <option>Swedish</option>
                            <option>Serbocroatian</option>
                            <option>Kru</option>
                            <option>Rumanian</option>
                            <option>Lithuanian</option>
                            <option>Finnish</option>
                            <option>Panjabi</option>
                            <option>Formosan</option>
                            <option>Croatian</option>
                            <option>Turkish</option>
                            <option>Ilocano</option>
                            <option>Bengali</option>
                            <option>Danish</option>
                            <option>Syriac</option>
                            <option>Samoan</option>
                            <option>Malayalam</option>
                            <option>Cajun</option>
                            <option>Amharic</option>
                        </select>
                    </li>

                    <li><a href="{{url('films/history')}}" class="f-history">{{ __('观看历史') }}</a></li>
                    <li><a href="#" class="play-icon popup-with-zoom-anim f-history f-help">{{ __('帮助中心') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- //footer -->
</div>
<div class="clearfix"> </div>
<script>
    $('ul[class="nav nav-sidebar"]').children('li').each(function (){
        var str1 = $(this).text();
        var str2 = $('div[class="recommended-info"]').find('h3').html();
        if(str2==undefined)return;
        str1 = str1.substr(0,2);
        str2 = str2.substr(0,2);
        if(str1==str2){
            $(this).attr('class','active');
        }
    })
    $('#searchaction').click(function (){
        var searchText = $('#search').val();
        if(searchText=='')return;
        location.href = "{{url('films/search')}}"+'?search='+searchText;
    });
    if(getQueryString('menuType')!=null)$('#typesearch').show();

    $('#typesearch').change(function (){
        var str = location.href;
        str = str.replace('#','');
        var val = $(this).children('option:selected').val();
        if(val == -1){
            location.href = location.href.replace('&type='+getQueryString('type'),'');
            return;
        }
        if (getQueryString('type')==null){
            location.href = str+'&type='+val;
            return;
        }
        location.href = location.href.replace('type='+getQueryString('type'),'type='+val);
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
                $('#typesearch').append(str);
            }
            if(getQueryString('type')!=null){
                $('#typesearch').val(getQueryString('type'));
            }
        }
    })

    function sendEmail(){
        var email = $('input[name="email"]').val();
        if(email==''){
            showMessage('{{__('请先填写邮箱账号')}}');
            return;
        }
        if(email.search(/^[\d\w]+@[\d\w]+\.com$/)==-1){
            showMessage('{{__('邮箱账号不正确')}}');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{url('user/sendEmail')}}",
            type:'post',
            dataType:'json',
            data:{email:email},
            success:function (json){
                if(json.error_code==0){
                    showMessage('{{ __('验证码已发送，请在邮件中查收。') }}');
                }else{
                    showMessage('{{__('邮件发送失败')}}');
                }
            }
        })
    }
    function showMessage($msg){
        $('#emailStatus').find('p').text($msg);
        $('#emailStatus').show();
    }

    @if(count($errors)!=0)
        @if($errors->first('errorsShowType')=='register')
            $(function (){
                $('a[href="#small-dialog3"]').eq(0).trigger('click');
                $('div[class="signup"]').find('input').each(function () {
                    $(this).focus(function () {
                        $(this).removeClass('invalid');
                        $(this).nextUntil("input").hide();
                    })
                })
            })
        @else
            $(function (){
                $('a[href="#small-dialog"]').eq(0).trigger('click');
                $('div[class="signup"]').find('input').each(function () {
                    $(this).focus(function () {
                        $(this).removeClass('invalid');
                        $(this).nextUntil("input").hide();
                    })
                })
            })
        @endif
    @endif
</script>
</body>
</html>