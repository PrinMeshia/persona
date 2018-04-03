<?php
namespace app\persona\logger;
class Logger {
    const LOGSUCCESS = 'success';
    const LOGERROR = 'ERROR';
    const LOGWARNING = 'WARNING';
    const LOGSTAT = 'stats';
    private static $logFile;
    public function __construct(){}
    public function SetLogFile($filename = false) {
        $timeStamp = date('Y-m-d');
        if($filename)
            self::$logFile = $filename;
        else
            self::$logFile = $timeStamp;
    }
    public function Write($message) {
        if (!($fh = fopen('log/'.self::$logFile, 'a+'))) {          
        }
        $timeStamp = date('Y-m-d H:i:s');
        if (!(fwrite($fh, "{$timeStamp} {$message}\n"))) {
        }
        
        fclose($fh);
    }
    public function DebugWrite($message) {
            self::Write($message);
    }
}
?>