<?Php
class pdo_helper extends PDO
{
	public $locale_path;
	function __construct() //Override parent constructur
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
	function query($q,$fetch=false,&$timing=false)
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
	function execute($st,$parameters,$fetch=false)
	{
		if($st->execute($parameters)===false)
		{
			$errorinfo=$st->errorInfo();
			throw new Exception("SQL error: {$errorinfo[2]}");
		}
		return $this->fetch($st,$fetch);
	}
	function fetch($st,$type)
	{
		if($type===false)
			return $st;
		elseif($st->rowCount()==0)
			return;
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
