$("login_send").onclick=function()
{
	var resp = ModelCall("01_login", "login_form", "JSON");

	if(resp[0]== 1)
	{
		// In case the data is correct
		SessionIn();
	}
	else
	{
		Message("msg_login", "red", "Identification error");
	}
	return false; //To prevent submission and page reload.
}

$("usrID").focus();