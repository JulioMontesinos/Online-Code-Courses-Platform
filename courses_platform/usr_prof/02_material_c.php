$("Initialize").onclick=function()
{
	$("LoadTable_Material").onclick();
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}

$("LoadTable_Material").onclick=function()
{
   
    var JSON = ModelCall("usr_prof/02_material","OPC=GET_MATERIAL","JSON");
	var header = ["", "ID material", "Material", "URL"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID
    
    var opc = {
        "header": [ 
                    ["➕", add_material] /*add_material is a function*/ ] ,

        "rows": [
                    ["✏️", edit_material],

                    ["❌", delete_material] /*edit_material and delete_material are functions*/
                ]
    };
    
    CreateTable(header, JSON, opc, "Full_table");
    
    if(JSON.length == 0)
        $("message_table_material").innerHTML+="<h4>No material created<br/>Press the button [➕] to create a new material</h4>";

}

/****************************************************************************************************************/
/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////

let add_material = function()
{
    $("form_Material").reset();
    OpenModal(1,300);

    
    $("my_h2").innerHTML = "Add material";
    $("my_h2").style.color = " #5f5f5f";

    $("material_send").innerHTML = "Add";
    
    $("material_send").onclick=function()
    {
        //We check that the form fields are not empty

        $("material_text").value=$("material_text").value.trim();
        $("material_url").value=$("material_url").value.trim();
            
        if(($("material_text").value=="") || $("material_url").value=="")
        {
            Message("msg_status", "red", "ERROR, some field is empty. No changes have been made.");
            return false;
        }

        $("OPC").value="NEW_MATERIAL";
        
        var resp = ModelCall("usr_prof/02_material", "form_Material", "JSON");

        if(resp[0])
        {
            //TO UPDATE THE TABLE OF TEACHERS RECORDS
            GetModule('usr_prof/02_material', 'contentCourse');
            
            $("form_Material").reset(); // To reset the content of the modal window form
            CloseModal(1); //To close the modal window
        }
        else
        {
            Message("msg_status", "red", "An error occurred, no material has been created");
        }
        return false; // To prevent submission and page reload
    }
}

let delete_material = function()
{
    //We get the name of the task
    var data_material = ModelCall("usr_prof/02_material","OPC=GET_MATERIAL_SPECIFIC&Id_Content="+this.dataset.id,"JSON");

    var confirmation = Confirm("ID material: "+data_material[0][0],"delete");

    if(confirmation)
    {   // In case the user confirms, the task will be deleted.

        ModelCall("usr_prof/02_material","OPC=DELETE_MATERIAL&Id_Content="+this.dataset.id,"TEXT");
        //NOW WE UPDATE THE TABLE
        GetModule('usr_prof/02_material', 'contentCourse');
    }
    else
    { 
        // If the operation is canceled, nothing is done.
    }
}

let edit_material = function()
{
    var data_material = ModelCall("usr_prof/02_material","OPC=GET_MATERIAL_SPECIFIC&Id_Content="+this.dataset.id,"JSON");

    //We fill in the form fields:

    $("Id_Content").value = data_material[0][0];
    $("material_text").value = data_material[0][1]; 
    $("material_url").value = data_material[0][2]; 

    OpenModal(1,300);

    $("my_h2").innerHTML = "Edit material";
    $("my_h2").style.color = "#5f5f5f";
    $("material_send").innerHTML = "Save changes";

    $("material_send").onclick=function()
    {
        // We check that the name and surname fields are not empty

        $("material_text").value=$("material_text").value.trim();
        $("material_url").value=$("material_url").value.trim();
        
        if(($("material_text").value=="") || $("material_url").value=="")
        {
            Message("msg_status", "red", "ERROR, some field is empty. No changes have been made.");
            return false;
        }

        $("OPC").value="EDIT_MATERIAL";
        
        var resp = ModelCall("usr_prof/02_material", "form_Material", "JSON");

        if(resp[0])
        {
            Message("msg_status", "green", "The data has been changed successfully");
            
            //TO UPDATE THE TABLE OF TEACHERS RECORDS
            GetModule('usr_prof/02_material', 'contentCourse');
            
            $("form_Material").reset(); // To reset the content of the modal window form
            CloseModal(1); //To close the modal window
        }
        return false; // To prevent submission and page reload
    }
}

/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();