<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'MFilms') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script src="https://unpkg.com/videojs-contrib-hls/dist/videojs-contrib-hls.js"></script>
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
</head>
<body>
    @if(strpos($mUrl,'.m3u8')!==false||strpos($mUrl,'.M3U8')!==false)
        <video id="my_video_1" class="video-js vjs-default-skin fillWidth" controls width="640" height="268"data-setup='{}'>
            <source src="{{$mUrl}}" type="application/x-mpegURL">
        </video>
    @else
        <video id="my_video_1" src="{{$mUrl}}" width="320" height="240" controls="controls">
        </video>
    @endif
</body>
</html>
<script>
    var w = $(document).width();
    var h = $(document).height();
    $('#my_video_1').attr('width',w);
    $('#my_video_1').attr('height',h);
</script>