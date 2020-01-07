<?php
include_once('database-connection.php'); 
 $params = $_REQUEST;
 $searchParams = $params['search']['value'];
 $sql = "SELECT * FROM `sangat`";
 
 if($searchParams!=''){
	 $sql .= "WHERE `name` LIKE '%". $searchParams."%' 
	 OR bhatti_id_no = '".$searchParams."'
	 OR nit2_id_no = '".$searchParams."'
	 ";
 }
 $sql .= " ORDER BY `name` LIMIT ".$params['start']." ,".$params['length']."";
	
 $result = $conn->query($sql);
 
 $data = array();
 while($row = $result->fetch_assoc()){
	 $data[] = $row;
 }
 
 // totalRecords
 $sql = "SELECT COUNT(*) as 'totalRecords' from sangat"; 
 $result = $conn->query($sql);
 while($row = $result->fetch_assoc()){
	 $totalRecords = $row['totalRecords'];
 }
 
 $filteredRecords = $totalRecords;
 // filtered Records
 if($searchParams!=''){
 $sql = "SELECT COUNT(*) as 'filteredRecords' FROM `sangat`
		WHERE `name` LIKE '%". $searchParams."%' 
	   OR bhatti_id_no = '".$searchParams."'
	   OR nit2_id_no = '".$searchParams."'
	   ORDER BY `name`";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()){
	 $filteredRecords = $row['filteredRecords'];
 }
 }
 
	$json_data = array(
		"draw"            => intval( $params['draw'] ),   
		"recordsTotal"    => $totalRecords,  
		"recordsFiltered" => $filteredRecords,
		"data"            => $data   // total data array
		);
		
	echo json_encode($json_data);

	
//$conn->close();