<?php

use App\Models\Room;
use App\Models\User;
use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require __DIR__.'/../vendor/autoload.php';

/**
 * Class ApiTest.
 */
class ApiTest extends TestCase
{
    /**
     * Test Index of the API.
     *
     * @path /api/
     * @test
     */
    public function testIndex()
    {
        // Test Non Authorized Access
        $this->get('/api')->seeStatusCode(401);
    }

    /**
     * Test Room Data of the API.
     *
     * @path /api/public/rooms/{roomId}
     * @test
     */
    public function testRooms()
    {
        if (Room::where('name', 'Test Room')->first() !== null) {
            return;
        }

        // Test Non Existent Room
        $this->get('api/public/rooms/0')->seeJson([
            'error' => 'not-found',
        ]);

        // Create a Test Room
        (new Room())->store('Test Room', 'Test Room', 'model_x', 10, 1, 1, 1, 1, 1, 'Admin')->save();

        // Test Existent Room
        $this->get('api/public/rooms/1')->seeJson([
            'id'   => 1,
            'name' => 'Test Room',
        ]);
    }

    /**
     * Test Users Public Profile Api.
     *
     * @path /api/public/users
     * @test
     */
    public function testUsersPublicData()
    {
        if (User::where('username', 'TestUser')->first() !== null) {
            return;
        }

        // Test Non Existent User
        $this->get('api/public/users?name=FuckYou')->seeJson();

        // Create a Test User
        (new User())->store('TestUser', 'wesley@is.love', '::1', true);

        // Test Existent User
        $this->get('api/public/users?name=TestUser')->seeJson([
            'accountId' => 1,
        ]);
    }

    /**
     * Test If User Profile it's being given.
     *
     * @path /api/public/users/{userId}/profile
     * @test
     *
     * @TODO Check If User Profile is Hidden
     */
    public function testUsersPublicProfile()
    {
        // Check If User Profile is being sent correctly
        $this->get('api/public/users/1/profile')->seeJson([
            'badges' => [],
        ]);
    }

    /**
     * Test User Register.
     *
     * @path api/public/registration/new
     * @test
     */
    public function testRegisterUser()
    {
        if (User::where('mail', 'newtest@melove.com')->first() !== null) {
            return;
        }

        // Create an User
        $this->json('POST', 'api/public/registration/new', [
            'email'     => 'newtest@melove.com',
            'birthdate' => [
                'day'   => 1,
                'month' => 1,
                'year'  => 1996,
            ],
            'password' => 'WesleyFuck',
        ])->seeJson([
            'uniqueId' => 2,
        ]);
    }

    /**
     * Test User Login.
     *
     * @path /api/public/authentication/login
     * @test
     */
    public function testLogin()
    {
        // Create an User
        $this->json('POST', 'api/public/authentication/login', [
            'email'    => 'newtest@melove.com',
            'password' => 'WesleyFuck',
        ])->seeJson([
            'email' => 'newtest@melove.com',
        ]);
    }

    /**
     * Test if Client URL is given.
     *
     * @path /api/client/clienturl
     * @test
     */
    public function testClientUrl()
    {
        $this->testLogin();

        $this->get('api/client/clienturl')->seeJson([
            'clienturl' => 'http://localhost/client/habbo-client',
        ]);
    }

    /**
     * Test if User Preferences are Given.
     *
     * @path /api/user/preferences
     * @test
     */
    public function testPreferences()
    {
        $this->testLogin();

        $this->get('api/user/preferences')->seeJson([
            'emailFriendRequestNotificationEnabled' => false,
        ]);
    }

    /**
     * Test if SafetyLock status it's really deactivated.
     *
     * @path /api/safetylock/featureStatus
     * @test
     */
    public function testSafetyLockStatus()
    {
        $this->testLogin();

        $this->get('api/safetylock/featureStatus')->seeStatusCode(200);
    }

    /**
     * Test if Get Avatars Details Works Correctly.
     *
     * @path /api/user/profile
     * @test
     */
    public function testGetAvatars()
    {
        $this->testLogin();

        $this->get('api/user/profile')->seeJson([
            'motto' => "I'm an Arcturus Lover!",
        ]);
    }

    /**
     * Test if Public Profile Data is being acquired.
     *
     * @path /api/user/profile
     * @test
     */
    public function testGetPublicProfile()
    {
        $this->testLogin();

        $this->get('api/user/profile')->seeJson([
            'motto'   => "I'm an Arcturus Lover!",
            'badges'  => [],
            'friends' => [],
            'groups'  => [],
            'rooms'   => [],
        ]);
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return HttpKernelInterface
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
