<?php

namespace app\persona\exception;
use Exception;

class CannotOpenFileException extends Exception
{
    public function __construct($filename)
    {
        parent::__construct("File {$filename} could not be opened for writing");
    }
}

class FailedToWriteToFileException extends Exception
{
    public function __construct($filename)
    {
        parent::__construct("Failed to write to file {$filename}");
    }
}

class ApiRequestException extends Exception
{
    public function __construct($api)
    {
        parent::__construct("{$api} : Request was not correct");
    }
}

class ApiResultException extends Exception
{
    public function __construct($api,$message)
    {
        parent::__construct("{$api} :  error => {$message}");
    }
}
