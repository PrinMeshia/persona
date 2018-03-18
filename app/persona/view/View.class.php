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
    private $layout;
    private $reservedVariables = ['siteDetail', 'body'];
    private $tpl;
    public function __construct()
    {
        $this->layout = ROOT . Persona::getInstance()->config->layout->path . Persona::getInstance()->config->system->template_ext;
        Persona::getInstance()->ressources->assignCssfolder(Persona::getInstance()->config->path->public_css);
        Persona::getInstance()->ressources->assignJsfolder(Persona::getInstance()->config->path->public_js);
    }

    public function load($view, array $vars = [])
    {
        $this->tpl = Persona::getInstance()->template;
        $this->tpl->constantAssign('imgpath', Persona::getInstance()->config->path->public_img);
        foreach (Persona::getInstance()->config->website as $key => $value) {
            $this->tpl->constantAssign('site_' . $key, $value);
        }
        $vars = $this->validateVariables($vars);
        $urlView = ROOT . $view . Persona::getInstance()->config->system->template_ext;
        if (file_exists($urlView)) {
            foreach ($vars as $key => $value) {
                $this->tpl->assign($key, $value);
            }
            $body = $this->tpl->render($urlView);
            $this->tpl->assign("cssfile", Persona::getInstance()->ressources->loadCssFile());
            $this->tpl->assign("jsfile", Persona::getInstance()->ressources->loadJsFile());
            $this->tpl->assign("body", $body);

            echo ($this->tpl->render($this->layout));
        } else {
            return $this->throwError("View filename '{$view}" . Persona::getInstance()->config->system->template_ext . "' not found", 409);
        }

    }
    private function validateVariables(array $variables = [])
    {
        foreach ($variables as $name => $value) {
            if (in_array($name, $this->reservedVariables)) {
                return $this->throwError("Unacceptable view variable given: '{$name}'", 409);
            }
        }
        return $variables;
    }
    private function throwError($msg, $code)
    {
        if (Persona::getInstance()->config->debug && Persona::getInstance()->config->debug == 2)
            return Persona::getInstance()->response->error($msg, $code);
        else
            return Persona::getInstance()->response->error('', $code);
    }

}