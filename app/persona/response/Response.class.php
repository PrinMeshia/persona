<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 04/04/2017 14:52
 * Project : a10t2
 * file : Response.class.php
 * description :
 */

namespace app\persona\response;

class Response
{
    private static $_core;
    public function __construct($core){
        self::$_core = $core;
    }
    protected function forbidden(){
        header('HTTP/1.0 403 forbidden');
        die('Accès interdit');
    }
    protected function e302($href){
        header('HTTP/1.0 302 Found');
        header( 'Location: ' . $href ) ;
    }
    public function Response($filename = '', array $vars = array(), $status = 200, array $headers = array(),$asText = 0){
        self::$_core->setStatusCode($status);
        if (count($headers)){
            $this->addCustomHeaders($headers);
        }
        if (!$asText){
            self::$registry->view->init(VIEW_DIR.$filename, $vars, $this);
            self::$registry->view->load();
        }
        else echo $filename;
    }
    public function ResponseHTML($html = '', $status = 200, array $headers = array()){
        return $this->Response($html, array(), $status, $headers, true);
    }
    public function JsonResponse($data = null, $status = 200, array $headers = array() ){
        self::$_core->setStatusCode($status);
        header('Content-Type: application/json');
        if (count($headers)){
            $this->addCustomHeaders($headers);
        }
        echo json_encode($data);
        exit;
    }
    private function addCustomHeaders(array $headers = array()){
        foreach($headers as $key=>$header){
            header($key.': '.$header);
        }
    }
    public function error($msg = '', $number = 0){
        $status = self::$_core->setStatusCode($number);
        $filename = 'e'+$number;
        $vars = [];

       if (self::$_core->config->environnement[self::$_core->config->currentEnv]['debug'] == 'full'){
            $vars['exception'] = new \Exception($msg);
            $vars['note'] = "Routes begin always with '/' character.";
        }
        if(file_exists('info/'.$filename))
            self::$_core->view->load('info/'.$filename,$vars);
        else{
             $this->ResponseHTML($msg);
        }
           
        return false;
    }
}