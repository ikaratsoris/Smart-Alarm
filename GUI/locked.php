<!DOCTYPE html>
<?php
$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1234";
		$dbconn = pg_connect($conn_string);
		$result = pg_query($dbconn, 'SELECT alarmactivated FROM alarm');
		$result2 = pg_query($dbconn, 'SELECT shutdownAlarm FROM alarm');
		if(pg_fetch_result($result2,0,0) == "t"){
			header('Location: offline.php');
		}
		elseif(pg_fetch_result($result,0,0) == "f"){
			header('Location: index.php');
		}
		else{
?>

<html>
    <head>
        <title>Smart Alarm</title>
        <link type="text/css" href="stylesheets/style.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,greek,greek-ext' rel='stylesheet' type='text/css' />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="assets/time.js" ></script>
		
		<script>
		function checkNotif(){
			$.ajax({
				  method:"POST",
				  url:"assets/checknotif.php"
			  })
			  .done(function(msg){
					$("#notif").text(msg);
			  });
		}
		
		$(document).ready(function() {
			startTime();
			
			window.setInterval(checkNotif, 500);
		});
		</script>
		
    </head>
    <body>
	
    <div class="locked_container" onload="startTime()">
        <h1 align="center"> Smart Alarm v1.1 </h1>
        <table width="100%">
			<tr>
                <td id="connected_text" align="center">
                    Connected <img src="images/ConnectedIcon.png" height="15%">
                </td>
                <td align="right">
                    <!--<img src="images/TurnOff.png" height="20%">-->
                </td>
            </tr>
			<tr>
				<td align="center"> 
					<p>Notification: <span id="notif"></span></p>
				</td>
				<td align="center">
					<p id="time"></p> <br>
					<p id="date"></p>
				</td>
			</tr>
			<tr>
				<td align="center">
					<p>Status: Locked</p>
				</td>
			</tr>
			<tr>
				<td align="center">
					<form action="code.htm" method="get">
					<span id="wrongpswd" style="color:#f00"></span><br>
						<input id="code" type="password" name="code" value="" maxlength="4" class="display" readonly="readonly" />
						<table id="keypad" cellpadding="5" cellspacing="3">
							<tr>
								<td onclick="addCode('1');">1</td>
								<td onclick="addCode('2');">2</td>
								<td onclick="addCode('3');">3</td>
							</tr>
							<tr>
								<td onclick="addCode('4');">4</td>
								<td onclick="addCode('5');">5</td>
								<td onclick="addCode('6');">6</td>
							</tr>
							<tr>
								<td onclick="addCode('7');">7</td>
								<td onclick="addCode('8');">8</td>
								<td onclick="addCode('9');">9</td>
							</tr>
							<tr>
								<td onclick="addCode('clc');">Clear</td>
								<td onclick="addCode('0');">0</td>
								<td onclick="addCode('unlock');">Unlock</td>
							</tr>
						</table>
						</form>
				</td>
				<td align="center">
					<img src="images/home.jpg" height="50%">
				</td>
			</tr>
        </table>
    </div>
	<script src="assets/keypad.js" ></script>
    </body>
</html>
<?php } ?>