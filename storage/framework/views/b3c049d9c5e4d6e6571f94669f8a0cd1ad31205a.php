<html>
<head>
    <script type="text/javascript" src="<?php echo e($azure['url']); ?>/habbo-web/assets/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo e($azure['url']); ?>/habbo-web/assets/js/swfobject.js"></script>
    <script type="text/javascript">
        var flashvars = {
            "external.texts.txt": "<?php echo e($azure['game']['gamedata']['texts']); ?>",
            "connection.info.port": "<?php echo e($azure['emulator']['port']); ?>",
            "furnidata.load.url": "<?php echo e($azure['game']['gamedata']['furnidata']); ?>",
            "external.variables.txt": "<?php echo e($azure['game']['gamedata']['variables']); ?>",
            "client.allow.cross.domain": "1",
            "url.prefix": "<?php echo e($azure['url']); ?>",
            "external.override.texts.txt": "<?php echo e($azure['game']['gamedata']['override_texts']); ?>",
            "supersonic_custom_css": "<?php echo e($azure['url']); ?>/habbo-web/assets/css/hotel.css",
            "external.figurepartlist.txt": "<?php echo e($azure['game']['gamedata']['figuredata']); ?>",
            "flash.client.origin": "popup",
            "client.starting": "Please Wait! <?php echo e($azure['name']); ?> is Loading...",
            "processlog.enabled": "1",
            "has.identity": "1",
            "avatareditor.promohabbos": "https://www.habbo.com.br/api/public/lists/hotlooks",
            "productdata.load.url": "<?php echo e($azure['game']['gamedata']['productdata']); ?>",
            "client.starting.revolving": "Quando voc\u00EA menos esperar...terminaremos de carregar.../Carregando mensagem divertida! Por favor espere./Voc\u00EA quer batatas fritas para acompanhar?/Siga o pato amarelo./O tempo \u00E9 apenas uma ilus\u00E3o./J\u00E1 chegamos?!/Eu gosto da sua camiseta./Olhe para um lado. Olhe para o outro. Pisque duas vezes. Pronto!/N\u00E3o \u00E9 voc\u00EA, sou eu./Shhh! Estou tentando pensar aqui./Carregando o universo de pixels.",
            "external.override.variables.txt": "<?php echo e($azure['game']['gamedata']['override_variables']); ?>",
            "spaweb": "1",
            "supersonic_application_key": "2c63c535",
            "connection.info.host": "<?php echo e($azure['emulator']['address']); ?>",
            "sso.ticket": "<?php echo e($user['token']); ?>",
            "client.notify.cross.domain": "0",
            "account_id": "<?php echo e($user['id']); ?>",
            "flash.client.url": "<?php echo e($azure['game']['gordon']); ?>",
            "unique_habbo_id": "<?php echo e($user['id']); ?>",
        };
    </script>
    <script type="text/javascript"
            src="<?php echo e($azure['url']); ?>/habbo-web/habboapi.js"></script>
    <script type="text/javascript">
        var params = {
            "base": "<?php echo e($azure['game']['gordon']); ?>",
            "allowScriptAccess": "always",
            "menu": "false",
            "wmode": "opaque"
        };
        swfobject.embedSWF('<?php echo e($azure['game']['flash']); ?>', 'flash-container', '100%', '100%', '11.1.0', ' <?php echo e($azure['url']); ?>/habbo-web/assets/flash/expressInstall.swf', flashvars, params, null, null);
    </script>
    <style type="text/css" media="screen">
        #flash-container {
            visibility: hidden
        }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo e($azure['url']); ?>/habbo-web/assets/css/hotel.css">
</head>
<body>
<div id="client-ui">
    <div id="flash-wrapper">
        <div id="flash-container">
            <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
                <p>FLASH NOT INSTALLED</p>
                <p>
                    <a href="https://www.adobe.com/go/getflashplayer">
                        <img src="<?php echo e($azure['url']); ?>/habbo-web/assets/images/Get_Flash_Player.png"
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