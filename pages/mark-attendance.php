<?php 
include_once('header.php');

$CURRENT_YEAR = date('Y');
$CURRENT_MONTH = date('F');
$CURRENT_DAY = date('d');

$ATTENDANCE_TABLE = 'attendance_2019';
$ATTENDANCE_COLUMN = $CURRENT_DAY.'_'.$CURRENT_MONTH.'_'.$CURRENT_YEAR;
//$ATTENDANCE_COLUMN = '28_April_2019';

$withoutPassCount = '';
if(isset($_POST) && !empty($_POST) && isset($_POST['no_pass_name']) && ($_POST['no_pass_name']!='') && isset($_POST['gender'])){
	$name = $_POST['no_pass_name'];
	$gender = $_POST['gender'];
	$date = date('Y-m-d');

	$sql = "INSERT INTO `without_pass_sangat` (sangat_name,gender,date) VALUES 
	(
	'".$name."',
	'".$gender."',
	'".$date."'
	)";
	$result = $conn->query($sql);
	
	$sql = "SELECT COUNT(*) as no_pass FROM 
	`without_pass_sangat` WHERE gender = '".$gender."' GROUP BY '".$date."'";
	$result = $conn->query($sql)->fetch_assoc();
	$withoutPassCount = $result['no_pass'];
	
}
if(isset($_POST) && !empty($_POST) && isset($_POST['id_no']) && isset($_POST['gender'])){
	$gender = $_POST['gender'];
	$idNo = trim($_POST['id_no']);
	$passType = $_POST['pass_type'];
	
	$prefix = '';
	if($passType == 'sewadar' && $gender == 'M'){
		$prefix = 'BH0011GA';
	}elseif($passType == 'sewadar' && $gender == 'F'){
		$prefix = 'BH0011LA';
	}else if ($passType == 'oe_temp'){
		$prefix = 'T-';
	}else if ($passType == 'SLIP'){
		$prefix = 'S';
	}
	
	
	$sql = "SELECT * FROM `sangat` WHERE bhatti_id_no = '". $prefix.$idNo. "' OR (nit2_id_no = '". $prefix.$idNo."' 
				AND `gender` = '".$gender."')";
	
	//echo $sql;
	$result = $conn->query($sql);
	//print_r($result); 

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$sangatId = $row['sangat_id'];
        $name = $row['name'];
		$phone = $row['phone'].' , '.$row['mobile'];
		$address = $row['address'];
		$bhattiIdNo = ($row['bhatti_id_no']!='') ? $row['bhatti_id_no'].'('.$row['bhatti_pass_type'].')' : '';
		if($gender == 'M'){
		$nit2IdNo = ($row['nit2_id_no']!='') ? 'G-'.$row['nit2_id_no'] : '';
		}else{
		$nit2IdNo = ($row['nit2_id_no']!='') ? 'L-'.$row['nit2_id_no'] : '';	
		}
		//Update gender
		if($row['gender'] == ''){
			$sqlUpdateGender = "UPDATE `sangat` SET gender = '".$gender."' WHERE `sangat_id` = '".$sangatId."'"; 
			$conn->query($sqlUpdateGender);
		}
		//Mark attendance from backend for current date.
		$sangatExist = "SELECT `sangat_id` from `$ATTENDANCE_TABLE` WHERE `sangat_id` ='" .$sangatId. "'";
		$sangatExistResult = $conn->query($sangatExist);
		
		if($sangatExistResult->num_rows > 0){
			//Update
			$sql2 = "UPDATE `$ATTENDANCE_TABLE` SET `$ATTENDANCE_COLUMN` = '1'
			WHERE `sangat_id` = '".$sangatId."'";
		$result2 = $conn->query($sql2);
			
		}else{
			//Insert
			$sql2 = "INSERT INTO `$ATTENDANCE_TABLE` (`sangat_id`,`$ATTENDANCE_COLUMN`) VALUES ('".$sangatId."' , '1')";
		$result2 = $conn->query($sql2);
		
			//Update active status
		$sqlUpdateActive = "UPDATE `sangat` SET is_active = '1' WHERE `sangat_id` = '".$sangatId."'";
		$conn->query($sqlUpdateActive);
		}
		
		//echo $sql2; 
    }
} 
$conn->close();
	
}
	
