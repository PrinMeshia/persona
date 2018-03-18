<?php
    namespace app\persona\ressources;

    use app\persona\Persona;

    class Ressources 
    {
        private $_path = [];
        public function __construct()
        {
            $this->_path["js"] = [];
            $this->_path["css"] = [];
        }
        private function assignRessourceFolder($dirName,$type){
            if(is_dir(ROOT.$dirName))
                array_push($this->_path[$type],ROOT.$dirName);
        }
        public function assignCssfolder($dirName){
            $this->assignRessourceFolder($dirName,"css");
        }
        public function assignJsfolder($dirName){
            $this->assignRessourceFolder($dirName,"js");
        }
        private function getListFile($dirname,$ext){
            return glob($dirname.'*.'.$ext);
        }
        public function loadJsFile(){
            $ArrayJs = [];
            $html = '';
            foreach ( $this->_path["js"] as $key => $value) {
                array_push($ArrayJs,$this->getListFile($value,"js"));
            }
            foreach ($ArrayJs as $key => $value) {
                foreach ($value as $file) {
                    
                    $html .= "<script type='text/javascript' src='".str_replace(ROOT, "", $file)."'></script> \n";
                }
                
            }
            return $html;
            

        }
        public function loadCssFile(){
            $ArrayCss = [];
            $html = '';
            foreach ( $this->_path["css"] as $key => $value) {
                array_push($ArrayCss,$this->getListFile($value,"css"));
            }
            
            foreach ($ArrayCss as $key => $value) {
                foreach ($value as $file) {
                    $html .= "<link rel='stylesheet' type='text/css' href='".str_replace(ROOT, "", $file)."'/>\n";
                }
               
            }
            return $html;
            
        }

    }
    