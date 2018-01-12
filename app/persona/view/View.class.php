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
    private static $_core;
    public static $btrace;
    public function __construct($core){
        self::$_core = $core;
    }
     public function load($view,$vars=array(),$template = null){

         $urlView = VIEWPATH.$view.'.phtml';
         self::$_core->template->assign($vars);
         //extract($vars, EXTR_OVERWRITE);
         echo 'toto';
         self::$btrace = ob_get_clean();
         if (file_exists($urlView)) {
             if ($template) {
                 
                 ob_start();
                 require($urlView);
                 $content = ob_get_clean();
                 
                 self::$_core->template->assign('content',$content);
                 self::$_core->template->parse(VIEWPATH . 'template/' . $template . '.phtml');
                 //require(VIEWPATH . 'template/' . $template . '.phtml');
             } else {
                 require($urlView);
             }
         } else {
                if(DEFENV == ENVDEV)
                    return self::$_core->response->error("View filename '{$view}' NOT found in '". VIEWPATH."'.",2);
                else
                    return self::$_core->response->error('',2);
        }
    }
}