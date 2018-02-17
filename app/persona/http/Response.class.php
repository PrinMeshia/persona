<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 04/04/2017 14:52
 * Project : a10t2
 * file : Response.class.php
 * description :
 */

namespace app\persona\http;

class Response
{
    private $persona;
    public function __construct($persona){
        $this->persona = $persona;
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
        $this->persona->btrace = ob_get_clean();
        $this->persona->setStatusCode($status);
        if (count($headers)){
            $this->addCustomHeaders($headers);
        }
        if (!$asText){
            $this->persona->view->load($filename, $vars, $this);
        }
        else 
            echo $filename;
    }
    public function ResponseHTML($html = '', $status = 200, array $headers = []){
        return $this->Response($html, [], $status, $headers, true);
    }
    public function JsonResponse($data = null, $status = 200, array $headers = [] ){
        $this->persona->setStatusCode($status);
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
        $status = $this->persona->setStatusCode($number);
        $filename = 'e'+$number;
        $vars = [];

       if ($this->persona->config->debug && $this->persona->config->debug == 2){
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