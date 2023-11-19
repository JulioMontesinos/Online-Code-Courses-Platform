var JSON = ModelCall("usr_prof/01_teaching","OPC=GET_DESCRIPTION","JSON")

$("info_textArea").value = JSON[0][5];

$("button_edit_info").onclick=function()
{
    if($("info_textArea").readOnly == true)
    {
        $("button_edit_info").innerHTML = "Save";
        $("info_textArea").readOnly = false;
        $("info_textArea").style.backgroundColor =" #ffffff";
    }
    else
    {
        if($("button_edit_info").innerHTML == "Save")
        {
            // We save the description entered by the teacher.
            ModelCall("usr_prof/01_teaching","OPC=SAVE_DESCRIPTION&info_textArea="+$("info_textArea").value,"JSON") 
        }
        
        $("button_edit_info").innerHTML = "Edit";
        $("info_textArea").readOnly = true;
        $("info_textArea").style.backgroundColor =" #f7f7f7";
    }   
}