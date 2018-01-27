<?php
namespace app\vendor\profiler;
/**
 * 
 */
class Profiler 
{
    private $_instance;
    private $startTime;
    private $config;
    private $details;
	private $rustart;
    function __construct($persona)
    {
        $this->persona = $persona;
    }
    public function gatherFileData() {
		$files = get_included_files();
		$fileList = array();
		$fileTotals = array('count' => count($files), 'size' => 0, 'largest' => 0);
		foreach($files as $key => $file) {
			$size = filesize($file);
			$fileList[] = array('name' => $file, 'sizestr' => $this->getReadableFileSize($size), 'size' => $size / 1024);
			$fileTotals['size'] += $size;
			if ($size > $fileTotals['largest']) {
				$fileTotals['largest'] = $size;
			}
		}
		
		$fileTotals['size'] = $fileTotals['size'];
		$fileTotals['sizestr'] = $this->getReadableFileSize($fileTotals['size']);
		$fileTotals['largest'] = $this->getReadableFileSize($fileTotals['largest']);
		$this->output['files'] = $fileList;
		$this->output['fileTotals'] = $fileTotals;
	}
	public function rutime($ru, $rus, $index) {
			return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
			-  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
	}
	public function getTimeLoad(){
		$ru = getrusage();
		$this->output['realtime']['use'] = $this->rutime($ru, $this->rustart, "utime");
		$this->output['realtime']['call'] = $this->rutime($ru,  $this->rustart, "stime");
	}
	public function getIpUser()
    {
        $ip = "127.0.0.1";
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "UNKNOWN";
        }
        if ($ip == "::1") {
            $ip = "127.0.0.1";
        }
        $this->output['userip'] = $ip;
    }
	public function getAddressServer()
    {
        $port = $_SERVER['SERVER_PORT'];
        $http = "http";
        if ($port == "80") {
            $port = "";
        }
        if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $http = "https";
        }
        if (empty($port)) {
            $server =  $http . "://" . $_SERVER['SERVER_NAME'];
        } else {
            $server = $http . "://" . $_SERVER['SERVER_NAME'] . ":" . $port;
        }
		$this->output['server'] = $server;
    }
	public function getData(){
        $data = [
            'SERVER' => $_SERVER,
            'GET' => $_GET,
            'POST' => $_POST,
            'COOKIE' => $_COOKIE,
            'FILES' => $_FILES
        ];
        if (isset($_SESSION)) {
            $data['SESSION'] = $_SESSION;
        }
		$this->output['request'] = $data;
	}
	public function getMemoryLimit(){
		$memory_limit = ini_get('memory_limit');
		if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
			if ($matches[2] == 'M') {
				$memory_limit = $matches[1] * 1024 * 1024; 
			} else if ($matches[2] == 'K') {
				$memory_limit = $matches[1] * 1024; 
			}
		}
		return $memory_limit ;
	}
    public function gatherMemoryData() {
		$memoryTotals = array();
		$memoryTotals['used'] = memory_get_peak_usage(true)  / 1024;
		$memoryTotals['total'] = $this->getMemoryLimit()  / 1024;
		$memoryTotals['usedstr'] = $this->getReadableFileSize(memory_get_peak_usage());
		$memoryTotals['totalstr'] = ini_get('memory_limit');
		$this->output['memoryTotals'] = $memoryTotals;
	}
    public function getReadableFileSize($size, $retString = null) {
		$sizes = array('bytes', 'kB', 'MB', 'GB', 'TB');
		if ($retString === null) {
			$retString = '%01.2f %s';
		}
		$lastSizeString = end($sizes);
		foreach ($sizes as $sizeString) {
			if ($size < 1024) {
				break;
			}
			if ($sizeString != $lastSizeString) {
				$size /= 1024;
			}
		}
		if ($sizeString == $sizes[0]) {
			$retString = '%01d %s';
		}
		return sprintf($retString, $size, $sizeString);
	}
    public function gatherSpeedData() {
		$speedTotals = array();
		$speedTotals['total'] = $this->getReadableTime((microtime(true) - $GLOBALS["startTime"])*1000);
		$speedTotals['allowed'] = ini_get('max_execution_time');
		$this->output['speedTotals'] = $speedTotals;
	}
    public function getReadableTime($time) {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if ($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if ($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret, 3, '.', '') . ' ' . $formats[$formatter];
		return $ret;
	}
	public function getServerLoad() {
        if (stristr(PHP_OS, 'win')) {
            $wmi = new \COM("Winmgmts://");
            $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
            $cpuNum = 0;
            $loadTotal = 0;
            foreach($server as $cpu){
                $cpuNum++;
                $loadTotal += $cpu->loadpercentage;
            }
            $load = round($loadTotal/$cpuNum);
        } else {
            $sysLoad = sys_getloadavg();
            $load = $sysLoad[0];
        }
		$this->output['processoruse'] =  $load;
    }
    public function display() {
		$indicesServer = array('PHP_SELF','argv','argc', 'GATEWAY_INTERFACE', 'SERVER_ADDR', 'SERVER_NAME', 'SERVER_SOFTWARE', 'SERVER_PROTOCOL', 'REQUEST_METHOD', 'REQUEST_TIME', 'REQUEST_TIME_FLOAT','QUERY_STRING', 'DOCUMENT_ROOT', 'HTTP_ACCEPT', 'HTTP_ACCEPT_CHARSET', 'HTTP_ACCEPT_ENCODING','HTTP_ACCEPT_LANGUAGE', 'HTTP_CONNECTION', 'HTTP_HOST', 'HTTP_REFERER', 'HTTP_USER_AGENT', 'HTTPS','REMOTE_ADDR', 'REMOTE_HOST','REMOTE_PORT', 'REMOTE_USER', 'REDIRECT_REMOTE_USER','SCRIPT_FILENAME', 'SERVER_ADMIN','SERVER_PORT', 'SERVER_SIGNATURE', 'PATH_TRANSLATED', 'SCRIPT_NAME', 'REQUEST_URI', 'PHP_AUTH_DIGEST','PHP_AUTH_USER', 'PHP_AUTH_PW', 'AUTH_TYPE', 'PATH_INFO', 'ORIG_PATH_INFO') ; 
		$this->output['indicesServer'] = $indicesServer;
		$this->getAddressServer();
		$this->gatherFileData();
		$this->gatherMemoryData();
		$this->getIpUser();
		$this->getData();
		$this->gatherSpeedData();
		$this->output['env'] = \app\persona\Persona::singleton()->config->system->currentEnv;
        $this->output['BT'] = $this->persona->btrace;
		return self::loadBar($this->output);
	}

    public static function displayCssJavascript() {
		echo '<style type="text/css">' . file_get_contents(dirname(__FILE__) . '/rsc/css/profiler.css') . '</style>';
		echo '<script type="text/javascript">' . file_get_contents(dirname(__FILE__) . '/rsc/js/profiler.js') . '</script>';
	}
	

	public static function loadBar($var){
		ob_start();
		extract($var);
		require(dirname(__FILE__) .'/Profiler.phtml');
		self::displayCssJavascript();
		return  ob_get_clean();
	}
}
