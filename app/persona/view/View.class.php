<?php

/**
 * Created by Prim'Meshia.
 * Datetime : 30/03/2017 09:04
 * Project : app
 * file : View.class.php
 * description :
 */

namespace app\persona\View;

use app\persona\Persona;


class View
{
    protected $data;
    protected $src;
    private $viewPath;
    private $templateExt = '.tpl';
    private $layout;
    private $reservedVariables = ['siteDetail', 'body'];
    private $tpl;
    public function __construct()
    {
        $this->layout = ROOTPATH . Persona::getInstance()->config->layout->path . $this->templateExt;
       
    }
    public function load($view, array $vars = [])
    {
        $this->tpl =  new Template();
        $vars = $this->validateVariables($vars);
        $urlView = ROOT . $view . $this->templateExt;
        if (file_exists($urlView)) {
            foreach ($vars as $key => $value) {
                $this->tpl->assign($key ,$value);
            }
            $body = $this->tpl->render($urlView);
            $this->tpl->assign("body",$body);
            foreach (Persona::getInstance()->config->website as $key => $value) {
                $this->tpl->assign('site_' . $key ,$value);
            }
            echo ($this->tpl->render($this->layout));
        } else {
            if (Persona::getInstance()->config->debug && Persona::getInstance()->config->debug == 2)
                return Persona::getInstance()->response->error("View filename '{$view}{$this->templateExt}' not found", 409);
            else
                return Persona::getInstance()->response->error('', 409);
        }
    }
    private function validateVariables(array $variables = [])
    {
        foreach ($variables as $name => $value) {
            if (in_array($name, $this->reservedVariables)) {
                return Persona::getInstance()->response->error("Unacceptable view variable given: '{$name}'", 409);
            }
        }
        return $variables;
    }

}