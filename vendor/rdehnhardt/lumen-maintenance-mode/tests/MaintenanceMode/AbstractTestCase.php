<?php

namespace Rdehnhardt\MaintenanceMode\Testing;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @return Application
     */
    public function createApplication()
    {
        /** @var \Laravel\Lumen\Application $app */
        $app = require __DIR__.'/../bootstrap.php';

        return $app;
    }

    /**
     * Get path to stub.
     *
     * @param string $path
     *
     * @return string
     */
    protected function stubsPath($path = null)
    {
        return __DIR__.'/../stubs'.($path ? '/'.trim($path, '/') : '');
    }
}
