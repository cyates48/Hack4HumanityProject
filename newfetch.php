<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Volunteer Opportunities</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="hack_postjob.css"/>
</head>

<body>

	<nav class="navbar navbar-custom navbar-inverse fixed-top bg-inverse">
         <div class="container">
               <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">Home</a>
               </div>
          </div>
     </nav>

     <div class="container">
     <div class="row bottom img-rounded">
          <div class="col-md-5">
               <div id="job-section" class="img-rounded">
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
							$query = oci_parse($conn, "SELECT jobTitle, jobDescription, startTime, street, city, state, startDate, expectedDuration, contactNo FROM Volunteering WHERE upper(orgName) = upper(:orgName)");
							oci_bind_by_name($query, ':orgName', $orgName);
							
							// executes the query
							oci_execute($query);
							
							// displays the names
							while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
								// TODO: change these to adhere to the proper UI
								echo "<style> 
									p{color:green;}
								</style>";
								echo "<div class='volunteer-opp'>";
									echo "<div class = 'primary-section'>";
										echo "<p>What: $row[0]</p>";
									echo "</div";
									echo "<div class = 'organization-info'>";
										echo "<p style='display: inline'>Who: $orgName</p>";
										echo "<p>\t(Contact Number: $row[8])</p>";
									echo "</div";
									echo "<div class = 'location'>";
										echo "<p>Where: $row[3] $row[4], $row[5]<p>";
									echo "</div";
									echo "<div class = 'logistics'>";
										echo "<p>When: $row[6] at $row[2] for $row[7]<p>";
									echo "</div";
									echo "<div class = 'details'>";
										echo "<p>Description: $row[1]</p>";
									echo "</div";
								echo "</div>";
								echo "<p>---------------------------------------------------</p>";
							}
							echo "<br>";
							
							// closes the connection
							OCILogoff($conn);
						}

					?>
               </div>
	        </div>
	    <div class="col-md-7" id="map-size">
	        <div id="map"></div>
	        </div>
	    </div>
	</div>
</body>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYV3BJ1MR1wJrC9ABT69oi0qWcy04vkuw&callback=initMap"> </script>
<script>

     function initMap(){
          var uluru = {lat: -28, lng: 0};
          var map = new google.maps.Map(document.getElementById("map"), {zoom: 4, center: uluru });
          var marker = new google.maps.Marker({ position: uluru, map: map });
     }
</script>

</html>

