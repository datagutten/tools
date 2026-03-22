<?Php
function filnavn($tittel)
{
	$filnavn=html_entity_decode($tittel);
	$filnavn=str_replace(array(':','?','*','|','<','>','/','\\','"'),array(' -','','','','','','-','-',''),$filnavn); //Fjern tegn som ikke kan brukes i filnavn på windows

	if(PHP_OS=='WINNT')
    {
        if (function_exists('mb_convert_encoding'))
            $filnavn = mb_convert_encoding($filnavn, 'ISO-8859-1', 'UTF-8');
        else
        {
            /** @noinspection PhpDeprecationInspection */
            $filnavn = utf8_decode($filnavn);
        }
    }
	return $filnavn;
}
