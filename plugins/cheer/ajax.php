<?php  
include_once (_DIRPATH_.'cheer/classes/Cheer.php');
$cheer = new Cheer();
$function = $_REQUEST['d'];
$id = $_REQUEST['id'];
 echo $cheer->$function($_REQUEST);
?>
