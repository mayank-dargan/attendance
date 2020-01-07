<?php 
include_once('header.php');	
if(isset($_POST['submit'])){
	if($_POST['sangat_id'] !=''){
		// Update
		$update = "UPDATE `sangat` SET `name`= '".$_POST['name']."', 
		`gender` = '".$_POST['gender']."',
		`age` = '".$_POST['age']."',
		`address` = '".$_POST['address']."',
		`phone` = '".$_POST['phone']."',
		`mobile` = '".$_POST['mobile']."',
		`care_of` = '".$_POST['care_of']."',
		`bhatti_id_no` = '".$_POST['bhatti_id_no']."',
		`nit2_id_no` = '".$_POST['nit2_id_no']."',
		`bhatti_pass_type` = '".$_POST['pass_type']."'
		WHERE sangat_id = '".$_POST['sangat_id']."'";
		
		//echo $update; die;
		$updateRes = $conn->query($update);
		$message = "You have successfully updated the Sangat";
	}else{
		//Save
		$insert = "INSERT INTO `sangat` 
		(
		name,
		gender,
        age,
		address,
		phone,
		mobile,
		care_of,
		bhatti_id_no,
		nit2_id_no,
		bhatti_pass_type
		) 
		VALUES 
		(
		'".$_POST['name']."',
		'".$_POST['gender']."',
		'".$_POST['age']."',
		'".$_POST['address']."',
		'".$_POST['phone']."',
		'".$_POST['mobile']."',
		'".$_POST['care_of']."',
		'".$_POST['bhatti_id_no']."',
		'".$_POST['nit2_id_no']."',
		'".$_POST['pass_type']."'
		)";
		$insertRes = $conn->query($insert);
		$message = "You have successfully added the Sangat";
		
	}
		
} 
// On Page Load;
if(isset($_REQUEST['sangat_id'])){
	$sql = "SELECT * FROM sangat WHERE sangat_id = '".$_REQUEST['sangat_id']."'";
	$result = $conn->query($sql)->fetch_assoc();
	$header = "Update Detail of ".$result['name'];
	$button = "Update";
	$selectedMale='';
    $selectedFemale='';
	if($result['gender'] == 'M'){
	$selectedMale = "selected";
	}else if($result['gender'] == 'F'){
		$selectedFemale = "selected";
	}
	if($result['bhatti_pass_type'] == 'OE-Permanent'){
		$oePermanent = 'selected';
	}elseif($result['bhatti_pass_type'] == 'OE-Temporary'){
		$oeTemporary = 'selected';
	}elseif($result['bhatti_pass_type'] == 'Elderly Sewadar'){
		$elderlySewadar = 'selected';
	}elseif($result['bhatti_pass_type'] == 'Sewadar Badge'){
		$sewadar = 'selected';
	}elseif($result['bhatti_pass_type'] == 'SLIP'){
		$slip = 'selected';
	}
}else{
 $header = "Add Detail";
 $button= "Save";
}
?>
<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
<?php if(isset($message)){ ?>
<div class="alert alert-success"><?php echo $message; ?></div>
<?php } ?>
<div class="panel panel-default">
                        <div class="panel-heading">
                          <?php echo $header;  ?>
                        </div>
                        <div class="panel-body">
<div class="form-group col-sm-4">
<label>Name</label>
<input type ="hidden" name="sangat_id" value="<?php echo isset($result['sangat_id']) ? $result['sangat_id'] : '' ?>">
<input class="form-control" type="text" name="name" value="<?php echo isset($result['name']) ? $result['name'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>Age</label>
<input class="form-control" type="number" name="age" value="<?php echo isset($result['age']) ? $result['age'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>Gender</label>
<select name="gender" class="form-control">
<option value="">Select Gender</option>
<option value="M" <?php echo isset($selectedMale) ? $selectedMale : ''; ?>>Male</option>
<option value="F" <?php echo isset($selectedFemale)? $selectedFemale : '' ; ?> >Female</option>
</select>
</div>
<div class="form-group col-sm-4">
<label>Mobile</label>
<input class="form-control" type="tel" name="phone" value="<?php echo isset($result['phone']) ? $result['phone'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>Alt. Mobile</label>
<input class="form-control" type="tel" name="mobile" value="<?php echo isset($result['mobile']) ? $result['mobile'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>Care Of</label>
<input class="form-control" type="text" name="care_of" value="<?php echo isset($result['care_of']) ? $result['care_of'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>Pass Type</label>
<select name="pass_type" class="form-control">
<option value="">Select Pass Type</option>
<option value="SLIP" <?php echo isset($slip) ? $slip : ''; ?> >SLIP</option>
<option value="Sewadar Badge" <?php echo isset($sewadar) ? $sewadar : ''; ?> >Sewadar</option>
<option value="Elderly Sewadar" <?php echo isset($elderlySewadar) ? $elderlySewadar : '' ; ?> >Elderly Sewadar</option>
<option value="OE-Permanent" <?php echo isset($oePermanent) ? $oePermanent : ''; ?> >Bhatti Permanent</option>
<option value="OE-Temporary" <?php echo isset($oeTemporary) ? $oeTemporary : ''; ?> >Bhatti Temporary</option>
</select>
</div>
<div class="form-group col-sm-4">
<label>Bhatti Pass No.</label>
<input class="form-control" type="text" name="bhatti_id_no" value="<?php echo isset($result['bhatti_id_no']) ? $result['bhatti_id_no'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>NIT Pass No.</label>
<input class="form-control" type="text" name="nit2_id_no" value="<?php echo isset($result['nit2_id_no']) ? $result['nit2_id_no'] : ''; ?>">
</div>
<div class="form-group col-sm-4">
<label>Address</label>
<textarea name="address" class="form-control" colspan="5"><?php echo isset($result['address']) ? $result['address'] : '' ?></textarea>
</div>
<div class="form-group col-sm-12">
<button name="submit" value="submit" type="submit" class="btn btn-primary"><?php echo $button; ?></button>
</div>
</div>
</div>
</form>
