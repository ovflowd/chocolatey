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

use Azure\Framework;
use Azure\View\Misc;
use PDO;
use PDOException;
use stdClass;

/**
 * Class Adapter
 * @package Azure\Database
 */
final class Adapter
{
    public static $connection_instance, $database_data;

    /**
     * function get_instance
     * return a static instance of database connection
     * @return mixed
     */
    static function get_instance()
    {
        return self::$connection_instance;
    }

    /**
     * function begin_transaction
     * start's the transaction
     */
    static function begin_transaction()
    {
        self::$connection_instance->beginTransaction();
    }

    /**
     * function commit_transaction
     * let's do this xit
     */
    static function commit_transaction()
    {
        self::$connection_instance->commit();
    }

    /**
     * function rollback_transaction
     * error error let's back to original
     */
    static function rollback_transaction()
    {
        self::$connection_instance->rollBack();
    }

    /**
     * function sleep
     * collect database details data and save memory
     * @return array
     */
    static function __sleep()
    {
        self::$connection_instance = null;
        return ['database_data'];
    }

    /**
     * function wakeup
     * wakeup the database instance
     */
    static function __wakeup()
    {
        self::set_instance(self::$database_data);
    }

    /**
     * function set_instance
     * create a static instance of a database connection
     * @param $database
     */
    static function set_instance($database)
    {
        self::$connection_instance = (empty(self::$connection_instance)) ? Connector::open(self::$database_data = $database) : self::$connection_instance;
    }

    /**
     * function close_instance
     * closes the static database instance
     */
    static function close_instance()
    {
        self::$connection_instance = (isset(self::$connection_instance)) ? null : self::$connection_instance;
    }

    /**
     * function fetch_array
     * fetch an array of query
     * @param null $query
     * @return array
     */
    static function fetch_array($query = null)
    {
        try {
            return (($query != null) && (self::$connection_instance != null)) ? $query->fetch(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $exception) {
            trigger_error("PDO Error in Query: $query AND Exception: $exception", E_WARNING);
            Framework::ux_die("[database] exception: $exception");
        }
    }

    /**
     * function fetch_object
     * fetch an array of query
     * @param null $query
     * @return stdClass()
     */
    static function fetch_object($query = null)
    {
        try {
            return (($query != null) && (self::$connection_instance != null)) ? $query->fetchObject() : new stdClass();
        } catch (PDOException $exception) {
            trigger_error("PDO Error in Query: $query AND Exception: $exception", E_WARNING);
            Framework::ux_die("[database] exception: $exception");
        }
    }

    /**
     * function secure_query
     * do a query ;)
     * @param null $query
     * @param array $array (parameters)
     * @return null
     */
    static function secure_query($query = null, $array = [])
    {
        try {
            $query_result = (self::$connection_instance != null) ? self::$connection_instance->prepare($query) : null;
            $query_result->closeCursor();
            $query_result->execute($array);
            return (isset($query_result)) ? $query_result : null;
        } catch (PDOException $exception) {
            trigger_error("PDO Error in Query: $query AND Exception: $exception", E_WARNING);
            Framework::ux_die("[database] exception: $exception");
        }
    }

    /**
     * function insert_array
     * inserts an query based of a array
     * @param $table
     * @param $data
     * @param array $exclude
     */
    static function insert_array($table, $data, $exclude = [])
    {
        $fields = $values = [];
        if (!is_array($exclude))
            $exclude = [$exclude];
        foreach (array_keys($data) as $key) :
            if (!in_array($key, $exclude)):
                $fields[] = "`$key`";
                $values[] = "'" . Misc::escape_text($data[$key]) . "'";
            endif;
        endforeach;
        $fields = implode(",", $fields);
        $values = implode(",", $values);
        self::query("INSERT INTO `$table` ($fields) VALUES ($values)");
    }

    /**
     * function query
     * do a query ;)
     * @param null $query
     * @return null
     */
    static function query($query = null)
    {
        try {
            $query_result = (self::$connection_instance != null) ? self::$connection_instance->query($query) : null;
            return (isset($query_result)) ? $query_result : null;
        } catch (PDOException $exception) {
            trigger_error("PDO Error in Query: $query AND Exception: $exception", E_WARNING);
            Framework::ux_die("[database] exception: $exception");
        }
    }

    /**
     * function row_count
     * count number of fields
     * @param null $query
     * @return int
     */
    static function row_count($query = null)
    {
        try {
            return (($query != null) && (self::$connection_instance != null)) ? $query->rowCount() : 0;
        } catch (PDOException $exception) {
            trigger_error("PDO Error in Query: $query AND Exception: $exception", E_WARNING);
            Framework::ux_die("[database] exception: $exception");
        }
    }
}
