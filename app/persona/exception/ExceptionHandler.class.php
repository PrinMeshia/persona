<?php

namespace app\persona\exception;
use Exception;

ObservableException::attach(new ExceptionObserverLogger());
class Exceptionhandler extends ObservableException
{
    
}