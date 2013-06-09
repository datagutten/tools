<?Php
//Check if a shell command exists
class dependcheck
{
	private $checkcommand;
	private $null;
	function __construct()
	{
		if(PHP_OS=='WINNT')
		{
			$this->checkcommand='where';
			$this->null='NUL';
		}
		else
		{
			$this->checkcommand='which';
			$this->null='/dev/null';	
		}
	}
	function depend($check)
	{
		$check=(array)$check;
		$notfound=array();
		foreach ($check as $command)
		{		
			if(shell_exec($this->checkcommand." $command 2>".$this->null)=='') //stderr is redirected to NUL, so if a string is returned the command exists
				$notfound[]=$command; //Add it to the lists of commands not found
		}
		if(count($notfound)>0)
			return $notfound;
		else
			return true;
	}
}
/*Sample:
$dependcheck=new dependcheck;
var_dump($dependcheck->depend('mediainfo'));*/
?>