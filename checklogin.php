<?php
 require_once('autoload.php');
 $username = $_POST['username'];
 $password = $_POST['password'];
 $mis->Login->LoginUser($username, $password);
 exit;

?>
