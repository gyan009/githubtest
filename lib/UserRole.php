<?php
class UserRole {
    var $userRole;
    var $db;
    function __construct() {

		$this->db= new DBconnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
    
    public function getUserRoleAll() {
	return 	$this->_getUserRoleAll();
    }
    
    private function _getUserRoleAll() {
	$userRole = $this->db->Select("mis_user_role", '', '',  '','' );
	return $userRole;
    }
}
?>
