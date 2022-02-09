<?php
	$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
	$dbconn = pg_connect($conn_string);
	$result = pg_query($dbconn, 'UPDATE alarm SET alarmactivated = TRUE');
?>