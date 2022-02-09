<?php
	$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
	$dbconn = pg_connect($conn_string);
	pg_query($dbconn, 'UPDATE alarm SET pswdtryconnect = '.$_POST['passw']);
	$result = pg_query($dbconn, 'SELECT pswdcorrect FROM alarm');
	if(pg_fetch_result($result,0,0) == 't'){
		
		pg_query($dbconn, 'UPDATE alarm SET alarmactivated = FALSE');
	}
	echo pg_fetch_result($result,0,0);
?>