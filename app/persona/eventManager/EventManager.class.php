<?php
namespace app\persona\event\EventManager;


class EventManager 
{
    public static $Priority = 10;
    protected static $_listeners = [];
    protected $_eventList;

    private $events = array();

    public function attach($name, $callback) {
        try {
            if(empty($name) OR empty($callback))
                throw new \Exception();
            if(isset(self::$_listeners[$name]))
                throw new \Exception("{$name} :: allready exist.");
            self::$_listeners[$name] = $callback;
        }
        catch (Exception $e) {
            throw new \Exception('[EventManager::attach]'.$e->getMessage());
        }
    }


    public static function Trigger($name = '') {
        try {
            if(empty($name))
                throw new \Exception();
            
            @$Func = self::$_listeners[$name];
            if(isset($Func)) {
                if(is_callable($Func)) {
                    $Args = func_get_args();
                    array_shift($Args);
                    if(call_user_func_array($Func, $Args) === FALSE)
                        throw new \Exception("{$name} :: Error Callback.");
                }
            }
        
        }
        catch (Exception $e) {
            throw new \Exception('[EventManager::Trigger] '.$e->getMessage());
        }
    }
}
