<?php
namespace app\persona\helpers;
class Helpers
{
    /**
     * @return string
     */
    public static function getAddressServer($withport = true)
    {
        $port = $_SERVER['SERVER_PORT'];
        $http = "http";
        if ($port == "80" || !$withport) {
            $port = "";
        }
        if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $http = "https";
        }
        if (empty($port)) {
            return $http . "://" . $_SERVER['SERVER_NAME'];
        } else {
            return $http . "://" . $_SERVER['SERVER_NAME'] . ":" . $port;
        }
    }
    public static function getUrlServer()
    {
        $port = $_SERVER['SERVER_PORT'];
        if ($port == "80") {
            $port = "";
        }
        if (empty($port)) {
            return $_SERVER['SERVER_NAME'];
        } else {
            return $_SERVER['SERVER_NAME'] . ":" . $port;
        }
    }
    /**
     * @return bool
     */
    public static function localhost()
    {
        // if this is localhost
        return $_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '::1';
    }
    /**
     * @return string
     */
    public static function getIpUser()
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
        return $ip;
    }
    /**
     * @return bool
     */
    public static function callAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
    }
    /**
     * @param $path
     * @param string $sub
     * @return mixed
     */
    public static function UrlContent($path, $sub = 'application')
    {
        if (self::startsWith($path, '~')) {
            $appPath = ROOT . '/' . $sub . (self::startsWith($path, '~/') ? '' : '/');
            $result = str_replace('~', $appPath, $path);
            $result = str_replace('//' , '/', $result);
            return $result;
        } else {
            return $path;
        }
    }
    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

     public static function parseFile($file,$section = true)
    {
        return parse_ini_file($file,$section);
    }
    public static function getDirectory($controller)
    {
        $parts = explode('\\', $controller);
        array_pop($parts);
        return implode("/",$parts);
    }
    public static function dd(){
        
    }

}