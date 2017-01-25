<?php

/*
|--------------------------------------------------------------------------
| Habbo Main Route
|--------------------------------------------------------------------------
|
| Here it's registered the main Route
| This Route redirects to HabboWEB
|
*/

# Main Request Route

$app->get('/', 'HomePageController@show');

/*
|--------------------------------------------------------------------------
| Habbo API Routes
|--------------------------------------------------------------------------
|
| Here are registered all main HabboWEB api routes
| You can simply went to their respective controllers.
|
*/

# Main API Request is Forbidden
$app->get('/api', function () {
    return response('Unauthorized.', 401);
});

# Create an User Request
$app->post('api/public/registration/new', 'LoginController@register');
// POST - email, password, birthdate
// E-mail In Use: 409 - {"error":"registration_email_in_use"}
// Invalid E-mail: 409 - {"error":"registration_email"}
// Success: 201 Created - User Eloquent Model - {"uniqueId":"hhus-5dd3e36949a92469504763c979c85f31","name":"knightgoogl","figureString":"hr-892-46.hd-209-8.ch-260-79.lg-280-77.sh-906-68.ha-1003-80","motto":"","buildersClubMember":false,"habboClubMember":false,"lastWebAccess":null,"creationTime":"2017-01-25T18:08:42.000+0000","sessionLogId":148536598799567460,"loginLogId":148536772168646750,"email":"google@uiot.org","identityId":25754090,"emailVerified":false,"identityVerified":false,"identityType":"HABBO","trusted":true,"force":["NONE"],"accountId":63205925,"country":null,"traits":["NEW_USER","USER"],"partner":"NO_PARTNER"}

# Confirm E-mail
$app->post('api/public/registration/activate', 'AccountController@confirmActivation');
// URI: /activate/{{TOKEN}}
// POST - token
// Invalid Token: 400 {"error":"activation.invalid_token"}
// Success: 200 {"email":"claudio.santoro@uiot.org","emailVerified":true,"identityVerified":true}

# Confirm E-mail
$app->post('api/public/forgotPassword/changePassword', 'AccountSecurityController@confirmChangePassword');
// URI: /reset-password/{{TOKEN}}
// POST - password, token
// Invalid Token: 404 - No Content
// Used password in past: 400 - {"error":"password.used_earlier"}
// Success: 204 - No Content

# Middleware that Requires Authentication
$app->group(['middleware' => 'auth'], function () use ($app) {
    # Authenticate User
    $app->post('api/public/authentication/login', 'LoginController@attempt');

    # Client URL
    $app->get('api/client/clienturl', 'ClientController@getUrl');
    // GET 200 - {"clienturl":"https://www.habbo.com/client/hhus-5dd3e36949a92469504763c979c85f31/c3bb8cc5-ddcc-4d2c-9589-65acbfbcdcca-63205925"}

    # Change Password Request
    $app->post('api/settings/password/change', 'AccountSecurityController@changePassword');
    // POST - currentPassword, password, passwordRepeated
    // Invalid Password 409 {"error":"password.current_password.invalid"}
    // Same as past 409 {"error":"password.used_earlier"}
    // Success 204 - No Content

    # Resend E-mail Verification
    $app->post('api/settings/email/verification-resend', 'MailController@verify');
    // POST - No Item - Send E-mail

    # User Privacy Settings
    $app->post('api/user/preferences', 'AccountController@getPreferences');
    // POST - emailFriendRequestNotificationEnabled, emailGiftNotificationEnabled, emailGroupNotificationEnabled, emailMiniMailNotificationEnabled, emailNewsletterEnabled, emailRoomMessageNotificationEnabled, friendCanFollow, friendRequestEnabled, offlineMessagingEnabled, onlineStatusVisible, profileVisible
    // Success: 200 - No Content

    # User Privacy Settings Changes
    $app->get('api/user/preferences/save', 'AccountController@savePreferences');
    // GET 200 - {"profileVisible":true,"onlineStatusVisible":true,"friendCanFollow":true,"friendRequestEnabled":true,"offlineMessagingEnabled":true,"emailNewsletterEnabled":true,"emailMiniMailNotificationEnabled":true,"emailFriendRequestNotificationEnabled":true,"emailGiftNotificationEnabled":true,"emailRoomMessageNotificationEnabled":true,"emailGroupNotificationEnabled":true}

    # User Security Settings Request
    $app->get('api/safetylock/featureStatus', 'AccountSecurityController@featureStatus');
    // GET 200 (Account not Confirmed) - identity_verification_required
    // GET 200 (Feature Disabled) - disabled
    // GET 200 (Feature Enabled) - enabled

    # User Security Settings Save
    $app->post('api/safetylock/save', 'AccountSecurityController@saveQuestions');
    // POST - answer1, answer2, password, questionId1, questionId2
    // Success: 204 - No Content
    // Invalid Password: 400 {"error":"invalid_password"}

    # User Security Settings Disable
    $app->get('api/safetylock/disable', 'AccountSecurityController@disable');
    // GET 204 - No Content

    # User Security Settings Reset Devices
    $app->get('api/safetylock/resetTrustedLogins', 'AccountSecurityController@reset');
    // GET 204 - No Content

    # Resend E-mail Verification
    $app->post('api/settings/email/change', 'AccountSecurityController@changeMail');
    // POST - currentPassword, newEmail
    // E-mail in Use: 400 {"error":"changeEmail.email_already_in_use"}
    // Invalid E-mail: 400 {"error":"registration_email"}
    // Success: 200 {"email":"google@uiot.org"} - Send E-mail

    # Logout User
    $app->post('api/public/authentication/logout', 'LoginController@logout');
});


