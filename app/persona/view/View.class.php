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
        
        $vars = $this->validateVariables($vars);
        $urlView = ROOT . $view . Persona::getInstance()->config->system->template_ext;
        if (file_exists($urlView)) {
            foreach ($vars as $key => $value) {
                $this->tpl->assign($key, $value);
            }
            foreach (Persona::getInstance()->config->website as $key => $value) {
                $this->tpl->assign('site_' . $key, $value);
            }
            $this->tpl->assign('imgpath', (Persona::getInstance()->config->rootfolder ? Persona::getInstance()->config->rootfolder : "") . Persona::getInstance()->config->path->public_img);
            $this->tpl->assign("cssfile", Persona::getInstance()->ressources->loadCssFile());
            $this->tpl->assign("jsfile", Persona::getInstance()->ressources->loadJsFile());
            $this->tpl->setContent($urlView);
            echo ($this->tpl->render($this->layout));
        } else {
            return Persona::getInstance()->response->error("View filename '{$view}" . Persona::getInstance()->config->system->template_ext . "' not found", 409);
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
    public function autoLinks($str){
        return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', $str);
    }
    public function encodeHTML($str){
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
    public function encodeHTMLWithBR($str){
        return nl2br(htmlentities($str, ENT_QUOTES, 'UTF-8'));
    }
    public function datePicker($unixtime){
        $date = date("d/m/Y", (int)$unixtime);
        return (empty($date))? "": $date;
    }
    public function unixtime($unixtime){
        $date = date("F j, Y", intval($unixtime));
        return (empty($date))? "": $date;
    }
    public function timestamp($timestamp){
        $unixTime = strtotime($timestamp);
        $date = date("F j, Y", $unixTime);
        return (empty($date))? "": $date;
    }
    public function truncate($str, $len){
        if(empty($str)) {
            return "";
        }else if(mb_strlen($str, 'UTF-8') > $len){
            return mb_substr($str, 0, $len, "UTF-8") . " ...";
        }else{
            return mb_substr($str, 0, $len, "UTF-8");
        }
    }

}