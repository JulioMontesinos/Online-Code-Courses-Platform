$("Registration_send").onclick=function()
{
	$("Name_R").value = $("Name_R").value.trim();
	$("Surname_R").value = $("Surname_R").value.trim();
	$("Email_R").value = $("Email_R").value.trim();
	$("Pass_R").value = $("Pass_R").value.trim();
	$("Pass_R2").value = $("Pass_R2").value.trim();

	if($("Name_R").value=="" || $("Surname_R").value=="" || $("Email_R")=="" || $("Pass_R").value=="" || $("Pass_R2").value=="")
	{
		Message("msg_Registration", "red", "Error, all fields must be filled");
		return false; // To prevent submission and page reload
	}

	if(!ValidateEmail($("Email_R").value))
	{
		Message("msg_Registration", "red", "Error, incorrect email");
		return false; // To prevent submission and page reload
	}

	var resp = ModelCall("02_registration", "form_Registration", "JSON");
	
	if(resp[0])
	{
		Message("msg_Registration", "green", "Registration successfully completed");

		$("form_Registration").reset();
		setTimeout("$('navEnter').onclick()", 4500);
	}
	else
	{
		Message("msg_Registration", "red", resp[1]);		
	}
	return false; // To prevent submission and page reload
}