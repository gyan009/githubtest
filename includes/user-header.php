<?php  $SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];
	$filename = basename($SCRIPT_FILENAME);
	
?>
<div class="page-header">
        <h1>Users</h1>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="list-inline">
	    <a href="users.php" class="list-group-item <?php if($filename=='users.php'){?>active <?php } ?>" >Manage Users</a>
	    <a href="add-user.php" class="list-group-item <?php if($filename=='add-user.php'){?>active <?php } ?>"">Add User</a>
          </div>
        </div><!-- /.col-sm-4 -->
   
      </div>