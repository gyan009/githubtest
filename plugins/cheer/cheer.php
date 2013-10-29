<?php $month = (isset($_POST['eformmonth'])) ? $_POST['eformmonth'] : date('Y')."-".date('m'); ?>
<form action="" method="post">
<label>Select month and year:</label>
  <input type="text" name='eformmonth' class="btn btn-default" id="eformmonth" value="<?php echo $month;?>"> 
<label>Select Manager:</label>
<select name='manager' id="manager" class="btn btn-default" style="text-align: left;">
    <option value="">--Select Manager--</option>
    <?php foreach($cheer->GetManager() as $manager){?>
    <option value="<?php echo $manager['id'];?>" <?php if(isset($_POST['manager']) && ($_POST['manager']==$manager['id'])){?> selected="selected" <?php }?>><?php echo $manager['name'];?></option>
    <?php }?>
</select>
<button class="btn btn-primary">Submit</button>
</form>
<div style="height: 40px;"></div>
<div class="alert alert-info">
    <h4 style="text-align: center;">Monthly CHEER Data</h4>
</div>
<table class="table table-hover table-striped table-bordered">
    <thead>
	<tr>
	    <th>SBO Name</th>
	    <th>Week 1</th>
	    <th>Week 2</th>
	    <th>Week 3</th>
	    <th>Week 4</th>
	    <th>Week 5</th>
	</tr>
    </thead>
    <tbody>
<?php $dataSbos = $cheer->CheerData($_POST);
foreach($dataSbos as $dataSbo){?>
	<tr>
	<?php for($i=0;$i<count($dataSbo); $i++){?>
	
	    <td><?php echo $dataSbo[$i];?></td>
	
	<?php } ?>
	 </tr>
<?php } ?>
    </tbody>
</table>
<button style="float: right" class="btn btn-group-sm" onclick="window.location.href='ajax.php?r=cheer/ajax&d=cheerDownload&eformmonth=<?php echo $month; ?>&manager=<?php echo $_POST['manager']; ?>'">Download</button>