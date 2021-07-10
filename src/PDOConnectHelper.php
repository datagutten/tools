<?php


namespace datagutten\tools;


use PDO;
use PDOException;

class PDOConnectHelper
{
    public static function build_dsn($options)
    {
        if (empty($options['db_type']))
            $options['db_type'] = 'mysql';

        $dsn = $options['db_type'] .':';

        if($options['db_type']=='sqlite')
        {
            if(!empty($options['db_file']))
                $dsn .= $options['db_file'];
            else
                $dsn .=':memory:';
            return $dsn;
        }

        if(!empty($options['db_host']))
            $dsn .= sprintf('host=%s;', $options['db_host']);

        if(!empty($options['db_port']))
            $dsn .= sprintf('port=%s;', $options['db_port']);

        if(!empty($options['db_name']))
            $dsn .= sprintf('dbname=%s;', $options['db_name']);

        if(!empty($options['db_charset']))
            $dsn .= sprintf('charset=%s', $options['db_charset']);

        return $dsn;
    }

    /**
     * Creates a PDO instance representing a connection to a database using the following arguments as array:
     * db_host Database host
     * db_port Database server port
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