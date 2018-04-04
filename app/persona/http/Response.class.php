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
    private function clearEntry(){
        $_SESSION["DEBUG"] = ob_get_clean();
        ob_end_clean();
    }
    public function Response($filename = '', array $vars = [], $status = 200, array $headers = [],$asText = 0){
        $this->clearEntry();
        Persona::getInstance()->setStatusCode(is_numeric($status)?$status:200);
        if (!$asText){
            Persona::getInstance()->view->load($filename, $vars);
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
    public function maintenance(){
        $filepath = Persona::getInstance()->config->layout->maintenance;
        $vars = [];
        
        if(Persona::getInstance()->config->feature->hide_header_error)
            $vars['no_header'] = true;
            $vars['no_js'] = true;
        if(file_exists(ROOT.$filepath.Persona::getInstance()->config->system->template_ext))
            $this->Response($filepath,$vars,200,[],0);
        else{
           $this->error(Persona::getInstance()->config->messages->maintenance,200);
        }
    }
    public function error($msg = '', $number = 0){
        $filename = $number;
        $filepath = Persona::getInstance()->config->layout->error;
        $vars = [];
        $vars['note'] = $msg;
        $vars['code'] = $number;
       if (isset(Persona::getInstance()->config->debug) && Persona::getInstance()->config->debug == 2)
            $vars['exception'] = new \Exception($msg);
        if(Persona::getInstance()->config->feature->hide_header_error)
            $vars['no_header'] = true;
        if(file_exists(ROOT.$filepath.Persona::getInstance()->config->system->template_ext))
            $this->Response($filepath,$vars,$number,[],0);
        else{
            $this->ResponseHTML($msg, $number);
        }
           
        return false;
    }
}