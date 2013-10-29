<?php $monthfrom = (isset($_POST['eformmonth'])) ? $_POST['eformmonth'] : date('Y')."-".(date('m')-3); 
      $monthto = (isset($_POST['etomonth'])) ? $_POST['etomonth'] : date('Y')."-".date('m');
      if(isset($_POST['sbo'])){
	 $sboName = $cheer->getSboListName($_POST['sbo']);
      }
      $serviceTrackerSbo = $cheer->sboServiceTracker($monthfrom, $monthto, $_POST);
      ?>
<form action="" method="post">
    <label>Select month and year:</label>
 <input type="text" name='eformmonth' class="btn btn-default" id="eformmonth" value="<?php echo $monthfrom;?>"> 

--  <input type="text" name='etomonth' class="btn btn-default" id="etomonth" value="<?php echo $monthto;?>">
     <br> <br>
     <label class="manger">Select Manager:</label>
    <select name='manager' id="manager" class="btn btn-default" style="text-align: left;" class="manager">
	<option value="">--Select Manager--</option>
	<?php foreach($cheer->GetManager() as $manager){?>
	    <option value="<?php echo $manager['id'];?>" <?php if(isset($_POST['manager']) && ($_POST['manager']==$manager['id'])){?> selected="selected" <?php }?>><?php echo $manager['name'];?></option>
	<?php }?>
    </select>
<label>Select SBO:</label> 
<span id="SboValue">
<select name='sbo' class="btn btn-default" id="sbo" style="text-align: left;">
    <option value="">--Select SBO--</option>
    <?php if(isset($_POST['manager'])) {
	$sboList = $cheer->getSboListAll(array('id'=>$_POST['manager']));  
	    foreach($sboList as $sboData){
    ?>

	<option value="<?php echo $sboData['emp_code']; ?>" <?php if(isset($_POST['sbo']) && ($_POST['sbo']==$sboData['emp_code'])){?> selected="selected" <?php }?>><?php echo $sboData['name']; ?></option>
    <?php 
	    }
	}
    ?>
</select> 
    </span>
<button class="btn btn-primary">Submit</button>

</form>
<div style="height: 40px;"></div>
<div class="alert alert-info">
    <h4 style="text-align: center;">Patient Services history-enrolled by <?php if($_POST['manager']) { echo $sboName['name']; } else { echo " "; }?> </h4>
</div>
<table class="table table-hover table-striped table-bordered">
    <thead>
	<tr>
	    <th>Month</th>
	    <th>No. of patients</th>
	    <th colspan="4">Existing Patient Status</th>
	     <th colspan="4">New Patient Status</th>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>HTS Subscribed</th>
	    <th>RR Subscribed</th>
	    <th>HTS Sent</th>
	    <th>RR Sent</th>
	    <th>HTS Subscribed</th>
	    <th>RR Subscribed</th>
	    <th>HTS Sent</th>
	    <th>RR Sent</th>
	</tr>
    </thead>
    <tbody>
     <?php 
	foreach($serviceTrackerSbo as $key=>$serviceTracker){  ?>
	<tr>
	    <td><?php echo $key;?></td>
	    <?php foreach($serviceTracker as $value){?>
	    <td><?php echo $value['Total'];?></td>
	    <?php }?>
	    
	</tr>
	<?php } ?>
    </tbody>
</table>
<button style="float: right" class="btn btn-group-sm" onclick="window.location.href='ajax.php?r=cheer/ajax&d=sboserviceTrackerDownload&sbo=<?php echo $_POST['sbo']; ?>&eformmonth=<?php echo $monthfrom; ?>&etomonth=<?php echo $monthto; ?>'">Download</button>