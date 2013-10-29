<?php require_once('autoload.php'); ?>
<?php require_once('includes/header.php'); 
$roles = $mis->UserRole->getUserRoleAll();
echo $mis->Users->addUsers($_POST);
?>
    <!-- Fixed navbar -->
    

    <div class="container theme-showcase">

	<div style="height: 20px;"></div>



     
<?php require_once('includes/user-header.php'); ?>
	<div style="height: 40px;"></div>
   <div class="container ">
	<form class="form-signin" action="" method="post">
	    <div class="form-signin">
	    <label >Username</label>
	    <input type="text" class="form-control " placeholder="Username" name="username" autofocus required><br>
	    <label >Password</label>
	    <input type="password" class="form-control " placeholder="Password" name="password" autofocus required><br>
	    <label >Name</label>
	    <input type="text" class="form-control " placeholder="Name" name="name" autofocus required><br>
	    <label>Email</label>
	    <input type="email" class="form-control " placeholder="Email" name="email" autofocus required><br>
	    <label>User Role</label>
	    <select  name="role" required class="form-control">
		<?php 
		for($i=0; $i<count($roles); $i++){?>
		    <option valeu="<?php echo $roles[$i]['id']?>"><?php echo $roles[$i]['role']?></option>
		<?php } ?>
	    </select><br>
	    <label>Active</label>
	    <select  name="active" class="form-control" required>
		<option valeu="1" selected>Active</option>
		<option valeu="0">De-active</option>
	    </select><br>
		    
        <input type='submit' name='submit' value='Submit' class="btn btn-lg btn-primary btn-block" type="submit">
	 <div class="row">
      </form>
   </div>

     


    


    </div> <!-- /container -->

<?php require_once('includes/footer.php'); ?>

