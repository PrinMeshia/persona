<?php
namespace app\persona\logger;
class Logger {
    const LOGSUCCESS = 'success';
    const LOGERROR = 'ERROR';
    const LOGWARNING = 'WARNING';
    const LOGSTAT = 'stats';
    private static $logFile;
    private static $debug;
    public function __construct(){}
    public function SetLogFile($filename = false) {
        $timeStamp = date('Y-m-d');
        if($filename)
            self::$logFile = $filename;
        else
            self::$logFile = $timeStamp;
    }
    public function SetDebug($debug = false) {
        self::$debug = $debug;
    }
    public function Write($message) {
        if (!($fh = fopen('log/'.self::$logFile, 'a+'))) {
            throw new \app\persona\exception\CannotOpenFileException(self::$logFile);            
        }
        $timeStamp = date('Y-m-d H:i:s');
        
        if (!(fwrite($fh, "{$timeStamp} {$message}\n"))) {
            throw new \app\persona\exception\FailedToWriteToFileException(self::$logFile);
        }
        
        fclose($fh);
    }
    public function DebugWrite($message) {
        if (self::$debug) {
            self::Write($message);
        }
    }
}
?>