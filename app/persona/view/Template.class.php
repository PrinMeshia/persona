<?php
namespace app\persona\view;

use app\persona\Persona;

class Template
{
    private $_data = [];
    public function __construct()
    { }
    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }
    public function __get($key)
    {
        if (isset($this->_dataView[$key])) {
            return $this->_dataView[$key];
        } else if (isset($this->_data[$key])) {
            return $this->_data[$key];
        } else {
            return false;
        }
    }
    public function assign($key, $value = NULL){
        if( is_array( $key ) ) 	{
            foreach( $key as $k => $v ) {
                $this->assign( $k, $v );
            }
        } else {
            $this->_data[ $key ] = $value;
        }
    }
    public function render($tpl)
    {

        Persona::getInstance()->btrace += ob_get_clean();
        ob_start();
        foreach ($this->_data as $name => $value)
		{
			$$name = $value;
        }
        $content = file_get_contents($tpl);
        // Variable tableau
		$content = preg_replace('#([\$]([\w\[\]]+)\.(\w+))#', "$$2['$3']", $content);
		    
		// Instruction if.
		$content = preg_replace("#\[if([^\}]+)\]#", "<?php if($1):?>", $content);
		$content = str_replace("[else]", "<?php else:?>", $content);
		$content = str_replace("[/if]", "<?php endif;?>", $content);
		    
		// Instruction foreach.
		$content = preg_replace("#\[\s*each([^\}]+)\]#", "<?php foreach($1):?>", $content);
		$content = str_replace("[/each]", "<?php endforeach;?>", $content);
		    
		//remplace les caractères spéciaux ainsi que les espace
		$content = preg_replace("#\[\s*replace_special([^\]]+)\}#", "<?= preg_replace('/[^a-zA-Z1-9]+/', '', $1);?>", $content);

		// Balise PHP.
		$content = str_replace('[#', '<?= $', $content);
        $content = str_replace(array("]", "["), array("?>", "<?php "), $content);
        $tmpfile = ROOT.Persona::getInstance()->config->path->tmp.basename($tpl).'-'.md5(time()).rand(0,100).'.php';
        file_put_contents($tmpfile, $content);
        require_once($tmpfile);
        $rendered = ob_get_contents();
        ob_end_clean();
        unlink($tmpfile);
        $this->_data = [];
        return $rendered;
    }
    
    
}