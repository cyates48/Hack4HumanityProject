<!-- This PHP script fetches the data from the Volunteering table. -->

<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// collect input data
		
		$orgName = $_POST['orgName'];

		getOrgInformation($orgName);
	}
	
	function getOrgInformation($orgName) {
		// connect to database
		$conn=oci_connect('ireyhano','coenlabs', '//dbserver.engr.scu.edu/db11g');
		if ($conn === false) {
			print "<br> connection failed:";
			exit;
		}
		
		// creates the query
		$query = oci_parse($conn, "SELECT volunteeringTitle, description, blockNumber, street, city, state, startDate, expectedTime, contactNo FROM Volunteering WHERE orgName = :orgName");
		oci_bind_by_name($query, ':orgName', $orgName);
		
		// executes the query
		oci_execute($query);
		
		// displays the names
		while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
			// TODO: change these to adhere to the proper UI
			echo "<br>";
			echo "<font color='green'> 'Volunteering Title: ' . $row[0] </font></br>";
			echo "<font color='green'> 'Description: ' . $row[1] </font></br>";
			echo "<font color='green'> 'Block Number: ' . $row[2] </font></br>";
			echo "<font color='green'> 'Street: ' . $row[3] </font></br>";
			echo "<font color='green'> 'City: ' . $row[4] </font></br>";
			echo "<font color='green'> 'State: ' . $row[5] </font></br>";
			echo "<font color='green'> 'Start Date: ' . $row[6] </font></br>";
			echo "<font color='green'> 'Expected Time: ' . $row[7] </font></br>";
			echo "<font color='green'> 'Contact Number: ' . $row[8] </font></br>";
		}
		echo "<br>";
		
		// closes the connection
		OCILogoff($conn);
	}
?>
