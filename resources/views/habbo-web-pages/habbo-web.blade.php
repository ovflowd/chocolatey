<!DOCTYPE html>
<html ng-app="app">
<head>
    <html ng-app="app" lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="NOODP">
        <title>{{$chocolatey->hotelName}}</title>
        <meta name="description"
              content="Join millions in the planet&apos;s most popular virtual world for teens. Create your avatar, meet new friends, role play, and build amazing spaces.">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{$chocolatey->hotelName}}">
        <meta property="og:title" content="{{$chocolatey->hotelName}}">
        <meta property="og:description"
              content="Join millions in the planet&apos;s most popular virtual world for teens. Create your avatar, meet new friends, role play, and build amazing spaces.">
        <meta property="og:image:height" content="628">
        <meta property="og:image:width" content="1200">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{$chocolatey->hotelName}}">
        <meta name="twitter:description"
              content="Join millions in the planet&apos;s most popular virtual world for teens. Create your avatar, meet new friends, role play, and build amazing spaces.">
        <meta name="twitter:site" content="{{$chocolatey->twitter->title}}">
        <meta name="fragment" content="!">
        <meta name="revision" content="f05e1ca">
        <meta name="viewport"
              content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="prerender-status-code" prerender-status-code="">
        <meta name="prerender-header" prerender-header="">
        <link rel="shortcut icon" href="{{$chocolatey->hotelUrl}}/habbo-web/favicon.ico">
        <link rel="stylesheet" href="{{$chocolatey->hotelUrl}}/habbo-web/app.css">
        <script>
            !function () {
                var e = document.createElement("link"), t = document.getElementsByTagName("script")[0];
                e.href = "https://fonts.googleapis.com/css?family=Ubuntu:regular,bold|Ubuntu+Condensed:regular", e.rel = "stylesheet", t.parentNode.insertBefore(e, t)
            }();
        </script>
        <script>
            window.session = {!! $user !!};
            window.chocolatey = {captcha: '{{$chocolatey->recaptcha}}', facebook: '{{$chocolatey->facebook->app->key}}', url: '{{$chocolatey->hotelUrl}}/', name: '{{$chocolatey->hotelName}}', lang: '{{$chocolatey->siteLanguage}}', album: '{{$chocolatey->badgeRepository}}', plang: '{{env('APP_LOCALE', 'en')}}'};
            window.geoLocation = {!! json_encode((object)$chocolatey->location) !!};
            window.partnerCodeInfo = null;
            window.banner = null;
        </script>
    </head>
<body habbo-client-disable-scrollbars ng-cloak>
<div class="content" ui-view></div>
<habbo-footer></habbo-footer>
<div habbo-require-session>
    <habbo-client></habbo-client>
</div>
<habbo-eu-cookie-banner habbo-require-no-session></habbo-eu-cookie-banner>
<script src="{{$chocolatey->hotelUrl}}/habbo-web/vendor.min.js"></script>
<script src="{{$chocolatey->hotelUrl}}/habbo-web/scripts.min.js"></script>
</body>
</html>