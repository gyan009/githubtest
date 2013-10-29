<?php 
require_once ('config/config.php');
/**
 * __autoload
 *  
 * Autoloading user defined classes
 *
 * @param string $class (class name)
 * @return null
 */
function __autoload($class){
	require('lib/'.$class.'.php');
}
class MIS{
	function loadClasses($class){
		if(!isset($this->$class)){
			$this->$class = new $class();
		}
	}
	
	function load_array($array = array()){
		foreach($array as $class){
			$this->loadClasses($class);
		}	
	}	
	function getclass(){
	    if ($handle = opendir('./lib')) {
		while (false !== ($entry = readdir($handle))) {
		    if ($entry != "." && $entry != "..") {
			if($entry!='.svn'){
			    $entry = substr($entry, 0, -4);
			    $files[] = $entry;
			}
		    }
		}
		closedir($handle);
		return $files;
	    }
	}
	
}


$mis = new MIS();
$mis->load_array($mis->getclass());

?>
