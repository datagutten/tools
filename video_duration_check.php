<?Php
require_once 'video.php';
class video_duration_check extends video
{
	public $duration_tolerance=90;
	public $error;

	//Check if the duration of a file matches the given duration
	private function check_duration($duration_file,$duration_reference)
	{
		if($duration_reference==$duration_file) //Varighet er riktig
			return true;
		elseif($duration_reference>$duration_file && $duration_reference-$duration_file<=$this->duration_tolerance) //Varighet er innenfor toleransen
			return true;
		elseif($duration_file>$duration_reference && $duration_file-$duration_reference<=$this->duration_tolerance) //Varighet er innenfor toleransen
			return true;
		else
		{
			$this->error=sprintf('Wrong duration: File duration %s is outside tolerance from %s',$duration_file,$duration_reference);
			return false;
		}
	}
	public function check_file_duration($file,$duration_reference) //Sjekk om filen eksisterer og om eventuell eksisterende fil er fullstendig. Er eksisterende fil gyldig returneres true
	{
		if(!file_exists($file)) 
		{
			$this->error="The file $file does not exist";
			return false; 
		}
		if(filesize($file)==0) //Sjekk om filen er tom
		{
			$this->error='Empty file';
			unlink($file);
			return false;
		}
		$duration_file=$this->duration($file); //Get file duration
		if($duration_file===false)
		{
			$this->error='Unable to find duration for '.$file;
			return;
		}
		if(!$this->check_duration($duration_file,$duration_reference))
		{
			rename($file,$file.".wrong_duration");
			return false;
		}
		else
		{
			$this->error='File exists and duration is correct';
			return true;
		}
	}
}