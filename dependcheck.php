<?Php
//Check if a shell command exists
class dependcheck
{
	private $checkcommand;
	function __construct()
	{
		if(PHP_OS=='WINNT')
			$this->checkcommand='where';
		else
			$this->checkcommand='which';
	}
	function depend($check)
	{
		$check=(array)$check;
		$notfound=array();
		foreach ($check as $command)
		{		
			if(shell_exec($this->checkcommand." $command 2>NUL")=='') //stderr is redirected to NUL, so if a string is returned the command exists
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