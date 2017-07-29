<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PDO;

/**
 * Class Setup.
 */
class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'choco:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Guide you through the process of configuring your copy of Chocolatey';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Welcome to the Chocolatey Housekeeping setup command');
        $this->comment('This little command will guide you through the configuration of your copy of Espreso and will prompt you to create the first Super User');

        if ($this->confirm('Do you want to continue the setup process?')) {
            $this->comment('First step - SETUP DATABASE');

            $DB_HOST = $this->ask('Database host? Can take the form of an IP address, FQDN, host alias...');
            $DB_PORT = $this->ask('MySQL server port? If you don\'t know, type 3306', 3306);
            $DB_USER = $this->ask('Database user?');
            $DB_PASS = $this->ask('Database password?');
            $DB_NAME = $this->ask('Database name?');

            try {
                (new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS));
            } catch (\PDOException $e) {
                $this->error('[ERROR] An error occured while configuring the database:');
                $this->error($e->getMessage());
                exit();
            }

            $this->comment('[SUCCESS] Database connection has been established successfully...');

            $this->comment('[INFO] Creating new .env file in Chocolatey storage...');

            Storage::delete('.env');
            Storage::put('.env', 'APP_ENV=production');

            $this->comment('[INFO] Generating Chocolatey encryption key for password hashing...');
            Storage::append('.env', 'APP_KEY='.bin2hex(openssl_random_pseudo_bytes(20)));

            $this->comment('[INFO] Setting Chocolatey debug mode to false...');
            Storage::append('.env', 'APP_DEBUG=false');

            $this->comment('[INFO] Setting Espreso logging level to debug...');
            Storage::append('.env', 'APP_LOG_LEVEL=debug');

            $this->comment('[DATABASE] Setting database driver to mysql...');
            Storage::append('.env', 'DB_CONNECTION=mysql');

            $this->comment('[INFO] Appending all database credentials to .env file...');
            Storage::append('.env', 'DB_HOST='.$DB_HOST);
            Storage::append('.env', 'DB_PORT='.$DB_PORT);
            Storage::append('.env', 'DB_DATABASE='.$DB_NAME);
            Storage::append('.env', 'DB_USERNAME='.$DB_USER);
            Storage::append('.env', 'DB_PASSWORD='.$DB_PASS);
            Storage::append('.env', '');

            $this->comment('[DRIVERS] Setting broadcast to log...');
            Storage::append('.env', 'BROADCAST_DRIVER=log');

            $this->comment('[DRIVERS] Setting cache to file...');
            Storage::append('.env', 'CACHE_DRIVER=file');

            $this->comment('[DRIVERS] Setting session to file...');
            Storage::append('.env', 'SESSION_DRIVER=file');

            $this->comment('[DRIVERS] Setting queueing to sync...');
            Storage::append('.env', 'QUEUE_DRIVER=sync');
        }

        return true;
    }
}
