<?php require_once('autoload.php'); ?>

<?php 
if(isset($_GET['r'])){
    $strip= explode("/", $_GET['r']);
     require_once('plugins/'.$strip[0].'/ajax.php');
} else {
    require_once ('error.php');
}
?>