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
$router->post('api/public/authentication/logout', 'LoginController@logout');

// Maintenance Middleware
$router->group(['middleware' => 'maintenance'], function () use ($router) {

    // Main API Request is Forbidden
    $router->get('api', function () {
        return response('Unauthorized.', 401);
    });

    // Go to Help Page
    $router->get('api/public/help', function () {
        return redirect('https://help.habbo.com/');
    });

    // Get Data from a Room
    $router->get('api/public/rooms/{room}', 'RoomsController@getRoom');

    // Get User Public Data
    $router->get('api/public/users', 'ProfileController@getPublicData');

    // Get User Public Data
    $router->get('api/public/users/{userId}/profile', 'ProfileController@getPublicProfile');

    // Create an User Request
    $router->post('api/public/registration/new', 'LoginController@register');

    // Confirm E-mail
    $router->post('api/public/registration/activate', 'AccountSecurityController@confirmActivation');

    // Change Password Request
    $router->post('api/public/forgotPassword/send', 'AccountController@forgotPassword');

    // Confirm E-mail
    $router->post('api/public/forgotPassword/changePassword', 'AccountSecurityController@confirmChangePassword');

    // Authenticate User
    $router->post('api/public/authentication/login', 'LoginController@login');

    // Facebook Login
    $router->post('api/public/authentication/facebook', 'LoginController@facebook');

    // Middleware that Requires Authentication
    $router->group(['middleware' => 'auth'], function () use ($router) {

        // Get Client URL
        $router->get('api/client/clienturl', 'ClientController@getUrl');

        // Get Client View
        $router->get('client/habbo-client', 'ClientController@showClient');

        // User Privacy Settings
        $router->get('api/user/preferences', 'AccountController@getPreferences');

        // User Security Settings Request
        $router->get('api/safetylock/featureStatus', 'AccountSecurityController@featureStatus');

        // User Security Settings Disable
        $router->get('api/safetylock/disable', 'AccountSecurityController@disable');

        // User Security Settings getQuestions
        $router->get('api/safetylock/questions', 'AccountSecurityController@getQuestions');

        // Get User (AzureID) Avatars
        $router->get('api/user/avatars', 'AccountController@getAvatars');

        // Get User Public Data
        $router->get('api/user/profile', 'ProfileController@getProfile');

        // Get User (AzureID) Avatars
        $router->get('api/user/avatars/check-name', 'AccountController@checkName');

        // User Messenger Not Read Discussions
        $router->get('api/user/discussions', 'AccountController@getDiscussions');

        // User Security Settings Reset Devices
        $router->get('api/safetylock/resetTrustedLogins', 'AccountSecurityController@reset');

        // Change Password Request
        $router->post('api/settings/password/change', 'AccountSecurityController@changePassword');

        // Resend E-mail Verification
        $router->post('api/settings/email/verification-resend', 'AccountController@verifyAccount');

        // User Privacy Settings Changes
        $router->post('api/user/preferences/save', 'AccountController@savePreferences');

        // User Security Settings Save
        $router->post('api/safetylock/save', 'AccountSecurityController@saveQuestions');

        // User Security Settings Verify Questions
        $router->post('api/safetylock/unlock', 'AccountSecurityController@verifyQuestions');

        // Resend E-mail Verification
        $router->post('api/settings/email/change', 'AccountSecurityController@changeMail');

        // New User Client Check
        $router->post('api/newuser/name/check', 'NuxController@checkName');

        // New User Client Select Username
        $router->post('api/newuser/name/select', 'NuxController@selectName');

        // New User Client Select Room
        $router->post('api/newuser/room/select', 'NuxController@selectRoom');

        // Save User Look
        $router->post('api/user/look/save', 'AccountController@saveLook');

        // Create a New User Avatar
        $router->post('api/user/avatars', 'AccountController@createAvatar');

        // Select an User Avatar
        $router->post('api/user/avatars/select', 'AccountController@selectAvatar');

        // Habbo Client Login step
        $router->post('api/log/loginstep', function () {
            return response()->json(null, 204);
        });
    });
});
