<html>
<head>
    <script type="text/javascript" src="{{$chocolatey->hotelUrl}}/habbo-web/assets/js/jquery.js"></script>
    <script type="text/javascript" src="{{$chocolatey->hotelUrl}}/habbo-web/assets/js/swfobject.js"></script>
    <script type="text/javascript">
        var flashvars = {
            "external.texts.txt": "{{$chocolatey->game->gamedata->texts}}",
            "connection.info.port": "{{$chocolatey->emulator->port}}",
            "furnidata.load.url": "{{$chocolatey->game->gamedata->furnidata}}",
            "external.variables.txt": "{{$chocolatey->game->gamedata->variables}}",
            "client.allow.cross.domain": "1",
            "url.prefix": "{{$chocolatey->hotelUrl}}",
            "external.override.texts.txt": "{{$chocolatey->game->gamedata->overrideTexts}}",
            "supersonic_custom_css": "{{$chocolatey->hotelUrl}}/habbo-web/assets/css/hotel.css",
            "external.figurepartlist.txt": "{{$chocolatey->game->gamedata->figuredata}}",
            "flash.client.origin": "popup",
            "client.starting": "Please wait! {{$chocolatey->hotelName}} is starting up.",
            "processlog.enabled": "1",
            "has.identity": "1",
            "avatareditor.promohabbos": "https://www.habbo.com.br/api/public/lists/hotlooks",
            "productdata.load.url": "{{$chocolatey->game->gamedata->productdata}}",
            "external.override.variables.txt": "{{$chocolatey->game->gamedata->overrideVariables}}",
            "spaweb": "1",
            "supersonic_application_key": "2c63c535",
            "connection.info.host": "{{$chocolatey->emulator->address}}",
            "sso.ticket": "{{$token}}",
            "client.notify.cross.domain": "0",
            "account_id": "{{$user->uniqueId}}",
            "flash.client.url": "{{$chocolatey->game->gordon}}",
            "unique_habbo_id": "{{$user->uniqueId}}",
            "client.starting.revolving": "{!! implode('/', $chocolatey->loading) !!}",
            "habbopages.url": "{{$chocolatey->hotelUrl}}/habbo-pages/",
            @if($newUser)
                "new.user.flow.enabled": "true",
                "new.user.flow.onboarding.choose.your.room": "Choose your room",
                "new.user.flow.figure.ok": "Figure change ok!",
                "new.user.flow.onboarding.what.is.hc": "{{$chocolatey->hotelName}} Club is designed for you to express yourself better than ever! It also has other useful benefits: outfits, rewards, room layouts, a special Shop, extended friends lists, preferential access in queues and room, and extended room limits.",
                "new.user.flow.onboarding.button.select.room": "I want this room",
                "new.user.flow.rename.submit": "Done",
                "new.user.flow.onboarding.button.ready": "I\'m ready",
                "new.user.flow.room.name.12": "Sunshine Lounge",
                "new.user.flow.room.name.11": "Penumbra Penthouse",
                "new.user.flow.room.name.10": "Home Shiny Home",
                "new.user.flow.onboarding.this.is.your.habbo": "This is your Habbo",
                "new.user.flow.onboarding.room.information": "Choose your first room to get you started! You can create more rooms for free later.",
                "new.user.flow.gender": "Gender",
                "new.user.flow.onboarding.your.colour": "Choose colour",
                "new.user.flow.loader.waiting": "is warmed up!",
                "new.user.flow.bodyparts": "Body parts",
                "new.user.flow.rename.subtitle": "4-15 characters, letters and numbers accepted",
                "new.user.flow.header": "For choosing Habbo!",
                "new.user.flow.room.select": "Select",
                "new.user.flow.intro3": "Just one more thing! Tell us what kind of room you want to start with. It\'s not for life, so don\'t overthink it!",
                "new.user.flow.intro2": "Looking good! Next, give your {{$chocolatey->hotelName}} a name. (Or skip and think of a good one later)",
                "new.user.onboarding.hc.flow.enabled": "true",
                "new.user.flow.onboarding.choose.your.name": "Choose your name",
                "new.user.flow.colors": "Colours",
                "new.user.flow.onboarding.creative.tip": "There are tons of Habbos created each day, so get creative!",
                "new.user.flow.onboarding.cant.decide": "Can't decide? Don't worry, you can change your clothes later!",
                "new.user.flow.onboarding.get.hc.button": "Get {{$chocolatey->hotelName}} Club!",
                "new.user.flow.onboard.what.is.hc.header": "Much more inside...",
                "new.user.flow.gender.girl": "Girl",
                "new.user.flow.loader": "is starting up...",
                "new.user.flow.onboarding.info.hc": "What is {{$chocolatey->hotelName}} Club?<br>{{$chocolatey->hotelName}} Club is a special club you can join to get access to more clothing styles, exclusive room designs, more space on your friends list and lots more.",
                "new.user.flow.onboarding.button.remove.items": "Remove items",
                "new.user.flow.onboarding.your.looks": "Choose looks",
                "new.user.flow.note.header": "For choosing Habbo!",
                "new.user.flow.save": "I'll wear this!",
                "new.user.flow.onboarding.hint.hc": "You've selected {{$chocolatey->hotelName}} club items but you'll have to purchase it to wear them!",
                "new.user.flow.onboard.what.is.hc.description": "What is {{$chocolatey->hotelName}} Club?\n{{$chocolatey->hotelName}} Club is a special club you can join to get access to more clothing styles, exclusive room designs, more space on your friends list and lots more",
                "new.user.flow.galleryUrl": "http://habboo-a.akamaihd.net/c_images/nux/",
                "new.user.reception.minLength": "2",
                "new.user.flow.page": "1",
                "new.user.flow.title": "Thank You",
                "new.user.flow.roomTypes": "10,11,12",
                "new.user.onboarding.show.hc.items": "false",
                "new.user.flow.name": "{{$user->name}}",
                "new.user.reception.maxLength": "15",
                "new.user.flow.onboarding.characters.tip": "TIP: 3-15 characters, letters, numbers and underscores are accepted.",
                "new.user.flow.rename.warning": "TIP: There are tons of Habbos created every day, and your name must be unique, so be creative! You can also use these special characters: _-",
                "new.user.flow.rename.title": "Name your Habbo:",
                "new.user.flow.intro": "While we're preparing your check-in, please choose your first looks from this selection:",
                "new.user.flow.onboarding.choose.your.style": "Choose your style",
                "new.user.flow.onboarding.hint.hc.header": "Wait a second!",
                "new.user.flow.clothes": "Clothes",
                "new.user.flow.gender.boy": "Boy",
                "new.user.flow.figure.error": "Figure change error!",
                "new.user.flow.note.title": "Thank You",
                "new.user.flow.rename.skip": "Skip for now",
                "new.user.flow.room.description.12": "Ambient retro Lava Lamp glow included",
                "new.user.flow.room.description.11": "Ain't no party like a Penumbra party!",
                "new.user.flow.room.description.10": "For the {{$chocolatey->hotelName}} who really likes shiny things",
            @endif
        };
    </script>
    <script type="text/javascript"
            src="{{$chocolatey->hotelUrl}}/habbo-web/habboapi.min.js"></script>
    <script type="text/javascript">
        var params = {
            "base": "{{$chocolatey->game->gordon}}",
            "allowScriptAccess": "always",
            "menu": "false",
            "wmode": "opaque"
        };
        swfobject.embedSWF('{{$chocolatey->game->flash}}', 'flash-container', '100%', '100%', '11.1.0', ' {{$chocolatey->hotelUrl}}/habbo-web/assets/flash/expressInstall.swf', flashvars, params, null, null);
    </script>
    <style type="text/css" media="screen">
        #flash-container {
            visibility: hidden
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{$chocolatey->hotelUrl}}/habbo-web/assets/css/hotel.css">
</head>
<body>
<div id="client-ui">
    <div id="flash-wrapper">
        <div id="flash-container">
            <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
                <p>FLASH NOT INSTALLED</p>
                <p>
                    <a href="https://www.adobe.com/go/getflashplayer">
                        <img src="{{$chocolatey->hotelUrl}}/habbo-web/assets/images/get_flash_player.png"
                             alt="Get Adobe Flash player"/>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div id="content" class="client-content"></div>
    <iframe id="page-content" class="hidden" allowtransparency="true" frameborder="0" src="../../../index.php"></iframe>
</div>
</body>
</html>
