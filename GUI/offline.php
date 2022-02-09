<!DOCTYPE html>

<?php
	$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
	$dbconn = pg_connect($conn_string);
	$result = pg_query($dbconn, 'SELECT shutdownAlarm FROM alarm');
	if(pg_fetch_result($result,0,0) == "f"){
		header('Location: index.php');
	}
	else{
?>

<html>
<head>
	<title>Smart Alarm</title>
    <link type="text/css" href="stylesheets\style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,greek,greek-ext' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	
	<script>
		function checkCon(){
			$.ajax({
				  method:"POST",
				  url:"assets/checkconnection.php"
			  })
			  
			.done(function(msg){
				if (msg=="index.php"){
					window.location = msg;
				}
			})
		}
		
		$(document).ready(function() {
			setInterval(checkCon, 500);
		});
	</script>
	
</head>

<body>
	<div class="offline_container">
		<h1 align="center"> Smart Alarm v1.1 </h1>
		<h2 id="offline" align="center"> System Offline </h2>
	</div>
</body>

</html>
<?php } ?>