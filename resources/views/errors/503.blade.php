<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$chocolatey->hotelName}}</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="{{$chocolatey->hotelUrl}}/habbo-web/favicon.ico">
    <link rel="stylesheet" type="text/css" href="{{$chocolatey->hotelUrl}}/habbo-web/assets/css/maintenance.css">
    <script>
        !function () {
            var e = document.createElement("link"), t = document.getElementsByTagName("script")[0];
            "http:" !== window.location.protocol && "https:" !== window.location.protocol && (e.href = "http:"), e.href += "//fonts.googleapis.com/css?family=Ubuntu:regular,bold|Ubuntu+Condensed:lighter,regular,bold", e.rel = "stylesheet", e.type = "text/css", t.parentNode.insertBefore(e, t)
        }()
    </script>
</head>
<body>
<div class="content">
    <div class="header">
        <div class="wrapper"><a href="{{$chocolatey->hotelUrl}}/" class="habbo-image"></a></div>
    </div>
    <div class="wrapper">
        <div class="page-content">
            <div class="main">
                <div class="box with-bottom-error-image"><h1>{{$maintenance->title}}</h1>
                    <p>{{$maintenance->text}}</p>
                </div>
            </div>
            <div class="aside">
                <a class="twitter-timeline" data-width="300" data-height="400"
                   href="https://twitter.com/{{$chocolatey->twitter->username}}">{{$chocolatey->twitter->title}}</a>
                <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
        </div>
    </div>
</div>
</body>
</html>