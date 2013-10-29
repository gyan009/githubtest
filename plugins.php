<?php require_once('autoload.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php 
if(isset($_GET['r'])){
    $strip= explode("/", $_GET['r']);
     require_once('plugins/'.$strip[0].'/index.php');
} else {
    require_once ('error.php');
}
?>
<?php require_once('includes/footer.php'); ?>
