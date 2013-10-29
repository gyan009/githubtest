<?php $month = date('m');
$dataSbo = $cheer->CheerData($_POST);
if(isset($_POST['sbo'])){
    $sboName = $cheer->getSboListName($_POST['sbo']);
}
$sboDataList = $cheer->sbo($_POST['sbo']);
?>
<form action="" method="post">	
<label>Select Manager:</label>
<select name='manager' id="manager" class="btn btn-default" style="text-align: left;">
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
    <h4 style="text-align: center;">Patients <?php if($_POST['manager']) { echo 'Enrollment by "'.$sboName['name'].'"'; } else { echo " "; }?> on <?php echo date('F'); ?>- <?php echo date('Y'); ?></h4>
</div>

<table class="table table-hover table-striped table-bordered">
    <thead>
	<tr>
	    <th>&nbsp;</th>
	    <th>Week 1</th>
	    <th>Week 2</th>
	    <th>Week 3</th>
	    <th>Week 4</th>
	    <th>Week 5</th>
	</tr>
    </thead>
    <tbody>
	
	<?php $total = "";
	//echo "<pre>";
	//print_r($enrollmentHistoryData);
	foreach($sboDataList as $key=>$sboData){  ?>
	<tr>
	    <td><?php echo $key;?></td>
	    <?php foreach($sboData as $value){?>
	    <td><?php echo $value['Total'];?></td>
	    <?php }?>
	    
	</tr>
	<?php } ?>
	
    </tbody>
</table>
<div class="row"></div>
      
    