<?php 
include_once('header.php');

$CURRENT_YEAR = date('Y');
$CURRENT_MONTH = date('F');
$CURRENT_DAY = date('d');

$ATTENDANCE_TABLE = 'attendance_2019';
$ATTENDANCE_COLUMN = $CURRENT_DAY.'_'.$CURRENT_MONTH.'_'.$CURRENT_YEAR;
//$ATTENDANCE_COLUMN = '21_April_2019';

$condition = '';
$presentArray = array();
foreach($last4Sundays as $key=>$val){
$present =  "SELECT COUNT(*) AS `$val` FROM `attendance_2019` att
 INNER JOIN sangat s ON (att.`sangat_id` = s.`sangat_id`) WHERE s.gender = 'M' AND $key = '1'";
 
 $result = $conn->query($present)->fetch_assoc();
 $presentArray[$val] = $result[$val];
}
foreach($last4Sundays as $key=>$val){
	$condition.= 'a.'.$key.' as `'.$val.'`,';
}
	$condition = rtrim($condition,',');
	
			$sql = "SELECT s.`name` as `Name`,
			bhatti_id_no as `Bhatti Pass No.`,
			nit2_id_no as `NIT 2 Pass No.`,
			".$condition."
			FROM `$ATTENDANCE_TABLE` a 
			INNER JOIN sangat s ON (a.`sangat_id` = s.`sangat_id`)
			WHERE s.gender = 'M'
			ORDER BY s.`name`
			";
 //echo $sql; die;
		$result = $conn->query($sql);
		$data = array();
		$columnNames = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){
				$data[] = $row;
			}
			$columnNames = array_keys($data[0]);
		} ?>
		<?php 
		$excludeIndexes = ['Name','Bhatti Pass No.','NIT 2 Pass No.'];
		?>
							<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
							<div class="pull-right">
							<input type="date" name="sdate">
							<button class="btn btn-success" type="submit">Submit</button>
							</div>
							</form>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            View Attendance - Male
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="examplessss">
                                    <thead>
                                        <tr>
                                            <?php foreach($columnNames as $col){ 
											if(isset($presentArray[$col])){
												$col = $col.' ('.$presentArray[$col].')';
											}
											?>	
											<th><?php echo $col; ?></th>
										<?php } ?>
                                        </tr>
                                    </thead>
									<tbody>
									<?php
									foreach ($data as $key => $val){ ?>
									<tr>
										<?php foreach($val as $index => $value){
											$class = '';
										if(!in_array($index,$excludeIndexes)){
											if($value == '1'){
												$value = '';
												$class = 'fa fa-check alert-success';
											}elseif($value == '0'){
												$value = '';
												$class = 'fa fa-times alert-danger';
										} }?>
											<td><div class="<?php echo $class; ?>"></div><?php echo $value; ?></td>
										<?php }
									?>
										</tr>
									<?php } ?>
									</tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                            
	<?php  include_once('footer.php'); ?>
    