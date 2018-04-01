<?php
namespace app\persona\exception;

use app\persona\Persona;

class LogExceptionReporter  {
	public function ReportException(Exception $e) 	{
		$message = $this->FormatException($e);
		Persona::getInstance()->logger->Write($message);
	}	
	protected function FormatException(Exception $e) {
		$message  = date('Y-m-d H:i:s') .'  Uncaught '. get_class($e) .': '. $e->getMessage() ."\n";
		$message .= $e->getTraceAsString();
		$message .= "\n\n";
		return $message;
	}
}

?>