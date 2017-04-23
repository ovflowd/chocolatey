<?php

use Httpful\Request;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Class Api
 */
class ApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * Server URL
     *
     * @var string
     */
    protected $serverURI = 'http://localhost';

    /**
     * Test the Index Page of the API Client
     * @path /api/
     * @test
     */
    public function testIndex()
    {
        $response = Request::get($this->serverURI . '/api')->send();

        $this->assertEquals(401, $response->code);
    }
}