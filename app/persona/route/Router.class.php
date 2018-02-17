<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 15:42
 * Project : a10t2
 * file : Router.class.php
 * description :
 */
namespace app\persona\route;


class Router
{
    private $persona;
    public function __construct($persona){
        $this->persona = $persona;
    }
      /**
         * @param $uri
         * @param $method (GET,POST,PUT,DELETE,RESPOND)
         * @param callable $callback
         * create route
         */
    
    public function traverseRoutes($method = 'GET', array $routes, array &$slugs){
        if (isset($routes[$method])){
            foreach($routes[$method] as $route)
                if($func = $this->processUri($route, $slugs)){
                    call_user_func_array($func, $slugs);
                    return true;
                }
        }
        return false;
    }
    public  function getSegment($segment_number){
        $uri = $this->persona->request->getRequestedUri();
        $uri_segments = preg_split('/[\/]+/',$uri,null,PREG_SPLIT_NO_EMPTY);
        return isset($uri_segments[$segment_number]) ? $uri_segments[$segment_number] : false;
    }
    private function processUri($route, &$slugs = []){
        $url = $this->persona->request->getRequestedUri();
        $uri = parse_url($url, PHP_URL_PATH);
        $func = $this->matchUriWithRoute($uri, $route, $slugs);
        return $func ? $func : false;
    }
    static function matchUriWithRoute($uri, $route, &$slugs){
        $uri_segments = preg_split('/[\/]+/', $uri, null, PREG_SPLIT_NO_EMPTY);
        $route_segments = preg_split('/[\/]+/', $route->route, null, PREG_SPLIT_NO_EMPTY);
        if (self::compareSegments($uri_segments, $route_segments, $slugs)){
            //route matched
            return $route->function; //Object route
        }
        return false;
    }
    static function CompareSegments($uri_segments, $route_segments, &$slugs){
        if (count($uri_segments) != count($route_segments)) return false;
        foreach($uri_segments as $segment_index => $segment){
            $segment_route = $route_segments[$segment_index];
            $is_slug = preg_match('/^{[^\/]*}$/', $segment_route) || preg_match('/^:[^\/]*/', $segment_route,$matches);
            if ($is_slug){//Note php does not support named parameters
                if (strlen(trim($segment)) === 0){
                    return false;
                }
                $slugs[ str_ireplace(array(':', '{', '}'), '', $segment_route) ] = $segment;//save slug key => value
            }
            else if($segment_route !== $segment && $is_slug !== 1)
                return false;
        }
        return true;
    }
}