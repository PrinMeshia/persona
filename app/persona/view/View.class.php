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
    private $personna;
    public function __construct($personna)
    {
        $this->persona = $personna;
    }
    public function load($view, $vars = array(), $template = null)
    {

        $urlView = VIEWPATH . $view . '.phtml';
        $this->persona->template->assign($vars);
         //extract($vars, EXTR_OVERWRITE);
        if (file_exists($urlView)) {
            if ($template) {

                
                require($urlView);
                $content = ob_get_clean();

                $this->persona->template->assign('content', $content);
                $this->persona->template->parse(VIEWPATH . 'template/' . $template . '.phtml');
                 //require(VIEWPATH . 'template/' . $template . '.phtml');
            } else {
                require($urlView);
            }
        } else {
            if (DEFENV == ENVDEV)
                return $this->persona->response->error("View filename '{$view}' NOT found in '" . VIEWPATH . "'.", 2);
            else
                return $this->persona->response->error('', 2);
        }
    }
}