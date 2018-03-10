<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 04/04/2017 14:52
 * Project : a10t2
 * file : Response.class.php
 * description :
 */

namespace app\persona\http;
use app\persona\Persona;
class Response
{
    public function __construct(){
    }
    protected function forbidden(){
        header('HTTP/1.0 403 forbidden');
        die('Accès interdit');
    }
    protected function e302($href){
        header('HTTP/1.0 302 Found');
        header( 'Location: ' . $href ) ;
    }
    public function Response($filename = '', array $vars = [], $status = 200, array $headers = [],$asText = 0){
        Persona::getInstance()->btrace = ob_get_clean();
        Persona::getInstance()->setStatusCode($status);
        if (count($headers)){
            $this->addCustomHeaders($headers);
        }
        if (!$asText){
            Persona::getInstance()->view->load($filename, $vars, $this);
        }
        else 
            echo $filename;
    }
    public function ResponseHTML($html = '', $status = 200, array $headers = []){
        return $this->Response($html, [], $status, $headers, true);
    }
    public function JsonResponse($data = null, $status = 200, array $headers = [] ){
        Persona::getInstance()->setStatusCode($status);
        header('Content-Type: application/json');
        if (count($headers)){
            $this->addCustomHeaders($headers);
        }
        echo json_encode($data);
        exit;
    }
    private function addCustomHeaders(array $headers = []){
        foreach($headers as $key=>$header){
            header($key.': '.$header);
        }
    }
    public function error($msg = '', $number = 0){
        $status = Persona::getInstance()->setStatusCode($number);
        $filename = 'e'+$number;
        $vars = [];

       if (Persona::getInstance()->config->debug && Persona::getInstance()->config->debug == 2){
            $vars['exception'] = new \Exception($msg);
            $vars['note'] = "Routes begin always with '/' character.";
        }
        if(file_exists('info/'.$filename))
            $this->Response('info/'.$filename,$vars,$number);
        else{
            $this->ResponseHTML($msg, $number);
        }
           
        return false;
    }
}