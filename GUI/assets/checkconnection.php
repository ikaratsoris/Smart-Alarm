<?php
	$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
	$dbconn = pg_connect($conn_string);
	$result = pg_query($dbconn, 'SELECT shutdownAlarm FROM alarm');
	
	if(pg_fetch_result($result,0,0) == "f"){
		echo "index.php";
	}
	else
	{
		echo "offline.php";
	}
?>