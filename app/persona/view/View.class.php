<?php

/**
 * Created by Prim'Meshia.
 * Datetime : 30/03/2017 09:04
 * Project : app
 * file : View.class.php
 * description :
 */

namespace app\persona\View;

class View
{
    protected $data;
    protected $src;
    private $persona;
    private $viewPath ;
    private $templateExt = '.tpl';
    private $layout ;
    private $reservedVariables = ['siteDetail', 'body'];
    public function __construct($persona)
    {
        $this->persona = $persona;
        $this->layout = ROOT.$persona->config->layout->path.$this->templateExt;
    }
    public function load($view, array $vars = [])
    {
        $vars = $this->validateVariables($vars);
        $urlView = ROOT.$view . $this->templateExt;
        //$this->persona->template->assign($vars);
         //extract($vars, EXTR_OVERWRITE);
         if (file_exists($urlView)) {
             $baseView = file_get_contents($this->layout);
             $body = file_get_contents($urlView);
             $page = str_replace('{{body}}', $body, $baseView);
             foreach ($this->persona->config->website as $key => $value) {
               $page = str_replace('{{site_'.$key.'}}', $value, $page);
            }
             foreach ($vars as $key => $value) {
                $page = str_replace('{{'.$key.'}}', $value, $page);
             }
             echo($page);
             
        //     if ($template) {
        //         require($urlView);
        //         $content = ob_get_clean();
        //         $this->persona->template->assign('content', $content);
        //         $this->persona->template->parse(VIEWPATH . 'template/' . $template . '.phtml');
        //          //require(VIEWPATH . 'template/' . $template . '.phtml');
        //     } else {
        //         require($urlView);
        //     }
         } else {
            if ($this->persona->config->debug && $this->persona->config->debug == 2)
                return $this->persona->response->error("View filename '{$view}{$this->templateExt}' not found", 409);
            else
                return $this->persona->response->error('', 409);
        }
    }
    private function validateVariables(array $variables = [])
    {
        foreach ($variables as $name => $value) {
            if (in_array($name, $this->reservedVariables)) {
                return $this->persona->response->error("Unacceptable view variable given: '{$name}'", 409);
            }
        }
        
 
        return $variables;
    }
 
   
 
    private function getFile($controller)
    {
        return str_replace(APP_CONTROLLER_METHOD_SUFFIX, null, $controller);
    }
}