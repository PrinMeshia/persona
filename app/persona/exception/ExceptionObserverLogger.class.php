<?php
namespace app\persona\exception;
class ExceptionObserverLogger implements ExceptionObserver
{
    protected $_filename = ROOT.'/tmp/log/exception.log';
    public function __construct($filename = null)
    {
        if ((null !== $filename) && is_string($filename))
        {
            $this->_filename = $filename;
            
        }
        if(!file_exists($this->_filename))
            touch($this->_filename); 
    }
    public function update(ObservableException $e)
    {
        error_log($e->getTraceAsString(), 3, $this->_filename);
    }
}