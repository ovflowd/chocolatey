<?php

/*
|--------------------------------------------------------------------------
| Habbo WEB Languages
|--------------------------------------------------------------------------
|
| Here are registered all main HabboWEB Language Pages
| You can simply went to their respective controllers.
|
*/

// Main HabboLanguages Request is Forbidden
$router->get('habbo-web-l10n/', function () {
    return response('Unauthorized.', 401);
});

// Render a specific Language Ecosystem
$router->get('habbo-web-l10n/{language}', 'LanguageController@render');
