<?php require_once('autoload.php'); ?>
<?php require_once('includes/header.php'); ?>
    <!-- Fixed navbar -->
    

    <div class="container">
	<div style="height: 40px;"></div>
	    <?php if($_SESSION['role_id']!=1){?>
		<div class="page-header">
		<h3>PharmaSecure Dashboard</h3>
		</div>

		    <p>
			<a href="plugins.php?r=cheer" class="btn btn-primary">Home</a>
			<a href="plugins.php?r=cheer/enrollmenthistory" class="btn btn-primary">Enrollment History</a>
			<a href="plugins.php?r=cheer/servicetracker" class="btn btn-primary">Service Tracker</a>
			<a href="plugins.php?r=cheer/billing" class="btn btn-primary">Billing</a>
			 <a href="plugins.php?r=cheer/cheer" class="btn btn-primary">Cheer</a>  
		    </p>
		<div class="page-header">
		<h3>SBO Dashboard</h3>
		</div>
		   <p> 
			<a href="plugins.php?r=cheer/sbo/sbo" class="btn btn-primary">Home</a>
			<a href="plugins.php?r=cheer/sbo/sboenrollmenthistory" class="btn btn-primary">Enrollment History</a>
			<a href="plugins.php?r=cheer/sbo/sboservicetracker" class="btn btn-primary">Services Tracker</a>
		  </p>

	<?php  }?>

    </div> <!-- /container -->
    
    

<?php require_once('includes/footer.php'); ?>

