<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Database;

use PDO;
use PDOException;

/**
 * Class Connector
 * @package Azure\Database
 */
final class Connector
{
    /**
     * function open
     * open the database :)
     * @param $connection_details
     * @return null|PDO
     */
    static function open($connection_details)
    {
        try {
            if (isset($connection_details)):
                $user = isset($connection_details['user']) ? $connection_details['user'] : '';
                $pass = isset($connection_details['pass']) ? $connection_details['pass'] : '';
                $name = isset($connection_details['name']) ? $connection_details['name'] : '';
                $host = isset($connection_details['host']) ? $connection_details['host'] : '';
                $type = isset($connection_details['type']) ? $connection_details['type'] : '';
                $port = isset($connection_details['port']) ? $connection_details['port'] : '';

                switch ($type):
                    case 'pgsql':
                        return new PDO("pgsql:dbname={$name};user={$user};password={$pass};host=$host;port={$port}");
                    case 'mysql':
                        return new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                    case 'sqlite':
                        return new PDO("sqlite:{$name}");
                    case 'ibase':
                        return new PDO("firebird:dbname={$name}", $user, $pass);
                    case 'oci8':
                        return new PDO("oci:dbname={$name}", $user, $pass);
                    case 'mssql':
                        return new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                endswitch;
            endif;
        } catch (PDOException $e) {
            return null;
        }
        return null;
    }
}