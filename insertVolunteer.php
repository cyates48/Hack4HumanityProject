<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // collect input data
	
     $orgName = $_POST['orgName']; 
	 
     $volunteeringTitle = $_POST['volunteeringTitle']; 
	 
	 $blockNumber = $_POST['blockNumber'];

	 $streetName = $_POST['streetName'];
	 $city = $_POST['city'];
	 $state = $_POST['state'];
	 $startDate = $_POST['startDate'];
	 $expectedTime = $_POST['expectedTime'];
	 $description = $_POST['description'];
	 $contactNo = $_POST['contactNo'];
	
	insertVolunteerIntoDB($orgName,$volunteeringTitle,$blockNumber,$streetName,$city,$state,$startDate,$expectedTime,$description,$contactNo);
	
}

function insertVolunteerIntoDB($orgName,$volunteeringTitle,$blockNumber,$street,$city,$state,$startDate,$expectedTime,$description,$contactNo){
	//connect to your database. Type in your username, password and the DB path
	$conn=oci_connect('ireyhano','coenlabs', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";       
        exit;
	}

	$position = rand(0, 99999);

	$query = oci_parse($conn, "Insert Into Volunteering(position, orgName, volunteeringTitle, description, blockNumber, street, city, state, startDate, expectedTime, contactNo) values(:position, :orgName, :volunteeringTitle, :description, :blockNumber, :street, :city, :state, :startDate, :expectedTime, :contactNo)");	
	
	oci_bind_by_name($query, ':position', $position);
	oci_bind_by_name($query, ':orgName', $orgName);
	oci_bind_by_name($query, ':volunteeringTitle', $volunteeringTitle);
	oci_bind_by_name($query, ':description', $description);
	oci_bind_by_name($query, ':blockNumber', $blockNumber);
	oci_bind_by_name($query, ':street', $street);
	oci_bind_by_name($query, ':city', $city);
	oci_bind_by_name($query, ':state', $state);
	oci_bind_by_name($query, ':startDate', $startDate);
	oci_bind_by_name($query, ':expectedTime', $expectedTime);
	oci_bind_by_name($query, ':contactNo', $contactNo);
	
	// Execute the query
	$res = oci_execute($query);
	if ($res)
		// TODO: change this display a success message (if at all)
		echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
	else{
		$e = oci_error($query); 
        	echo $e['message']; 
	}
	OCILogoff($conn);	
}

?>

