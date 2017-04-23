<?php

/*
|--------------------------------------------------------------------------
| Habbo API Routes
|--------------------------------------------------------------------------
|
| Here are registered all main HabboWEB api routes
| You can simply went to their respective controllers.
|
*/

// Logout User
$app->post('api/public/authentication/logout', 'LoginController@logout');

// Maintenance Middleware
$app->group(['middleware' => 'maintenance'], function () use ($app) {

    // Main API Request is Forbidden
    $app->get('api', function () {
        return response('Unauthorized.', 401);
    });

    // Go to Help Page
    $app->get('api/public/help', function () {
        return redirect('https://help.habbo.com/');
    });

    // Get Data from a Room
    $app->get('api/public/rooms/{room}', 'RoomsController@getRoom');

    // Get User Public Data
    $app->get('api/public/users', 'ProfileController@getPublicData');

    // Get User Public Data
    $app->get('api/public/users/{userId}/profile', 'ProfileController@getPublicProfile');

    // Create an User Request
    $app->post('api/public/registration/new', 'LoginController@register');

    // Confirm E-mail
    $app->post('api/public/registration/activate', 'AccountSecurityController@confirmActivation');

    // Change Password Request
    $app->post('api/public/forgotPassword/send', 'AccountController@forgotPassword');

    // Confirm E-mail
    $app->post('api/public/forgotPassword/changePassword', 'AccountSecurityController@confirmChangePassword');

    // Authenticate User
    $app->post('api/public/authentication/login', 'LoginController@login');

    // Facebook Login
    $app->post('api/public/authentication/facebook', 'LoginController@facebook');

    // Middleware that Requires Authentication
    $app->group(['middleware' => 'auth'], function () use ($app) {

        // Get Client URL
        $app->get('api/client/clienturl', 'ClientController@getUrl');

        // Get Client View
        $app->get('client/habbo-client', 'ClientController@showClient');

        // User Privacy Settings
        $app->get('api/user/preferences', 'AccountController@getPreferences');

        // User Security Settings Request
        $app->get('api/safetylock/featureStatus', 'AccountSecurityController@featureStatus');

        // User Security Settings Disable
        $app->get('api/safetylock/disable', 'AccountSecurityController@disable');

        // User Security Settings getQuestions
        $app->get('api/safetylock/questions', 'AccountSecurityController@getQuestions');

        // Get User (AzureID) Avatars
        $app->get('api/user/avatars', 'AccountController@getAvatars');

        // Get User Public Data
        $app->get('api/user/profile', 'ProfileController@getProfile');

        // Get User (AzureID) Avatars
        $app->get('api/user/avatars/check-name', 'AccountController@checkName');

        // User Messenger Not Read Discussions
        $app->get('api/user/discussions', 'AccountController@getDiscussions');

        // User Security Settings Reset Devices
        $app->get('api/safetylock/resetTrustedLogins', 'AccountSecurityController@reset');

        // Change Password Request
        $app->post('api/settings/password/change', 'AccountSecurityController@changePassword');

        // Resend E-mail Verification
        $app->post('api/settings/email/verification-resend', 'AccountController@verifyAccount');

        // User Privacy Settings Changes
        $app->post('api/user/preferences/save', 'AccountController@savePreferences');

        // User Security Settings Save
        $app->post('api/safetylock/save', 'AccountSecurityController@saveQuestions');

        // User Security Settings Verify Questions
        $app->post('api/safetylock/unlock', 'AccountSecurityController@verifyQuestions');

        // Resend E-mail Verification
        $app->post('api/settings/email/change', 'AccountSecurityController@changeMail');

        // New User Client Check
        $app->post('api/newuser/name/check', 'NuxController@checkName');

        // New User Client Select Username
        $app->post('api/newuser/name/select', 'NuxController@selectName');

        // New User Client Select Room
        $app->post('api/newuser/room/select', 'NuxController@selectRoom');

        // Save User Look
        $app->post('api/user/look/save', 'AccountController@saveLook');

        // Create a New User Avatar
        $app->post('api/user/avatars', 'AccountController@createAvatar');

        // Select an User Avatar
        $app->post('api/user/avatars/select', 'AccountController@selectAvatar');

        // Habbo Client Login step
        $app->post('api/log/loginstep', function () {
            return response()->json(null, 204);
        });
    });
});
