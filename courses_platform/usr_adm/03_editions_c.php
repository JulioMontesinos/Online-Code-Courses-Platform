$("Initialize").onclick=function()
{
	$("LoadTable").onclick();
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}


$("LoadTable").onclick=function()
{
   
    var JSON = ModelCall("usr_adm/03_editions","OPC=GET_DATA_EDITIONS","JSON");
	var header = ["", "ID", "Date", "Name", "Status","Responsible"]; //The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID.
    var opc = {
        "header": [ 
                    ["➕", add_edition] /*add_edition is a function*/ ] ,

        "rows": [
                    ["✏️", edit_edition],

                    ["❌", delete_edition] /*edit_edition and delete_edition are functions*/
                ]
    };

    CreateTable(header, JSON, opc, "Full_table");
    if(JSON.length == 0)
        $("Full_table").innerHTML+="<h4>There are no created editions<br/>Press the button [➕] to create a new edit_edition</h4>";
}


/****************************************************************************************************************/
/////////////////////////////////////JSON OBJECT FUNCTIONS SECTION/////////////////////////////////////

let add_edition = function()
{
    $("form_editions").reset();
    OpenModal(1,300);

    ClearSelect("select_edition_course");
    ClearSelect("select_edition_teacher");

    SetSelect("usr_adm/03_editions","OPC=GET_LIST_COURSES","select_edition_course");
    SetSelect("usr_adm/03_editions","OPC=GET_LIST_TEACHERS","select_edition_teacher");

    //ALL THESE CHANGES ARE MADE TO HIDE FIELDS, UNLOCK THE EMAIL INPUT WRITING, AND PRESERVE THE DESIRED STYLES.

    $("edicion_id").type = "hidden";
    $("select_edition_course").style.display  = "";
    $("my_h2").innerHTML = "Add edition";
    $("my_h2").style.color = " #5f5f5f";

    $("edition_send").innerHTML = "Add";
    
    $("edition_send").onclick=function(){

        //We check that the form fields are not empty.


        $("edicion_fecha").value=$("edicion_fecha").value.trim();
        $("edicion_nombre").value=$("edicion_nombre").value.trim();
        $("edicion_estado").value=$("edicion_estado").value.trim();
        $("select_edition_teacher").value=$("select_edition_teacher").value.trim();
        $("select_edition_course").value=$("select_edition_course").value.trim();

            
        if(($("edicion_fecha").value=="") || $("edicion_nombre").value=="" || $("edicion_estado").value=="" || $("select_edition_teacher").value=="" || $("select_edition_course").value=="" || $("select_edition_teacher").selectedIndex==0 || $("select_edition_course").selectedIndex==0 )
        {
            Message("msg_status", "red", "ERROR, Some form field is empty.");
            return false;
        }

        $("OPC").value="NEW_EDITION";
        
        var resp = ModelCall("usr_adm/03_editions", "form_editions", "JSON");
        
        if(resp[0])
        {
            //TO UPDATE THE TABLE OF TEACHER RECORDS
            GetModule('usr_adm/03_editions', 'main');
            
            $("form_editions").reset(); //To reset the content of the modal window form.
            CloseModal(1); //To close the modal window
        }
        else
        {
            Message("msg_status", "red", resp[1]);
        }
        return false; //To prevent submission and page reload.
    }
}

let edit_edition = function()
{
    var data_editions = ModelCall("usr_adm/03_editions","OPC=GET_DATA_EDITION&Id_Edition="+this.dataset.id,"JSON");
                        
    ClearSelect("select_edition_teacher");
    SetSelect("usr_adm/03_editions","OPC=GET_LIST_TEACHERS","select_edition_teacher");
    //We fill in the form fields:
    
    $("edicion_id").value = data_editions[0][0]; //It is same that this.dataset.id
    $("edicion_fecha").value = data_editions[0][1];
    $("edicion_nombre").value = data_editions[0][2];
    $("edicion_estado").value = data_editions[0][3];
    $("select_edition_teacher").value = data_editions[0][4];
    $("edicion_id_profesor").value = data_editions[0][4];

    OpenModal(1,300);
    
    //ALL THESE PROPERTIES ARE DEFAULT, BUT IF THE USER USES THE ADD EDITION FORM,
    //THE STYLES THAT WERE DEFAULT IN THE FORM SHOULD BE RESTORED.
    
    $("select_edition_course").style.display  = "none";
    $("my_h2").innerHTML = "Edition edit";
    $("my_h2").style.color = "#5f5f5f";
    $("edition_send").innerHTML = "Changes saved";

    $("edition_send").onclick=function()
    {

        //We check that the fields for name and surname are not empty.
        $("edicion_fecha").value=$("edicion_fecha").value.trim();
        $("edicion_nombre").value=$("edicion_nombre").value.trim();
        $("edicion_estado").value=$("edicion_estado").value.trim();
        $("select_edition_teacher").value=$("select_edition_teacher").value.trim();
        $("select_edition_course").value=$("select_edition_course").value.trim();

        if(($("edicion_fecha").value=="") || $("edicion_nombre").value=="" || $("edicion_estado").value=="" || $("select_edition_teacher").value=="" || $("select_edition_course").value=="")
        {
            Message("msg_status", "red", "ERROR, some form fiel is empty.");
            return false;
        }

        $("OPC").value="EDIT_EDITION";

        var resp = ModelCall("usr_adm/03_editions", "form_editions", "TEXT");

        if(resp[0])
        {
            Message("msg_status", "green", "The data has been successfully modified");
            
            //TO UPDATE THE TABLE OF EDITIONS RECORDS
            GetModule('usr_adm/03_editions', 'main');
            
            $("form_editions").reset(); //To reset the content of the modal window form.
            CloseModal(1); //To close the modal window
        }
        return false; //To prevent submision and page reload
    }
}

let delete_edition = function()
{
    //WE GET THE NAME EDITION
    var data_editions = ModelCall("usr_adm/03_editions","OPC=GET_DATA_EDITION&Id_Edition="+this.dataset.id,"JSON");

    var confirmation = Confirm(data_editions[0][2],"delete");

    if(confirmation)
    { //If the user confirm, the user will be deleted.

        ModelCall("usr_adm/03_editions","OPC=DELETE_EDITION&Id_Edition="+this.dataset.id,"TEXT");
        //AHORA ACTUALIZAMOS LA TABLA
        GetModule('usr_adm/03_editions', 'main');

    }
    else
    { 
        //If the operation is canceled, nothing is executed
    }
}

/////////////////////////////////////JSON Object Functions Section/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();