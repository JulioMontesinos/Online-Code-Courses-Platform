var JSON = ModelCall("usr_alu/01_info","OPC=GET_DESCRIPTION","JSON")

$("info_textArea_stu").value = JSON[0][5];