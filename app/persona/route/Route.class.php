<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 04/04/2017 11:13
 * Project : a10t2
 * file : Route.class.php
 * description :
 */

namespace app\persona\route;


class Route
{
    public $route;
    public $function;
    public function __construct($routeKey = '', callable $func){
        $this->route = $routeKey;
        $this->function = $func;
    }
    
}