function addCode(key){
	var code = document.forms[0].code;
	if(code.value.length < 4){
		code.value = code.value + key;
	}
	
	if(key == 'clc'){
		code.value = "";
	}
	
	if(key == 'unlock'){
		$.ajax({
				  method:"POST",
				  url:"assets/unlock.php",
				  data : {
					passw : code.value
				}
			  })
			  .done(function(msg){
				  if(msg == "t"){
					window.location = "index.php";
				  }
				  else{
					  $("#wrongpswd").text("Wrong Password");
					  code.value = "";
				  }
			  });
	}
}

function submitForm(){
	document.forms[0].submit();
}

function emptyCode(){
	document.forms[0].code.value = "";
}