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
$app->get('habbo-web-l10n/', function () {
    return response('Unauthorized.', 401);
});

// Render a specific Language Ecosystem
$app->get('habbo-web-l10n/{language}', 'LanguageController@render');
