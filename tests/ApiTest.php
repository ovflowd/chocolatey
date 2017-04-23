<?php

use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Class ApiTest
 */
class ApiTest extends TestCase
{
    /**
     * Test the Index Page of the API Client
     *
     * @path /api/
     * @test
     */
    public function testIndex()
    {
        $this->get('/api')->seeStatusCode(401);
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
        return require __DIR__ . '/../bootstrap/app.php';
    }
}