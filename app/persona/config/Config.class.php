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
        return self::$configVariables[ $index ];
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
			if (file_exists($filename))
			{
				$content = file_get_contents($filename);
				$content = preg_replace('#\/\/[^"\n]*$#m', '', $content);
				$this->loadData(json_decode($content, TRUE));
			}
		}
        $this->setEnvironnment();

	}
    private function loadData($array)	
	{
		foreach ($array as $name => $value)
		{
			if(isset($this->{$name}))
                $this->{$name} = [$this->{$name},$value];
            else
                $this->{$name} = $value;
        }
	}
    public static function getAll(){
        return self::$configVariables;
    }
    public static function clean(){
        self::$configVariables = [];
    }
    private  function setEnvironnment(){
        self::$configVariables['currentEnv'] = '';
        foreach ($this->environnement as $key => $value) {
            if(array_search(Helpers::getUrlServer(),$value['url']) !== false){
                self::$configVariables['currentEnv'] = $key;
            }
        }
    }
}