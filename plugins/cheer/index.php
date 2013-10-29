<?php 
include_once (_DIRPATH_.'cheer/classes/Cheer.php');
$cheer = new Cheer();
if(isset($_GET['r'])){
    $strip= explode("/", $_GET['r']);
}
?>
<div style="height: 40px;"></div>

<div class="container ">
    <div style="height: 40px;"></div>
    <div class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
	<?php if(count($strip)=='2' || count($strip)=='1'){?>
	      <li <?php if(!isset($strip['1']) && $strip['1']==''){?>  class="active"<?php }?>><a href="plugins.php?r=cheer">Home</a></li>
	      <li <?php if(isset($strip['1']) && $strip['1']=='enrollmenthistory'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/enrollmenthistory">Enrollment History</a></li>
              <li <?php if(isset($strip['1']) && $strip['1']=='servicetracker'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/servicetracker">Service Tracker</a></li>
	      <li <?php if(isset($strip['1']) && $strip['1']=='billing'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/billing">Billing</a></li>
	      <li <?php if(isset($strip['1']) && $strip['1']=='cheer'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/cheer">Cheer</a></li>
	<?php } else {?>
	      <li <?php if(isset($strip['1']) && $strip['2']=='sbo'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/sbo/sbo">Home</a></li>
	      <li <?php if(isset($strip['1']) && $strip['2']=='sboenrollmenthistory'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/sbo/sboenrollmenthistory">Enrollment History</a></li>
	      <li <?php if(isset($strip['1']) && $strip['2']=='sboservicetracker'){?>  class="active"<?php }?>><a href="plugins.php?r=cheer/sbo/sboservicetracker">Services Tracker</a></li>
	<?php } ?>
            </ul>
            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    <?php 
	  if(count($strip)=='1'){
    ?>
    
		<div class="page-header">
		    <h3>New Patients</h3>
		</div>
		<?php echo $cheer->NewPatients();?>
		<div class="page-header">
		    <h3>Existing Patients</h3>
		</div>
		<?php echo $cheer->ExistingPatients();?>
	  <?php } else if(count($strip)=='2') { 
		    require_once($strip[1].'.php');
		}else { 
		    require_once($strip[2].'.php');
		}?>
</div>
    <link href="<?php echo _PATH_; ?>dist/css/jquery.ui.datepicker.css" rel="stylesheet">
     <link href="<?php echo _PATH_; ?>dist/css/jquery.ui.all.css" rel="stylesheet">
 <script>
	    $("#manager").change(function() {
		var selected = $(this).val();
		$.ajax({
		    url: "ajax.php?r=cheer/ajax&d=getSboList", 
		    type: "POST", 
		    data: {id : selected},
		    success: function(data) {
			$('#SboValue').html(data); 
		    }
		});
	    });
    $(document).ready(function() {
       $('#eformmonth').datepicker({
	 changeMonth: true,
	 changeYear: true,
	 dateFormat: 'yy-mm',

	 onClose: function() {
	    var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
	    var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
	    $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
	 },

	 beforeShow: function() {
	   if ((selDate = $(this).val()).length > 0) 
	   {
	      iYear = selDate.substring(selDate.length - 4, selDate.length);
	      iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), 
		       $(this).datepicker('option', 'monthNames'));
	      $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
	      $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
	   }
	}
      });
    });
    
    $(document).ready(function() {
       $('#etomonth').datepicker({
	 changeMonth: true,
	 changeYear: true,
	 dateFormat: 'yy-mm',

	 onClose: function() {
	    var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
	    var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
	    $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
	 },

	 beforeShow: function() {
	   if ((selDate = $(this).val()).length > 0) 
	   {
	      iYear = selDate.substring(selDate.length - 4, selDate.length);
	      iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), 
		       $(this).datepicker('option', 'monthNames'));
	      $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
	      $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
	   }
	}
      });
    });
   </script>