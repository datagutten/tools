<?Php

/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

class pdo_helper extends PDO
{
	public $locale_path;
	public $db;

    /** @noinspection PhpMissingParentConstructorInspection */
    function __construct() //Override parent constructor
	{
	}
	function connect_db($db_host,$db_name,$db_user,$db_password,$db_type,$persistent=false,$charset=false)
	{
		if($persistent!==false)
			$options=array(PDO::ATTR_PERSISTENT => true);
		else
			$options=NULL;
		if($charset!==false)
			$charset=';charset='.$charset;
		else
			$charset='';
		$this->db = parent::__construct("$db_type:host=$db_host;dbname=$db_name$charset",$db_user,$db_password,$options);
	}
	function connect_db_config($file=false)
	{
		if($file===false)
			require 'config_db.php';
		else
			require $file;
		if(!isset($persistent))
			$persistent=false;
		if(!isset($db_type))
			$db_type='mysql';
		if(!isset($charset))
			$charset=false;
		return $this->connect_db($db_host,$db_name,$db_user,$db_password,$db_type,$persistent,$charset);
	}

    /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */
    function query($q, $fetch=false, &$timing=false)
	{
		$start=time();
		$st=parent::query($q);
		$end=time();

		$timing=$end-$start;
		if($st===false)
		{
			$errorinfo=$this->errorInfo();
			throw new Exception("SQL error: {$errorinfo[2]}");
		}
		return $this->fetch($st,$fetch);
	}

    /**
     * @param PDOStatement $st
     * @param $parameters
     * @param string $fetch Fetch type
     * @return mixed
     * @throws Exception
     */
    function execute($st, $parameters, $fetch=null)
	{
		if($st->execute($parameters)===false)
		{
			$errorinfo=$st->errorInfo();
			throw new Exception("SQL error: {$errorinfo[2]}");
		}
		return $this->fetch($st,$fetch);
	}

    /**
     * @param PDOStatement $st
     * @param $type
     * @throws Exception
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
			throw new Exception('Invalid fetch: '.$type);
	}
}