?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Attendance - <?php echo date('d F Y') ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <form autocomplete="off" role="form" method="post" action="<?php $_SERVER['PHP_SELF']?>">
									<div class="form-group">
                                            <label>Gender</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="male" value="M" 
												<?php if(isset($_POST['gender']) && $_POST['gender'] == 'M') { ?>
													checked
												<?php }?>
												>Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="female" value="F"
												<?php if(isset($_POST['gender']) && $_POST['gender'] == 'F') { ?>
													checked
												<?php }?>
												>Female
                                            </label>
                                        </div>
										<label>Enter Pass No.</label>
										<div class="form-group input-group">
                                            <span class="input-group-addon">
											<select id="pass_type" name='pass_type' onchange="getPassType()">
											<option value='pass'>Pass No.</option>
											<option value='sewadar'>Sewadar Badge</option>
											<option value='oe_temp'>OE Temporary</option>
											<option value='SLIP'>SLIP</option>
											<option value='no_pass'>Without Pass</option>
											</select>
											</span>
											<div id="pass_div">
                                            <input id="pass" type="tel" autocomplete="off" name= "id_no" class="form-control" placeholder="Enter Pass No.">
											</div>
											<div id="no_pass_name_div">
											<input id="no_pass" type="text" autocomplete="off" name= "no_pass_name" class="form-control" placeholder="Enter Name">
											</div>
                                        </div>
										<div class="row col-sm-6">
                                        <button type="submit" class="btn btn-default">Submit</button>
										</div>
                                        </div>
										</br>
										<?php  if(!empty($_POST) && isset($_POST['id_no']) && $_POST['id_no']!='' && isset($_POST['gender']) && !empty($result->num_rows>0)){ ?>
										<div class="col-sm-8">
										<center>
										<div class="row">
										<div class="alert alert-success"> Attendance Marked.</div>
										</div>
										</center>
										
										<div class ="col-sm-6">
										<div class="form-group">
                                            <label>Name : </label> <?php echo $name; ?>
                                        </div>
										<div class="form-group">
                                            <label>Phone : </label> <?php echo $phone; ?>
                                        </div>
										<div class="form-group">
                                            <label>Address : </label> <?php echo $address; ?>
                                        </div>
										</div>
										<div class="col-sm-6">
										<div class="form-group">
                                            <label>Bhatti Pass No :</label> <?php echo $bhattiIdNo; ?>
                                        </div>
										<div class="form-group">
                                            <label>NIT 2 Pass No :</label> <?php echo $nit2IdNo; ?>
                                        </div>
										<!-- <div class="form-group">
                                            <label>Sangat Id:</label> <?php //echo $sangatId; ?>
                                        </div> -->
										</div>
										</div>
										<?php } else if(!empty($_POST) && isset($_POST['id_no']) && $_POST['id_no']!='' && isset($_POST['gender']) && !empty($result->num_rows == 0)){ ?>
										<div class="col-sm-8">
										<center>
										<div class="row">
										<div class="alert alert-danger">Cannot mark attendance. Write following detail in paper</div>
										</div>
										</center>
										<div class ="col-sm-4">
										<div class="form-group">
                                            <label>Name</label>
                                        </div>
										<div class="form-group">
                                            <label>Mobile</label>
                                        </div>
										<div class="form-group">
                                            <label>Bhatti Pass No.</label>
                                        </div>
										</div>
										<div class="col-sm-4">
										<div class="form-group">
                                            <label>Age/Gender</label>
                                        </div>
										<div class="form-group">
                                            <label>Alternate Mobile</label>
                                        </div>
										<div class="form-group">
                                            <label>NIT 2 Pass No.</label>
                                        </div>
										</div>
										<div class="col-sm-4">
										<div class="form-group">
                                            <label>Address</label>
                                        </div>
										<div class="form-group">
                                            <label>Care of</label>
                                        </div>
										</div>
										
										</div>	
										<?php }else if($withoutPassCount!=''){ ?>
											<div class="col-sm-8">
										<center>
										<div class="row">
											<div class="alert alert-warning">Without Pass Sangat : <?php echo $withoutPassCount; ?></div>
											</div>
											</center>
											</div>
										<?php } ?>
                                   </div>
                                        <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
                                    </form>
                                </div>
                            </div>
                            
		<?php  include_once('footer.php'); ?>
		<script>
		$('#no_pass_name_div').hide();
			function getPassType(){
				var passType = $('#pass_type').val();
				if(passType == 'no_pass'){
					$('#no_pass_name_div').show();
					$('#pass_div').hide();
				}else{
					$('#no_pass_name_div').hide();
					$('#pass_div').show();
				}
			}
		
		</script>
    