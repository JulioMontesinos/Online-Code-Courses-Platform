$("Initialize").onclick=function()
{
	$("LoadTable_Teachers").onclick();
    
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}

$("LoadTable_Teachers").onclick=function()
{
   
    var JSON = ModelCall("usr_prof/06_gestionProf","OPC=GET_TEACHERS","JSON");
    
	var header = ["", "ID Teacher", "Name", "Surname","Email"]; //The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID
    
    var opc = {
        "header": [ 
                    ["➕", add_teacher] /*add_teacher is a function*/ 
                  ] ,

        "rows": [
                    ["❌", delete_teacher] /*delete_teacher is a function*/
                ]
    };
    
    CreateTable(header, JSON, opc, "Full_table");
    
    //if(JSON.length == 0)
        //$("Full_table").innerHTML+="<h4>There are no non-responsible teachers in the course...</h4>";

}

/****************************************************************************************************************/
/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////

let add_teacher = function()
{
    $("form_Teachers").reset();
    ClearSelect("select_teacher");
    SetSelect("usr_prof/06_gestionProf","OPC=GET_LIST_TEACHERS","select_teacher");
    OpenModal(1,300);

    $("my_h2").innerHTML = "Add teacher";
    $("my_h2").style.color = " #5f5f5f";

    $("teacher_send").innerHTML = "Add";
    
    $("teacher_send").onclick=function()
    {  
        //Check that the fields in the form are not empty
        $("select_teacher").value=$("select_teacher").value.trim();

        if(($("select_teacher").value=="") || $("select_teacher").selectedIndex==0)
        {
            Message("msg_status", "red", "ERROR, The form field is empty.");
            return false;
        }
        
        $("OPC").value="NEW_TEACHER";

        $("Id_Teacher").value = $("select_teacher").value;
        
        var resp = ModelCall("usr_prof/06_gestionProf", "form_Teachers", "JSON");
        
        if(resp[0])
        {
            //TO UPDATE THE TABLE OF TEACHER RECORDS
            GetModule('usr_prof/06_gestionProf', 'contentCourse');
            
            $("form_Teachers").reset(); //To reset the content of the modal window form
            CloseModal(1); //To close the modal window
        }
        else
        {
            Message("msg_status", "red", "An error occurred, no teacher has been added.");
        }
        return false; //To prevent the submit and page reload
    }
}

let delete_teacher = function()
{
    //We obtain the name of the teacher who is going to be deleted:
    var data_teacher= ModelCall("usr_prof/06_gestionProf","OPC=GET_TEACHER&Id_Teacher="+this.dataset.id,"JSON");

    var confirmation = Confirm("a "+data_teacher[0][0]+" "+data_teacher[0][1],"delete");

    if(confirmation)
    {  //If the user confirms, the task will be deleted.

        ModelCall("usr_prof/06_gestionProf","OPC=DELETE_TEACHER&Id_Teacher="+this.dataset.id,"TEXT");
        //NOW WE UPDATE THE TABLE
        GetModule('usr_prof/06_gestionProf', 'contentCourse');
    }
    else
    { 
        //If the user cancels the operation, nothing will be done.
    }
}


/////////////////////////////////////JSON OBJECT FUNCTIONS SECTION/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();