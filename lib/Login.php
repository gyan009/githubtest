<?php

class Login {
    public $username;
    public $password;
    
    function __construct() {
		$this->db= new DBconnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
    public function checkLogin(){
	if($_SESSION['userid']){ 
	    return true;
	} else{
	   return $this->db->Redirect("login.php"); 
	}
    }
    public function LoginUser($username, $password){
	return $this->_checkUsernamePassword($username, $password);
    }
    
    private function _checkUsernamePassword($username, $password) {
	$encPassword = $this->_encryptPassword($password);
	$prams = array('username'=>$username,'password'=>$encPassword,'active'=>1);
	$user = $this->db->Select("mis_users", $prams, '',  '1','' );
	if(isset($user['id']) && !empty($user['id'])){
	    if($this->_setSession($user)==true){
		 $this->db->Redirect("index.php");
	    }
	} else{
	    session_start();
	    $_SESSION['error']=PASSWORD_INCORRECT;
	    $this->db->Redirect("login.php"); 
	}
    } 
    private function _setSession($user){
	session_start();
	$_SESSION['userid']	= $user['id'];
	$_SESSION['userName']	= $user['username'];
	$_SESSION['name']	= $user['name'];
	$_SESSION['role_id']	= $user['user_role_id'];
	return true;
    }

    private function _encryptPassword($password) {
	$password = sha1($password);
	for($i=0; $i<100; $i++){
	    $password = md5($password);
	}
	return $password;
    }
    
   public function checkurl(){
        $dataUrl = $this->db->ExecuteSQL("SELECT MM.url 
				    FROM `mis_menu_role` AS MMR 
				    INNER JOIN `mis_menu` AS MM ON MM.id=MMR.`menu_id` 
				    WHERE MMR.`user_role_id`='".$_SESSION['role_id']."'" );
	foreach($dataUrl as $data){
	    $url[] = $data['url'];
	}
   }

    public function Logout() {
	session_start();
	session_destroy();
	$this->db->Redirect("login.php");
    }
    
}
?>
