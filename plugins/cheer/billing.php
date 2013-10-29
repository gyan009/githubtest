<?php 
$monthfrom = (isset($_POST['eformmonth'])) ? $_POST['eformmonth'] : date('Y')."-".(date('m')-3); 
$monthto = (isset($_POST['etomonth'])) ? $_POST['etomonth'] : date('Y')."-".date('m');  
$billData = $cheer->BillDataContacted($monthfrom, $monthto);
?>
<div class="page-header">
   <h3>Billing Report</h3>
</div>
<form action="" method="post">
<label>Select month and year:</label>
 <input type="text" name='eformmonth' class="btn btn-default" id="eformmonth" value="<?php echo $monthfrom;?>"> 

--  <input type="text" name='etomonth' class="btn btn-default" id="etomonth" value="<?php echo $monthto;?>">
<button class="btn btn-primary">Submit</button>
</form>
<div style="height: 40px;"></div>
<table class="table table-hover table-striped table-bordered">
    <thead>
	<tr>
	    <th>Month</th>
	    <th>Activated</th>
	    <th>Total active users</th>
	    <th>Declined</th>
	</tr>
    </thead>
    <tbody>
	<?php $total = "";
	foreach($billData as $key=>$billDatas){  ?>
	<tr>
	    <td><?php echo $key;?></td>
	    <?php foreach($billDatas as $value){?>
	    <td><?php echo $value['Total'];?></td>
	    <?php }?>
	    
	</tr>
<?php } ?>
    </tbody>
</table>
<button style="float: right" class="btn btn-group-sm" onclick="window.location.href='ajax.php?r=cheer/ajax&d=billingDownload&monthform=<?php echo $monthfrom; ?>&monthto=<?php echo $monthto; ?>'">Download</button>