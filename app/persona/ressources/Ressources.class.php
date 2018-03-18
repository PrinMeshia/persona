<?php
    namespace app\persona\ressources;

    use app\persona\Persona;

    class Ressources 
    {
        private $_path = [];
        private $_cssMeta = "<link rel='stylesheet' type='text/css' href='$1'/>\n";
        private $_jsMeta = "<script type='text/javascript' src='$1'></script> \n";
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
        private function loadFile($type,$meta){
            $temp = [];
            $html = '';
            foreach ( $this->_path[$type] as $key => $value) {
                array_push($temp,$this->getListFile($value,$type));
            }
            foreach ($temp as $key => $value) {
                foreach ($value as $file) {
                    if(is_readable($file))
                        $html .= str_replace("$1",str_replace(ROOT, "", $file),$meta);
                }
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
    