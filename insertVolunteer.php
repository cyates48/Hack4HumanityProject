<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // collect input data
	
     $orgName = $_POST['orgName']; 
     $jobTitle = $_POST['jobTitle']; 
	 $startTime = $_POST['startTime'];
	 $street = $_POST['street'];
	 $city = $_POST['city'];
	 $state = $_POST['state'];
	 $startDate = $_POST['startDate'];
	 $expectedDuration = $_POST['expectedDuration'];
	 $jobDescription = $_POST['jobDescription'];
	 $contactNo = $_POST['contactNo'];
	
	insertVolunteerPostIntoDB($orgName,$jobTitle,$startTime,$street,$city,$state,$startDate,$expectedDuration,$jobDescription,$contactNo);
	
}

function insertVolunteerPostIntoDB($orgName,$jobTitle,$startTime,$street,$city,$state,$startDate,$expectedDuration,$jobDescription,$contactNo){
	
	//connect to your database. Type in your username, password and the DB path
	$conn=oci_connect('ireyhano','coenlabs', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";       
        exit;
	}

	$query = oci_parse($conn, "Insert Into Volunteering(orgName, jobTitle, jobDescription, startTime, street, city, state, startDate, expectedDuration, contactNo) values(:orgName, :jobTitle, :jobDescription, :startTime, :street, :city, :state, :startDate, :expectedDuration, :contactNo)");	
	
	oci_bind_by_name($query, ':orgName', $orgName);
	oci_bind_by_name($query, ':jobTitle', $jobTitle);
	oci_bind_by_name($query, ':jobDescription', $jobDescription);
	oci_bind_by_name($query, ':startTime', $startTime);
	oci_bind_by_name($query, ':street', $street);
	oci_bind_by_name($query, ':city', $city);
	oci_bind_by_name($query, ':state', $state);
	oci_bind_by_name($query, ':startDate', $startDate);
	oci_bind_by_name($query, ':expectedDuration', $expectedDuration);
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

