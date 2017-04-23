<?php

use App\Models\Room;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require __DIR__.'/../vendor/autoload.php';

/**
 * Class ApiTest.
 */
class ApiTest extends TestCase
{
    use DatabaseMigrations;

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
        if (Room::find(1) !== null) {
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
        if (User::find(1) !== null) {
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
        if (User::find(2) !== null) {
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
