<?php $azure = \Illuminate\Support\Facades\Config::get('chocolatey'); ?>
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$azure['name']}}</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="{{$azure['url']}}habbo-web/favicon.ico">
    <link rel="stylesheet" type="text/css"
          href="{{$azure['url']}}/habbo-web/assets/css/maintenance.css">
    <script id="twitter-wjs" src="https://platform.twitter.com/widgets.js"></script>
    <script>!function () {
            var e = document.createElement("link"), t = document.getElementsByTagName("script")[0];
            "http:" !== window.location.protocol && "https:" !== window.location.protocol && (e.href = "http:"), e.href += "//fonts.googleapis.com/css?family=Ubuntu:regular,bold|Ubuntu+Condensed:lighter,regular,bold", e.rel = "stylesheet", e.type = "text/css", t.parentNode.insertBefore(e, t)
        }()</script>
</head>
<body>
<div class="content">
    <div class="header">
        <div class="wrapper"><a href="{{$azure['url']}}" class="habbo-image"></a></div>
    </div>
    <div class="wrapper">
        <div class="page-content">
            <div class="main">
                <div class="box with-bottom-error-image"><h1>Stop! Maintenance</h1>

                    <p>We're really sorry but we're on Maintenance. You can check further updates
                        by accessing our Twitter.
                        We apologize a lot about this</p></div>
            </div>
            <div class="aside"><a class="twitter-timeline" href="https://twitter.com/{{$azure['twitter']['username']}}"
                                  data-widget-id="{{$azure['twitter']['key']}}" height="400"
                                  width="300">{{$azure['twitter']['name']}}</a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = p + "://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, "script", "twitter-wjs");</script>
            </div>
        </div>
    </div>
</div>
</body>
</html>