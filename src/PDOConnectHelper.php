<?php


namespace datagutten\tools;


use PDO;
use PDOException;

class PDOConnectHelper
{
    public static function build_dsn($options)
    {
        if (!isset($options['db_type']))
            $options['db_type'] = 'mysql';
        if (!isset($options['db_charset']))
            $options['db_charset'] = '';
        else
            $options['db_charset'] = sprintf(';charset=%s', $options['db_charset']);

        return sprintf('%s:host=%s;dbname=%s%s',
            $options['db_type'],
            $options['db_host'],
            $options['db_name'],
            $options['db_charset']);
    }

    /**
     * Creates a PDO instance representing a connection to a database using the following arguments as array:
     * db_host Database host
     * db_name Database name
     * db_user Database user
     * db_password Database password
     * db_type Database Password
     * db_persistent Persistent database connection
     * db_charset Database charset
     * @param array $args Array with configuration parameters
     * @return PDO
     * @throws PDOException if the attempt to connect to the requested database fails.
     */
    public static function connect_db_config(array $args)
    {
        if (!empty($args['db_persistent']) && $args['db_persistent'] !== false)
            $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        else
            $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        $dsn = self::build_dsn($args);
        return new PDO($dsn, $args['db_user'], $args['db_password'], $options);
    }
}