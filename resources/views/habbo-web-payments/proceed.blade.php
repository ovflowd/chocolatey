<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="{{$chocolatey->hotelUrl}}/habbo-web/assets/css/habbo.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Ubuntu:normal|Ubuntu+Condensed:normal" rel=stylesheet>
</head>
<body>
<div class="center">
    <img src="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/load_anim_sml.png"
         srcset="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/load_anim_sml.png 1x, {{$chocolatey->hotelUrl}}/habbo-web/assets/images/load_anim_sml_big.png 2x"
         class="spinner spinner--small"
         alt="Loading"
         width="32"
         height="32">
    <img src="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/load_anim_lrg.png"
         srcset="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/load_anim_lrg.png 1x, /{{$chocolatey->hotelUrl}}/habbo-web/assets/images/load_anim_lrg_big.png 2x"
         class="spinner spinner--large"
         alt="Loading"
         width="68"
         height="68">

    <form id="startPaymentForm" method="post" action="{{$payment->redirect}}">
        <input type="hidden" name="item_id" value="{{$payment->item}}">
        <input type="hidden" name="id" value="{{$payment->id}}">
        <input type="hidden" name="token" value="NOT_USED_YET">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.getElementById('startPaymentForm').submit();
            }, 100);
        });
    </script>
</div>
</body>
</html>
