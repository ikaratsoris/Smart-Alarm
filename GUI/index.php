<!DOCTYPE html>
<?php
$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
		$dbconn = pg_connect($conn_string);
		$result = pg_query($dbconn, 'SELECT alarmactivated FROM alarm');
		$result2 = pg_query($dbconn, 'SELECT shutdownAlarm FROM alarm');
		if(pg_fetch_result($result2,0,0) == "t"){
			header('Location: offline.php');
		}
		elseif(pg_fetch_result($result,0,0) == "t"){
			header('Location: locked.php');
		}
		else{
			for($x=0;$x<=100; $x++){
				
			}
			pg_query($dbconn, 'UPDATE alarm SET alarmalert = FALSE');
			pg_query($dbconn, 'UPDATE alarm SET pswdtryconnect = 0');
?>

<html>
  <head>
    <title>Smart Alarm</title>
    <link type="text/css" href="stylesheets\style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,greek,greek-ext' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="assets/time.js" ></script>
    <script>
      $(document).ready(function() {
          $("#locked-img").click(function () {
              $.ajax({
				  method:"POST",
				  url:"assets/lock.php"
			  })
			  .done(function(msg){
				  window.location = "locked.php";
			  });
          });
      });
	  $(document).ready(function() {
		  $("#shut_down-img").click(function () {
              $.ajax({
				  method:"POST",
				  url:"assets/shutdown.php"
			  })
			  .done(function(msg){
				  window.location = "offline.php";
			  });
          });
	  });
      </script>
  </head>
  <body onload="startTime()">
  <div class="unlocked_container">
    <h1 align="center"> Smart Alarm v1.1 </h1>
    <table width="100%">
      <tr>
        <td id="connected_text" align="left">
          Connected <img src="images/ConnectedIcon.png" height="15%">
        </td>
        <td align="right">
          <a><img id="shut_down-img" src="images/TurnOff.png" height="20%"></a>
        </td>
      </tr>
    </table>
    <div align="center">
      <a ><img id="locked-img" src="images/LockedIcon.png"/></a>
    </div>
    <div id="status">
      <table width="100%">
        <tr>
          <td>
            <p>Status: Unlocked</p>
          </td>
          <td align="right">
            <p id="time"></p> <br>
            <p id="date"></p>
          </td>
        </tr>
      </table>
    </div>
  </div>
  
  </body>
</html>
<?php
	pg_query($dbconn, 'UPDATE alarm SET pswdcorrect = FALSE');
} ?>