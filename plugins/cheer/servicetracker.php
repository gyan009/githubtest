<?php 
$monthfrom = (isset($_POST['eformmonth'])) ? $_POST['eformmonth'] : date('Y')."-".(date('m')-3); 
$monthto = (isset($_POST['etomonth'])) ? $_POST['etomonth'] : date('Y')."-".date('m'); 
$serviceTrackerData = $cheer->serviceTracker($monthfrom, $monthto);
?>
<form action="" method="post">
    <label>Select month and year:</label>
     <input type="text" name='eformmonth' class="btn btn-default" id="eformmonth" value="<?php echo $monthfrom;?>"> 

--  <input type="text" name='etomonth' class="btn btn-default" id="etomonth" value="<?php echo $monthto;?>">
<button class="btn btn-primary">Submit</button>
</form>
<div style="height: 40px;"></div>
<div class="alert alert-info">
    <h4 style="text-align: center;">All India Patients Service history</h4>
</div>
<table class="table table-hover table-striped table-bordered">
    <thead>
	<tr>
	    <th>Month</th>
	    <th>No. of Active Patients</th>
	    <th colspan="4" style="text-align: center;">Existing Patient Status</th>
	    <th colspan="4" style="text-align: center;">New Patient Status</th>
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
<?php $total = "";
	foreach($serviceTrackerData as $key=>$serviceTracker){  ?>
	<tr>
	    <td><?php echo $key;?></td>
	    <?php foreach($serviceTracker as $value){?>
	    <td><?php echo $value['Total'];?></td>
	    <?php }?>
	    
	</tr>
<?php } ?>
	
    </tbody>
</table>
<button style="float: right" class="btn btn-group-sm" onclick="window.location.href='ajax.php?r=cheer/ajax&d=serviceTrackerDownload&monthform=<?php echo $monthfrom; ?>&monthto=<?php echo $monthto; ?>'">Download</button>