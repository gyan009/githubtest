<?php
class Menus {

    function __construct() {
		$this->db= new DBconnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
   
    public function Menus(){
	return $this->_Menus();
    }
    
    private function _Menus(){
	$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];
	$filename = basename($SCRIPT_FILENAME);
	$role_id = $_SESSION['role_id'];
	$menuesParents = $this->_menuesParent($role_id);
	$menusData = "";
	$menusData .= '<ul class="nav navbar-nav">';
	foreach($menuesParents as $menuesParent){
	    $menuesChids = $this->_menuesChild($role_id, $menuesParent['id']);

	    if($menuesChids['count']>0){
		$class = 'class="dropdown"';
	    } else if($menuesParent['url']==$filename) {
		$class ='class="active"';
	    } else {
		$class="";
	    }

	    if($menuesChids['count']>0){
	     $menusData .='<li '.$class.'><a href="'.$menuesParent['url'].'" class="dropdown-toggle" data-toggle="dropdown">'.$menuesParent['label'];
		$menusData .='<b class="caret"></b></a><ul class="dropdown-menu">';
		if(!isset($menuesChids['data']['url'])){
		    foreach($menuesChids['data'] as $menuesChid){
			  if(isset($menuesChid['url'])){
			   $menusData .='<li><a href="'.$menuesChid['url'].'">'.$menuesChid['label'].'</a></li>';
			  }
		    }
		} else{

		  $menusData .='<li><a href="'.$menuesChids['data']['url'].'">'.$menuesChids['data']['label'].'</a></li>';  
		}
	    $menusData .='</ul></li>';
	} else{
	    $menusData .='<li '.$class.'><a href="'.$menuesParent['url'].'">'.$menuesParent['label'].'</a></li>';
	  }
	}
	$menusData .= '</ul>';
	return $menusData;
    }
    private function _menuesParent($role_id) {
	$prams = array('MM.parent'=>'0','MM.active'=>1, 'MMR.user_role_id'=>$role_id);
	$menus = $this->db->Select("`mis_menu` AS MM INNER JOIN `mis_menu_role` as MMR ON MM.id=MMR.menu_id", $prams, 'MM.sort ASC',  '','','AND','MM.url, MM.label,MM.id' );
	return $menus;
    }
    private function _menuesChild($role_id,$id ) {
	$prams = array('MM.parent'=>$id,'MM.active'=>1, 'MMR.user_role_id'=>$role_id);
	$menusChild = $this->db->Select("`mis_menu` AS MM INNER JOIN `mis_menu_role` as MMR ON MM.id=MMR.menu_id", $prams, 'MM.sort ASC',  '','','AND','MM.url, MM.label,MM.id' );
	$menusCount = $this->db->CountRows("`mis_menu` AS MM INNER JOIN `mis_menu_role` as MMR ON MM.id=MMR.menu_id", $prams );
	return array('data'=>$menusChild, 'count'=>$menusCount);
    }

}
?>
