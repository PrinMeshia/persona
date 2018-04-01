<?php
    namespace app\persona\ressources;

    use app\persona\Persona;
    use app\persona\helpers\Helpers;

    class Ressources 
    {
        private $_path = [];
        private $_file = [];
        private $_cssMeta = "<link rel='stylesheet' type='text/css' href='%s'/>\n";
        private $_jsMeta = "<script type='text/javascript' src='%s'></script> \n";
        public function __construct()
        {
            $this->_path["js"] = [];
            $this->_path["css"] = [];
            $this->_file["js"] = [];
            $this->_file["css"] = [];
        }
        private function assignRessourceFolder($dirName,$type){
            if(is_dir(ROOT.$dirName))
                array_push($this->_path[$type],ROOT.$dirName);
        }
        private function assignRessourceFile($file,$type){
            array_push($this->_file[$type],ROOT.$file);
        }
        public function assignJsFile($file){
            $this->assignRessourceFile($file,"css");
        }
        public function assignCssFile($file){
            $this->assignRessourceFile($file,"css");
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
        private function loadFile($type,$meta){
            $temp = [];
            $html = '';
            foreach ( $this->_path[$type] as $key => $value) {
                array_push($temp,$this->getListFile($value,$type));
            }
            foreach ($temp as $key => $value) {
                foreach ($value as $file) {
                    if(is_readable($file))
                        $html .= sprintf($meta, str_replace(ROOT, Helpers::localhost() ? "/persona/":"", $file));
                }
            }
            foreach ($this->_file[$type] as $file) {
                if(is_readable($file))
                    $html .= sprintf($meta, str_replace(ROOT, "", $file));
            }
            return $html;
        }
        public function loadJsFile(){
            return $this->loadFile("js",$this->_jsMeta);
        }
        public function loadCssFile(){
            return $this->loadFile("css",$this->_cssMeta);
        }
    }
    