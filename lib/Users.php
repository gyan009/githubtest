<?php

class Users {
    var $db;
    var $mis;
    var $dataValue;
    
    
    function __construct() {
		$this->db= new DBconnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$this->HTML= new HTML();
    }
    
    public function getUsersAll(){
	return $this->_getUsersAll();
    }
    private function _getUsersAll() {
	$users = $this->db->Select("mis_users", '', '',  '','' );
	$data = '<table class="table table-hover table-striped table-bordered"><thead>';
	$data .='<tr><th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Action</th></tr> </thead> <tbody>';
	foreach($users as $user){
	   $data .="<tr>"; 
	   $data .="<td>".$user['id']."</td>"; 
	   $data .="<td>".$user['name']."</td>";
	   $data .="<td>".$user['username']."</td>"; 
	   $data .="<td>".$user['email']."</td>"; 
	   $data .="<td>Edit</td>";
	   $data .="</tr>"; 
	}
	
	   $data .="</tbody></table>";   
	return $data;
    }
    
     public function addUsers($data){
	 $username = $data['username'];
	 $password = $data['password'];
	 $name	   = $data['name'];
	 $email	   = $data['email'];
	 $active   = $data['active'];
	 
    }
    
}
?>
