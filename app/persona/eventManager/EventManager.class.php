<?php
namespace app\persona\event\EventManager;

class EventManager 
{
    public static $Priority = 10;
    protected $_listeners = [];
    protected $_eventList;

    private $events = array();

    public function attach($name, $callback) {
        $this->events[$name][] = $callback;
    }

    public function trigger($name, $params = array()) {
        foreach ($this->events[$name] as $event => $callback) {
            $e = new Event($name, $params);
            $callback($e);
        }
    }

}
