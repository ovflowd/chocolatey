<?php

namespace Rdehnhardt\MaintenanceMode\Testing;

use Rdehnhardt\MaintenanceMode\MaintenanceModeService;
use Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider;

class ServiceTest extends AbstractTestCase
{
    /**
     * Asserting consecutive calls.
     */
    public function testShouldNotThrowExceptionOnConsecutiveCalls()
    {
        $service = new MaintenanceModeService($this->app);

        $this->assertSetDownMode($service);
        $this->assertSetDownMode($service);

        $this->assertSetUpMode($service);
        $this->assertSetUpMode($service);
    }

    /**
     * Asserting inverted consecutive calls.
     */
    public function testShouldNotThrowExceptionOnConsecutiveCallsInverted()
    {
        $service = new MaintenanceModeService($this->app);

        $this->assertSetUpMode($service);
        $this->assertSetUpMode($service);

        $this->assertSetDownMode($service);
        $this->assertSetDownMode($service);

        $this->assertSetUpMode($service);
    }

    /**
     * Asserting application in down mode.
     */
    public function testShouldApplicationBeInDownMode()
    {
        $this->app->register(MaintenanceModeServiceProvider::class);

        $this->artisan('down');

        $this->assertFileExists($this->app->storagePath('framework/down'));
    }

    /**
     * Asserting application in up mode.
     */
    public function testShouldApplicationBeInUpMode()
    {
        $this->app->register(MaintenanceModeServiceProvider::class);

        $this->artisan('up');

        $this->assertFileNotExists($this->app->storagePath('framework/down'));
    }

    /**
     * Test allowed ips
     */
    public function testAllowedIps()
    {
        $service = new MaintenanceModeService($this->app);

        $this->assertTrue($service->checkAllowedIp('127.0.0.1'));
        $this->assertTrue($service->checkAllowedIp('127.0.0.2'));
    }
    
    /**
     * @param MaintenanceModeService $service
     */
    public function assertSetUpMode(MaintenanceModeService $service)
    {
        $service->setUpMode();

        $this->assertFileNotExists($service->maintenanceFilePath());
    }

    /**
     * @param MaintenanceModeService $service
     */
    public function assertSetDownMode(MaintenanceModeService $service)
    {
        $service->setDownMode();

        $this->assertFileExists($service->maintenanceFilePath());
    }
}
