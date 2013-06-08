<?Php
//Check if a shell command exists
function depend($check)
{
	if(PHP_OS=='WINNT')
		$checkcommand='where';
	else
		$checkcommand='which';
	if(!is_array($check))
		$check=array($check);
	$notfound=array();
	foreach ($check as $command)
	{		
		if(shell_exec("$checkcommand $command 2>NUL")=='') //stderr is redirected to NUL, so if a string is returned the command exists
			$notfound[]=$command; //Add it to the lists of commands not found
	}
	if(count($notfound)>0)
		return $notfound;
	else
		return true;
}
?>