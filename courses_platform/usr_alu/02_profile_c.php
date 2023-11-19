var JSON = ModelCall("usr_alu/02_profile","OPC=GET_DATA","JSON")

$("ID").value = JSON[0][0];
$("Name").value = JSON[0][1];
$("Surname").value = JSON[0][2];
$("Rol").value = JSON[0][3];
$("Email").value = JSON[0][5];

$("Profile_enviar").onclick=function()
{

	$("Name").value = $("Name").value.trim();
	$("Surname").value = $("Surname").value.trim();
	if($("Name").value=="" || $("Surname").value=="")
	{
        Message("msg_status", "red", "ERROR, The 'Name' and/or 'Last Name' field cannot be left empty.");
		return false;
	}

    var resp = ModelCall("usr_alu/02_profile", "form_Profile", "JSON");

    if(resp[0])
    {
        Message("msg_status", "green", "The data has been successfully modified.");
    }
    else
    {
        Message("msg_status", "red", resp[1]);
    }
    
    return false; //To prevent submission and page reload
}
