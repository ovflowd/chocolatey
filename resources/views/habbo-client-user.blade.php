<html>
<head>
    <script type="text/javascript" src="{{$chocolatey['url']}}/habbo-web/assets/js/jquery.js"></script>
    <script type="text/javascript" src="{{$chocolatey['url']}}/habbo-web/assets/js/swfobject.js"></script>
    <script type="text/javascript">
        var flashvars = {
            "external.texts.txt": "{{$chocolatey['game']['gamedata']['texts']}}",
            "connection.info.port": "{{$chocolatey['emulator']['port']}}",
            "furnidata.load.url": "{{$chocolatey['game']['gamedata']['furnidata']}}",
            "external.variables.txt": "{{$chocolatey['game']['gamedata']['variables']}}",
            "client.allow.cross.domain": "1",
            "url.prefix": "{{$chocolatey['url']}}",
            "external.override.texts.txt": "{{$chocolatey['game']['gamedata']['override_texts']}}",
            "supersonic_custom_css": "{{$chocolatey['url']}}/habbo-web/assets/css/hotel.css",
            "external.figurepartlist.txt": "{{$chocolatey['game']['gamedata']['figuredata']}}",
            "flash.client.origin": "popup",
            "client.starting": "Please Wait! {{$chocolatey['name']}} is Loading...",
            "processlog.enabled": "1",
            "has.identity": "1",
            "avatareditor.promohabbos": "https://www.habbo.com.br/api/public/lists/hotlooks",
            "productdata.load.url": "{{$chocolatey['game']['gamedata']['productdata']}}",
            "client.starting.revolving": "Quando voc\u00EA menos esperar...terminaremos de carregar.../Carregando mensagem divertida! Por favor espere./Voc\u00EA quer batatas fritas para acompanhar?/Siga o pato amarelo./O tempo \u00E9 apenas uma ilus\u00E3o./J\u00E1 chegamos?!/Eu gosto da sua camiseta./Olhe para um lado. Olhe para o outro. Pisque duas vezes. Pronto!/N\u00E3o \u00E9 voc\u00EA, sou eu./Shhh! Estou tentando pensar aqui./Carregando o universo de pixels.",
            "external.override.variables.txt": "{{$chocolatey['game']['gamedata']['override_variables']}}",
            "spaweb": "1",
            "supersonic_application_key": "2c63c535",
            "connection.info.host": "{{$chocolatey['emulator']['address']}}",
            "sso.ticket": "{{$token}}",
            "client.notify.cross.domain": "0",
            "account_id": "{{$user['uniqueId']}}",
            "flash.client.url": "{{$chocolatey['game']['gordon']}}",
            "unique_habbo_id": "{{$user['id']}}",
        };
    </script>
    <script type="text/javascript"
            src="{{$chocolatey['url']}}/habbo-web/habboapi.js"></script>
    <script type="text/javascript">
        var params = {
            "base": "{{$chocolatey['game']['gordon']}}",
            "allowScriptAccess": "always",
            "menu": "false",
            "wmode": "opaque"
        };
        swfobject.embedSWF('{{$chocolatey['game']['flash']}}', 'flash-container', '100%', '100%', '11.1.0', ' {{$chocolatey['url']}}/habbo-web/assets/flash/expressInstall.swf', flashvars, params, null, null);
    </script>
    <style type="text/css" media="screen">
        #flash-container {
            visibility: hidden
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{$chocolatey['url']}}/habbo-web/assets/css/hotel.css">
</head>
<body>
<div id="client-ui">
    <div id="flash-wrapper">
        <div id="flash-container">
            <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
                <p>FLASH NOT INSTALLED</p>
                <p>
                    <a href="https://www.adobe.com/go/getflashplayer">
                        <img src="{{$chocolatey['url']}}/habbo-web/assets/images/get_flash_player.png"
                             alt="Get Adobe Flash player"/>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div id="content" class="client-content"></div>
    <iframe id="page-content" class="hidden" allowtransparency="true" frameborder="0" src="about:blank"></iframe>
</div>
</body>
</html>
