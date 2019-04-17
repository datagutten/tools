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
    private $check_command;
    /**
     * @var string Where to send stdout to be silenced
     */
    public $null;

    /**
     * dependcheck constructor.
     * Detects OS and sets correct null and check command
     */
	function __construct()
	{
		if(PHP_OS=='WINNT')
		{
			$this->check_command='where';
			$this->null='NUL';
		}
		else
		{
			$this->check_command='which';
			$this->null='/dev/null';	
		}
	}

    /**
     * Check if a command is available and throw exception if it is missing
     * @param string $command Command to be checked
     * @throws DependencyFailedException
     */
    function depend($command)
    {
        //stderr is redirected to NUL, so if a string is returned the command exists
        if(shell_exec($this->check_command." $command 2>".$this->null)=='')
            throw new DependencyFailedException($command);
    }
}
/*Sample:
$dependcheck=new dependcheck;
$dependcheck->depend('mediainfo');*/
