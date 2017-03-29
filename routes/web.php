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

use Illuminate\Support\Facades\Config;

# Configure Sub Paths
$path = Config::get('chocolatey.path');

# Main Route
$app->get($path, 'HomePageController@show');

/*
|--------------------------------------------------------------------------
| Habbo API Routes
|--------------------------------------------------------------------------
|
| Here are registered all main HabboWEB api routes
| You can simply went to their respective controllers.
|
*/

# Logout User
$app->post($path . 'api/public/authentication/logout', 'LoginController@logout');

# Main API Request is Forbidden
$app->get($path . 'espreso', function () {
    return response(view('errors.espreso'), 401);
});

# Maintenance Middleware
$app->group(['middleware' => 'maintenance'], function () use ($app, $path) {

    # Main API Request is Forbidden
    $app->get($path . 'api', function () {
        return response('Unauthorized.', 401);
    });

    # Go to Help Page
    $app->get($path . 'api/public/help', function () {
        return redirect(Config::get('chocolatey.help'));
    });

    # Get Data from a Room
    $app->get($path . 'api/public/rooms/{room}', 'RoomsController@getRoom');

    # Get User Public Data
    $app->get($path . 'api/public/users', 'ProfileController@getPublicData');

    # Get User Public Data
    $app->get($path . 'api/public/users/{userId}/profile', 'ProfileController@getPublicProfile');

    # Create an User Request
    $app->post($path . 'api/public/registration/new', 'LoginController@register');

    # Confirm E-mail
    $app->post($path . 'api/public/registration/activate', 'AccountController@confirmActivation');

    # Change Password Request
    $app->post($path . 'api/public/forgotPassword/send', 'AccountController@forgotPassword');

    # Confirm E-mail
    $app->post($path . 'api/public/forgotPassword/changePassword', 'AccountSecurityController@confirmChangePassword');

    # Authenticate User
    $app->post($path . 'api/public/authentication/login', 'LoginController@login');

    # Middleware that Requires Authentication
    $app->group(['middleware' => 'auth'], function () use ($app, $path) {

        # Client URL
        $app->get($path . 'api/client/clienturl', 'ClientController@getUrl');

        # Change Password Request
        $app->post($path . 'api/settings/password/change', 'AccountSecurityController@changePassword');

        # Resend E-mail Verification
        $app->post($path . 'api/settings/email/verification-resend', 'AccountController@verifyAccount');

        # User Privacy Settings
        $app->get($path . 'api/user/preferences', 'AccountController@getPreferences');

        # User Privacy Settings Changes
        $app->post($path . 'api/user/preferences/save', 'AccountController@savePreferences');

        # User Security Settings Request
        $app->get($path . 'api/safetylock/featureStatus', 'AccountSecurityController@featureStatus');

        # User Security Settings Save
        $app->post($path . 'api/safetylock/save', 'AccountSecurityController@saveQuestions');

        # User Security Settings Disable
        $app->get($path . 'api/safetylock/disable', 'AccountSecurityController@disable');

        # User Security Settings getQuestions
        $app->get($path . 'api/safetylock/questions', 'AccountSecurityController@getQuestions');

        # User Security Settings Verify Questions
        $app->post($path . 'api/safetylock/unlock', 'AccountSecurityController@verifyQuestions');

        # User Security Settings Reset Devices
        $app->get($path . 'api/safetylock/resetTrustedLogins', 'AccountSecurityController@reset');

        # Resend E-mail Verification
        $app->post($path . 'api/settings/email/change', 'AccountSecurityController@changeMail');

        # Habbo Client Login step
        $app->post($path . 'api/log/loginstep', function () {
            return response()->json(null, 204);
        });

        # New User Client Check
        $app->post($path . 'api/newuser/name/check', 'AccountController@checkName');

        # New User Client Select Username
        $app->post($path . 'api/newuser/name/select', 'AccountController@selectName');

        # Save User Look
        $app->post($path . 'api/user/look/save', 'AccountController@saveLook');

        # Get User (AzureID) Avatars
        $app->get($path . 'api/user/avatars', 'AccountController@getAvatars');

        # Get User Public Data
        $app->get($path . 'api/user/profile', 'ProfileController@getProfile');

        # Create a New User Avatar
        $app->post($path . 'api/user/avatars', 'AccountController@createAvatar');

        # Select an User Avatar
        $app->post($path . 'api/user/avatars/select', 'AccountController@selectAvatar');

        # Get User (AzureID) Avatars
        $app->get($path . 'api/user/avatars/check-name', 'AccountController@checkNewName');

        # User Messenger Not Read Discussions
        $app->get($path . 'api/user/discussions', 'AccountController@getDiscussions');

        # New User Client Select Room
        $app->post($path . 'api/newuser/room/select', 'AccountController@selectRoom');
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
    $app->get($path . 'shopapi', function () {
        return response('Unauthorized.', 401);
    });

    # Get a List of all Shop Countries
    $app->get($path . 'shopapi/public/countries', 'ShopController@listCountries');

    # Get the Inventory of a specific Country
    $app->get($path . 'shopapi/public/inventory/{countryCode}', 'ShopController@getInventory');

    # Middleware that Requires Authentication
    $app->group(['middleware' => 'auth'], function () use ($app, $path) {
        # Get User Purse
        $app->get($path . 'shopapi/purse', 'ShopController@getPurse');

        # Get Offers Page
        $app->get($path . 'shopapi/offerwall/url', 'ShopController@getWall');

        # Get User Purchase History
        $app->get($path . 'shopapi/history', 'ShopController@getHistory');

        # Get a List of all Shop Countries
        $app->get($path . 'shopapi/countries', 'ShopController@listCountries');

        # Redeem a Voucher
        $app->post($path . 'shopapi/voucher/redeem', 'ShopController@redeem');

        # Get the Inventory of a specific Country
        $app->get($path . 'shopapi/inventory/{countryCode}', 'ShopController@getInventory');

        # Redirect to Purchase Proceed
        $app->get($path . 'shopapi/proceed/{paymentCategory}/{countryCode}/{shopItem}/{paymentMethod}', 'ShopController@proceed');

        # Redirect to Success Purchase
        $app->post($path . 'shopapi/success/{paymentCategory}/{countryCode}/{shopItem}/{paymentMethod}', 'ShopController@success');
    });
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
$app->get($path . 'extradata', function () {
    return response('Unauthorized.', 401);
});

# Show All Registered HabboWEB Photos
$app->get($path . 'extradata/public/photos', 'PhotosController@show');

# Get User Stories
$app->get($path . 'extradata/public/users/{userId}/stories', 'ProfileController@getStories');

# Get User Stories
$app->get($path . 'extradata/public/users/{userId}/photos', 'ProfileController@getPhotos');

# Public Stories
$app->get($path . 'extradata/public/users/stories', function () {
    return response()->json('');
});

# Middleware that Requires Authentication
$app->group(['middleware' => 'auth'], function () use ($app, $path) {
    # Report a Specific Photo
    $app->post($path . 'extradata/private/creation/{photo}/report', 'PhotosController@report');

    # Like a Specific Photo
    $app->post($path . 'extradata/private/like/{photo}', 'PhotosController@likePhoto');

    # Delete a Specific Photo
    $app->delete($path . 'extradata/private/photo/{photo}', 'PhotosController@delete');

    # Like a Specific Photo
    $app->post($path . 'extradata/private/unlike/{photo}', 'PhotosController@unlikePhoto');

    # Recent Photo Moderations
    # @TODO: Synchronize with Photo Moderations
    $app->get($path . 'extradata/private/moderations/recentModerations', function () {
        return response()->json([]);
    });
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
$app->get($path . 'habbo-web-pages/', function () {
    return response('Unauthorized.', 401);
});

# Request a Specific View of HabboWEB Pages
$app->get($path . 'habbo-web-pages/production/{category}/{view}', 'PageController@show');

# Request a Specific View of HabboWEB Pages
$app->get($path . 'habbo-web-pages/production/{category}/{subcategory}/{view}', 'PageController@showWithSub');

# Middleware that Requires Authentication
$app->group(['middleware' => 'auth'], function () use ($app, $path) {
    # Request the Client URL
    $app->get($path . 'client/{view}', 'PageController@getClient');
});

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
$app->get($path . 'habbo-web-news/', function () {
    return response('Unauthorized.', 401);
});

# Request a set of Articles, generally a category or front page
$app->get($path . 'habbo-web-news/{country}/production/{view}', 'ArticleController@many');

# Request a single Article generally when you access directly an Article
$app->get($path . 'habbo-web-news/{country}/production/articles/{article}', 'ArticleController@one');

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
$app->get($path . 'habbo-web-l10n/', function () {
    return response('Unauthorized.', 401);
});

# Render a specific Language Ecosystem
$app->get($path . 'habbo-web-l10n/{language}', 'LanguageController@render');

/*
|--------------------------------------------------------------------------
| Habbo WEB Leaderboards
|--------------------------------------------------------------------------
|
| Here are the Rooms Routes
|
*/

# Render a specific Language Ecosystem
$app->get($path . 'habbo-web-leaderboards/{countryId}/visited-rooms/{range}/{data}', 'RoomsController@getLeader');

/*
|--------------------------------------------------------------------------
| Habbo WEB ADS
|--------------------------------------------------------------------------
|
| Here comes the Advertisement Routes
|
*/

# Get Interstitial Client ADS
$app->get($path . 'habbo-web-ads/{interstitial}', 'ClientController@getInterstitial');

/*
|--------------------------------------------------------------------------
| Miscellaneous
|--------------------------------------------------------------------------
|
| Other Routes used by Habbo
|
*/

# Get Habbo RSS
$app->get($path . 'rss.xml', 'ArticleController@getRss');

# Get Special AvatarImage for BigHead providing Username or Figure
$app->get($path . 'habbo-imaging/avatarimage', 'ImagingController@getUserHead');

# Get Special AvatarImage for Body Look only providing Figure
$app->get($path . 'habbo-imaging/avatar/{figure}', 'ImagingController@getUserBody');

# Get Group Badge
$app->get($path . 'habbo-imaging/badge/{badgeCode}', 'ImagingController@getGroupBadge');

# Get Youtube Thumbnail
$app->get($path . 'youtube', 'ImagingController@getYoutubeThumbnail');
