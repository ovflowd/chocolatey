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
                <div class="box"><h1>Espreso not ready!</h1>

                    <p><b>Sorry.</b> But Espreso Integration isn't working properly.
                        This happen because you didn't configured espreso integration correctly, or, Espreso is still
                        under development.</p>
                    <a href="/">You can go back to earlier page.</a>
                    <img style="float:right" src="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/frank.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>