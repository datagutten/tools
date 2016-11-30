<?Php
function filnavn($tittel)
{
	$filnavn=html_entity_decode($tittel);
	$filnavn=str_replace(array(':','?','*','|','<','>','/','\\'),array(' -','','','','','','-','-'),$filnavn); //Fjern tegn som ikke kan brukes i filnavn på windows

	if(PHP_OS=='WINNT')
		$filnavn=utf8_decode($filnavn);
	return $filnavn;
}
?>