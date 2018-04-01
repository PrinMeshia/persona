<?php

/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 12:37
 * file : Session.class.php
 * description :
 */
namespace app\persona\session;
class Session
{
    private $_id;
    private $_sessionid;
    public function start()
    {
        session_start();
        $this->_id = uniqid();
        $this->_sessionid = session_id();
    }
    /**
     * @param $session_id
     * @return bool
     */
    private function sessionValidId($session_id)
    {
        return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $session_id) > 0;
    }
    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (!isset($_SESSION[$key])) {
            return null;
        }
        return $_SESSION[$key];
    }

    /**
     * @return bool
     */
    public function getId()
    {
        return $this->_sessionid;
    }
}