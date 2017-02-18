<?php

namespace Rdehnhardt\MaintenanceMode\Console\Commands;

use Illuminate\Console\Command as IlluminateCommand;
use Rdehnhardt\MaintenanceMode\MaintenanceModeService;

abstract class Command extends IlluminateCommand
{
    /**
     * Maintenance Service.
     *
     * @var MaintenanceModeService
     */
    protected $maintenance;

    /**
     * @param \Rdehnhardt\MaintenanceMode\MaintenanceModeService $maintenance
     */
    public function __construct(MaintenanceModeService $maintenance)
    {
        parent::__construct();

        $this->maintenance = $maintenance;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    abstract public function fire();

    /**
     * Set Application Up Mode.
     *
     * @return void
     * @throws \Rdehnhardt\MaintenanceMode\Exceptions\FileException
     */
    public function setUpMode()
    {
        $this->maintenance->setUpMode();
        $this->info('Application is now live.');
    }

    /**
     * Set Application Down Mode.
     *
     * @return void
     * @throws \Rdehnhardt\MaintenanceMode\Exceptions\FileException
     */
    public function setDownMode()
    {
        $this->maintenance->setDownMode();
        $this->info('Application is now in maintenance mode.');
    }
}
