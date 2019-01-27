<?Php
//Check if a shell command exists
class DependencyFailedException extends Exception
{
    public function __construct($command, $code = 0, Exception $previous = null)
    {
        parent::__construct(sprintf('Missing required command: %s', $command), $code, $previous);
    }
}

class dependcheck
{
    /**
     * @var string The command to be used for testing
     */
    private $checkcommand;
    /**
     * @var string Where to send stdout to be silenced
     */
    public $null;
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

    /**
     * Check if a command is available
     * @param $command
     * @return bool
     */
    function check($command)
    {
        //stderr is redirected to NUL, so if a string is returned the command exists
        if(shell_exec($this->checkcommand." $command 2>".$this->null)=='')
            return false;
        else
            return true;
    }

    /**
     * Check if a command is available and throw exception if it is missing
     * @param $command
     * @throws DependencyFailedException
     */
    function require($command)
    {
        if($this->check($command)===false)
            throw new DependencyFailedException($command);
    }

    /**
     * Old dependency check supporting array as argument
     * @param string|array $check Command(s) to be checked
     * @return array|bool Array with missing commands or true if everything is available
     */
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
