<?php
		$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
		$dbconn = pg_connect($conn_string);
        $result = pg_query($dbconn, 'SELECT alarmalert FROM alarm');
		$arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		if($arr['alarmalert'] == "f"){
			   echo "All Good";
		   }
		else{
		$dataret = "";
		foreach($arr as $key => $value){
			if($value == "t"){
				$dataret = "Alarm Triggered!";
			}
		}
		echo $dataret;
		}
?>