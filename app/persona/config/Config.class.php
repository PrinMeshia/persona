<?php
namespace app\persona\config;
 use \app\persona\helpers\Helpers;
class Config {
   protected static $configVariables = [];
   function __set($index, $value)
    {
        self::$configVariables[ $index ] = $value;
    }
    function __get($index)
    {
        if(!array_key_exists( $index , self::$configVariables )){
            return NULL;
        }
        if (self::$configVariables[ $index ] === NULL)
        {
            return NULL;
        }
        return self::$configVariables[ $index ];
    }
   public function loadUserConfig($path){
        $AConfig = [];
        foreach ($path as $key => $value) {
           array_push($AConfig,$value);
        }
        $this->load($AConfig);
        
   }
   public function load($filenames)
	{
        if (is_array($filenames) === FALSE)
		{
			$filenames = [$filenames];
		}
        
		$values = [];
		foreach ($filenames as $filename)
		{
            $filename = ROOT.$filename;
			if (file_exists($filename))
			{
				$content = file_get_contents($filename);
            	$this->loadData(json_decode($content, TRUE));
			}
        }
	}
    private function loadData($array)	
	{
		foreach ($array as $name => $value)
		{
            if(is_array($value))
                $this->{$name} = $this->setChildConfig($value);
            else{
                $this->{$name} = $value;
            }
            if(is_object($this->{$name}))
                $this->preprocessing($this->{$name});
        }
	}
    private function setChildConfig($array){
        
        $json = json_encode($array);
        $object = json_decode($json);
        return $object;
    }
     private function preprocessing($values)
	{
        foreach ($values as $key => $value){
            if (is_object($values->$key)){
                $this->preprocessing($values->$key);
            }else if(!is_array($values->$key)){
                
                if (preg_match('#{([\w\.]*)}#', $values->$key, $m)){
                    $name = $m[1];
                    $val = $this;
                    foreach (explode('.', $name) as $k => $attr) {
                        if($val->$attr)
                            $val = $val->$attr;
                    }
                   if(is_scalar($val)){
                        $values->$key = str_replace('{'.$name.'}', $val, $values->$key);
                   }else
					{
						trigger_error('Undefined var "'.$name.'" in the configuration file');
					}
                }
            }
        }
    }
    public static function getAll(){
        return self::$configVariables;
    }
    public static function clean(){
        self::$configVariables = [];
    }
   
}