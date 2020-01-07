<?php 
include_once('header.php');

$sql= "SELECT COUNT(*) AS counting , gender , `date` FROM without_pass_sangat GROUP BY `date` ,gender ";
$result = $conn->query($sql);

?>
		
					<div class="panel panel-default">
                        <div class="panel-heading">
                           Attendance Summary
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="examplessss">
                                    <thead>
                                        <tr>
										<td>Date (yyyy-mm-dd)</td>
										<td>Gender</td>
										<td>Without Pass</td>
                                        </tr>
                                    </thead>
									<tbody>
									<?php while($row = $result->fetch_assoc()) { ?>
									<tr>
										<td><?php echo $row['date'] ;?></td>
										<td><?php echo $row['gender'] ;?></td>
										<td><?php echo $row['counting'] ;?></td>
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
    