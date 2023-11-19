$("LoadTable_Material").onclick=function()
{

    var JSON = ModelCall("usr_alu/03_material","OPC=GET_MATERIAL","JSON");
	var header = ["", "ID material", "Material", "URL"]; //The first one is empty because in the SQL statement there is a "hidden" ID and a visible ID
    var opc = {"header": [] , "rows": []};

    if(JSON && JSON.length > 0)
        CreateTable(header, JSON, opc, "Full_table"); // THE TABLE IS CREATED BY PASSING THE HEADER AND RECORDS OF THE DATABASE CONTENT.
    else
        $('Full_table').innerHTML="<h4>There is no material available at the moment</h4>";
}

$("LoadTable_Material").onclick();