/*
|--------------------------------------------------------------------------
| Habbo ShopAPI Routes
|--------------------------------------------------------------------------
|
| Here are registered all shop pages related routes
| You can simply went to their respective controllers.
|
*/

# Main ShopAPI Request is Forbidden
$app->get('/shopapi', function () {
    return response('Unauthorized.', 401);
});

/*
|--------------------------------------------------------------------------
| Habbo Extradata Routes
|--------------------------------------------------------------------------
|
| Here we registered all Extradata Routes
| You can simply went to their respective controllers.
|
*/

# Main Extradata Request is Forbidden
$app->get('/extradata', function () {
    return response('Unauthorized.', 401);
});

# Show All Registered HabboWEB Photos
$app->get('/extradata/public/photos', 'PublicPhotosController@show');

# Public Stories
$app->get('/extradata/public/users/stories', function () {
    return response()->json('aaa');
});

# Middleware that Requires Authentication
$app->group(['middleware' => 'auth'], function () use ($app) {
    # Report a Specific Photo
    $app->post('/extradata/private/creation/{photo}/report', 'PublicPhotosController@report');
});

/*
|--------------------------------------------------------------------------
| Habbo WebPages Routes
|--------------------------------------------------------------------------
|
| Here are registered all HabboWEB Pages Routes
| Those Routes are special, like News, Advertisement, and others.
|
*/

# Main HabboPAGES Request is Forbidden
$app->get('/habbo-web-pages/', function () {
    return response('Unauthorized.', 401);
});

# Request a Specific View of HabboWEB Pages
$app->get('/habbo-web-pages/production/{category}/{view}', 'PageController@show');

/*
|--------------------------------------------------------------------------
| Habbo WebNEWS Routes
|--------------------------------------------------------------------------
|
| Here are registered all HabboWEB Pages Routes
| Those Routes are special, like News, Advertisement, and others.
|
*/

# Main HabboNEWS Request is Forbidden
$app->get('/habbo-web-news/', function () {
    return response('Unauthorized.', 401);
});

# Request a set of Articles, generally a category or front page
$app->get('/habbo-web-news/{country}/production/{view}', 'ArticleController@many');

# Request a single Article generally when you access directly an Article
$app->get('/habbo-web-news/{country}/production/articles/{article}', 'ArticleController@one');

/*
|--------------------------------------------------------------------------
| Habbo WEB Languages
|--------------------------------------------------------------------------
|
| Here are registered all main HabboWEB Language Pages
| You can simply went to their respective controllers.
|
*/

# Main HabboLanguages Request is Forbidden
$app->get('/habbo-web-l10n/', function () {
    return response('Unauthorized.', 401);
});

# Render a specific Language Ecosystem
$app->get('/habbo-web-l10n/{language}', 'LanguageController@render');