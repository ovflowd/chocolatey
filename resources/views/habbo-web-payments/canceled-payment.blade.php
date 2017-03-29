<html>
<head>
    <title>Your payment failed</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="{{$chocolatey->hotelUrl}}/habbo-web/assets/css/habbo.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Ubuntu:normal|Ubuntu+Condensed:normal" rel=stylesheet>
</head>
<body>
<div class="center">
    <img src="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/credits_teaser_error.png"
         srcset="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/credits_teaser_error.png 1x,{{$chocolatey->hotelUrl}}/habbo-web/assets/images/credits_teaser_error_big.png 2x"
         alt="Error"
         width="145"
         height="146">
    <h1>They Payment Process was Canceled</h1>
    <p>Try again later.</p>
    <button onclick="window.close();">OK</button>

    <script>
        window.opener.postMessage({status: 'ERROR'}, '*');
    </script>

</div>
</body>
</html>
