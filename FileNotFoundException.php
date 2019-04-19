<?php
/**
 * Common exceptions
 *
 * Created by PhpStorm.
 * User: Anders
 * Date: 20.01.2019
 * Time: 15.02
 */

class FileNotFoundException extends Exception
{
    public function __construct($file, $code = 0, Exception $previous = null) {
        $message = sprintf('File does not exist: %s', $file);
        parent::__construct($message, $code, $previous);
    }

}