<?php $monthfrom = (isset($_POST['eformmonth'])) ? $_POST['eformmonth'] : date('Y')."-".(date('m')-3); 
      $monthto = (isset($_POST['etomonth'])) ? $_POST['etomonth'] : date('Y')."-".date('m'); 
      $sboEnrollmentHistory = $cheer->sboEnrollmentHistory($_POST);
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
<button class="btn btn-primary">Submit</button>

</form>
<div style="height: 40px;"></div>
<div class="alert alert-info">
    <h4 style="text-align: center;">Patient enrolled by 
    <?php if($_POST['manager']){  
	$dataName = $cheer->getManagerName($_POST['manager']);
		echo '"'.$dataName['name'].'"';
    }?> from <?php echo date('F', strtotime($monthfrom."-01")) ?> to <?php echo date('F', strtotime($monthto."-01")) ?>- 2013</h4>
</div>
<table class="table table-hover table-striped table-bordered">
    <thead>
	<tr>
	    <th>SBO Name</th>
	    <th>SBO Region</th>
	    <th colspan="4">Existing Patient Status</th>
	     <th colspan="4">New Patient Status</th>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>Patients Contacted</th>
	    <th>Active Patients</th>
	    <th>Dropped Patients</th>
	    <th>On-hold patients</th>
	    <th>Patients Contacted</th>
	    <th>Active Patients</th>
	    <th>Declined this Services</th>
	    <th>Yet to be contacted</th>
	</tr>
    </thead>
    <tbody>
   <?php 
	foreach($sboEnrollmentHistory as $key=>$enrollmentHistory){  ?>
	<tr>
	    <td><?php echo $key;?></td>
	    <?php foreach($enrollmentHistory as $value){?>
	    <td><?php echo $value['Total'];?></td>
	    <?php }?>
	    
	</tr>
	<?php } ?>
	
    </tbody>
</table>
<button style="float: right" class="btn btn-group-sm" onclick="window.location.href='ajax.php?r=cheer/ajax&d=sboEnrollmentHistoryDownload&id=<?php echo $_POST['manager']; ?>&eformmonth=<?php echo $monthfrom; ?>&etomonth=<?php echo $monthto; ?>'">Download</button>