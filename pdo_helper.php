<?Php
/** @noinspection PhpIncludeInspection */
/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

class pdo_helper extends PDO
{
	public $db;
    /**
     * @var string Database name
     */
	public $db_name;

    /** @noinspection PhpMissingParentConstructorInspection */
    function __construct() //Override parent constructor
	{
	}

    /**
     * @param string $db_host Database host
     * @param string $db_name Database name
     * @param string $db_user Database user
     * @param string $db_password Database password
     * @param string $db_type Database Password
     * @param bool $persistent Persistent database connection
     * @param string $charset Database charset
     */
	function connect_db($db_host,$db_name,$db_user,$db_password,$db_type,$persistent=false,$charset=null)
	{
		if($persistent!==false)
			$options=array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		else
			$options=array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		if(!empty($charset))
			$charset=';charset='.$charset;
		else
			$charset='';
		$this->db_name = $db_name;
		$this->db = parent::__construct("$db_type:host=$db_host;dbname=$db_name$charset",$db_user,$db_password,$options);
	}

    /**
     * Connect to database using config file
     * @param string $file Config file
     * @throws Exception|FileNotFoundException
     */
	function connect_db_config($file=null)
	{
        if(empty($file))
            $config = require 'config_db.php';
        elseif(!file_exists($file))
            throw new FileNotFoundException($file);
        else
            $config = require $file;

		if(empty($config))
		    throw new Exception('Invalid config file');
		if(!isset($config['db_persistent']))
            $config['db_persistent']=false;
		if(!isset($config['db_type']))
			$config['db_type']='mysql';
		if(!isset($charset))
			$config['db_charset']=false;
		return $this->connect_db(
		    $config['db_host'],
            $config['db_name'],
            $config['db_user'],
            $config['db_password'],
            $config['db_type'],
            $config['db_persistent'],
            $config['db_charset']
        );
	}

    /**
     * Run a database query
     * @param string $q SQL query
     * @param string|int $fetch Fetch type, passed to fetch method
     * @return PDOStatement|array|string|null
     * @throws PDOException
     */
    function query($q, $fetch=null)
	{
		if(is_integer($fetch))
		    return parent::query($q, $fetch);
		else {
            $st = parent::query($q);
            return $this->fetch($st, $fetch);
        }
	}

    /**
     * @param PDOStatement $st
     * @param array $input_parameters Arguments passed to PDOStatement::execute
     * @param string $fetch Fetch type
     * @return mixed
     * @throws PDOException
     */
    function execute($st, $input_parameters, $fetch=null)
	{
		$st->execute($input_parameters);
		return $this->fetch($st,$fetch);
	}

    /**
     * @param PDOStatement $st
     * @param string $type Fetch style (assoc, column, all or all_column)
     * @return PDOStatement|array|string|null
     */
    function fetch($st, $type)
	{
		if(empty($type))
			return $st;
		elseif($st->rowCount()==0)
			return null;
		elseif($type=='assoc')
			return $st->fetch(PDO::FETCH_ASSOC);
		elseif($type=='column')
			return $st->fetch(PDO::FETCH_COLUMN);
		elseif($type=='all')
			return $st->fetchAll(PDO::FETCH_ASSOC);
		elseif($type=='all_column')
			return $st->fetchAll(PDO::FETCH_COLUMN);
		else
			throw new InvalidArgumentException('Invalid fetch: '.$type);
	}
}
