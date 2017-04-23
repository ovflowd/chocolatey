<?php

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
        $this->get('/api')->seeStatusCode(401);
    }

    public function testRooms()
    {
        $this->get('api/public/rooms/0')->seeJson([
            'error' => 'not-found', ]);
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
