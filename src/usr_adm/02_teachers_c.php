$("Initialize").onclick=function()
{
	$("LoadTable").onclick();
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}

$("LoadTable").onclick=function()
{   
    var JSON = ModelCall("usr_adm/02_teachers","OPC=GET_DATA_TEACHERS","JSON");
	var header = ["", "ID", "Name", "Surname", "Rol","Email"]; //The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID.
    
    var opc = {
        "header": [ 
                    ["➕", add_teacher] /*add_teacher is a function*/ ] ,

        "rows": [
                    ["✏️", edit_teacher],

                    ["❌", delete_teacher] /*edit_teacher and delete_teacher are functions*/
                ]
    };

    CreateTable(header, JSON, opc, "Full_table");

    if(JSON.length == 0)
        $("Full_table").innerHTML+="<h4>There are no teachers created<br/>Press the button [➕] to create a new teacher</h4>";

}

/****************************************************************************************************************/
/////////////////////////////////////JSON OBJECT FUNCTIONS SECTION/////////////////////////////////////

let add_teacher = function()
{
    $("form_teacher").reset();
    OpenModal(1,300);

    //ALL THESE CHANGES ARE MADE TO HIDE FIELDS, UNLOCK THE EMAIL INPUT WRITING, AND PRESERVE THE DESIRED STYLES.

    document.getElementById("profesor_id").type = "hidden";
    document.getElementById("profesor_rol").type = "hidden";
    document.getElementById("teacher_new_pass").placeholder = "Password";
    document.getElementById("my_h2").innerHTML = "Add user";
    document.getElementById("my_h2").style.color = "#5f5f5f";
    document.getElementById("profesor_email").readOnly = false; 
    document.getElementById("profesor_email").style.background ="white";
    document.getElementById("teacher_send").innerHTML = "Add";

    $("teacher_send").onclick=function(){

        //We check if the fields are empty

        $("profesor_nombre").value=$("profesor_nombre").value.trim();
        $("profesor_apellidos").value=$("profesor_apellidos").value.trim();
        $("profesor_email").value=$("profesor_email").value.trim();
        $("teacher_new_pass").value=$("teacher_new_pass").value.trim();

        if(($("profesor_nombre").value=="") || $("profesor_apellidos").value=="" || $("profesor_email").value=="" || $("teacher_new_pass").value=="")
        {
            Message("msg_status", "red", "ERROR, Some form field is empty.");
            return false;
        }

        if(!ValidateEmail($("profesor_email").value))
        {
            $("msg_status").style.color ="red";
            $("msg_status").innerHTML = "Error, incorrect email";
            setTimeout("$('msg_status').innerHTML=''", 4000);
            return false; //To prevent submission and page reload.
        }

        $("OPC").value="NEW_TEACHER";
            
        var resp = ModelCall("usr_adm/02_teachers", "form_teacher", "JSON");

        if(resp[0]){
            
            //TO UPDATE THE TABLE OF TEACHER RECORDS
            GetModule('usr_adm/02_teachers', 'main');
            
            $("form_teacher").reset(); //To reset the content of the modal window form.
            CloseModal(1); //To close the modal window

        }else{
            Message("msg_status", "red", resp[1]);
        }

        return false; //To prevent submission and page reload.

    }
}

let delete_teacher = function()
{
    //We get the name of the teachers:
    var data_teacher = ModelCall("usr_adm/02_teachers","OPC=GET_DATA_TEACHER&ID_profesor="+this.dataset.id,"JSON");

    var confirmation = Confirm("a "+data_teacher[0][1]+" "+data_teacher[0][2],"delete");

    //In case the user confirms, the user deletion will proceed.
    if(confirmation)
    { 
        //NOW WE CHECK IF THE USER WITH THE ROLE OF TEACHER IS RESPONSIBLE FOR ANY COURSE.
        //IF THEY ARE RESPONSIBLE FOR ANY COURSE, DELETION IS NOT ALLOWED.
        
        var is_responsible = ModelCall("usr_adm/02_teachers","OPC=IS_RESPONSIBLE&ID_profesor="+this.dataset.id,"TEXT");

        if(is_responsible == 1){
            alert("Error, "+data_teacher[0][1]+" "+data_teacher[0][2]+"cannot be deleted because they are responsible for at least 1 edition");
        
        }else{
            ModelCall("usr_adm/02_teachers","OPC=DELETE_TEACHER&ID_profesor="+this.dataset.id,"TEXT");
            //NOW WE UPDATE THE TABLE
            GetModule('usr_adm/02_teachers', 'main'); 
        }
        
    }
    else
    { 
        //If the operation is canceled, nothing is performed.
    }
}

let edit_teacher = function()
{
    var data_teacher = ModelCall("usr_adm/02_teachers","OPC=GET_DATA_TEACHER&ID_profesor="+this.dataset.id,"JSON");

    //We fill in the form fields:
    
    $("profesor_id").value = data_teacher[0][0]; //It is same that this.dataset.id
    $("profesor_nombre").value = data_teacher[0][1];
    $("profesor_apellidos").value = data_teacher[0][2];
    $("profesor_rol").value = data_teacher[0][3];
    $("profesor_email").value = data_teacher[0][4];

    OpenModal(1,300);
    
    //ALL THESE PROPERTIES ARE DEFAULT, BUT IF THE USER USES THE ADD TEACHER FORM,
    //THE STYLES THAT WERE DEFAULT IN THE FORM SHOULD BE RESTORED.

    $("my_h2").innerHTML = "Edit user";
    $("my_h2").style.color = "#5f5f5f";
    $("profesor_id").type = ""; //To delete the hidden input
    $("teacher_new_pass").placeholder = "New password";
    $("profesor_email").style.background ="#DDDDDD";
    $("profesor_email").readOnly = true; 
    $("teacher_send").innerHTML = "Save changes";

    $("teacher_send").onclick=function(){

        //We check that the fields for name and surname are not empty.
        
        $("profesor_nombre").value=$("profesor_nombre").value.trim();
        $("profesor_apellidos").value=$("profesor_apellidos").value.trim();
        
        if(($("profesor_nombre").value=="") || $("profesor_apellidos").value=="")
        {
            Message("msg_status", "red", "ERROR, The Name and/or Surname field is empty. No changes have been made.");
            return false;
        }

        $("OPC").value="EDIT_TEACHER";
        
        var resp = ModelCall("usr_adm/02_teachers", "form_teacher", "JSON");

        if(resp[0])
        {
            Message("msg_status", "green", "The data has been successfully modified");
            
            //TO UPDATE THE TABLE OF TEACHER RECORDS
            GetModule('usr_adm/02_teachers', 'main');
            
            $("form_teacher").reset(); //To reset the content of the modal window form.
            CloseModal(1); //To close the modal window
        }
        return false; //To prevent submission and page reload.
    }
}

/////////////////////////////////////JSON OBJECT FUNCTIONS SECTION/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();

