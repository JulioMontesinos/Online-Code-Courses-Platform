$("Initialize").onclick=function()
{
	$("LoadTable_Tasks").onclick();
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}

$("LoadTable_Tasks").onclick=function()
{
   
    var JSON = ModelCall("usr_prof/03_tareas","OPC=GET_TASKS","JSON");
	var header = ["", "Title", "Statement", "Creation date","Expiration date"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID
    
    var opc = {
        "header": [ 
                    ["➕", add_task] /*add_task is a function*/ ] ,

        "rows": [
                    ["✏️", edit_task],

                    ["❌", delete_task] /*edit_task and delete_task are functions*/
                ]
    };
    
    CreateTable(header, JSON, opc, "Full_table");
    
    if(JSON.length == 0)
        $("message_table").innerHTML+="<h4>No tasks created<br/>Press the button [➕] to create a new task</h4>";

}

/****************************************************************************************************************/
/////////////////////////////////////SECTION FUNCTION INSIDE THE JSON OBJECT/////////////////////////////////////

let add_task = function()
{
    $("form_tasks").reset();
    OpenModal(1,300);

    $("task_id").type = "hidden";
    $("my_h2").innerHTML = "Add task";
    $("my_h2").style.color = " #5f5f5f";

    $("task_send").innerHTML = "Add";
    
    $("task_send").onclick=function()
    {
        // We check that the form fields are not empty

        $("task_name").value=$("task_name").value.trim();
        $("task_statement").value=$("task_statement").value.trim();
        $("task_date_add").value=$("task_date_add").value.trim();
        $("task_date_exp").value=$("task_date_exp").value.trim();
            
        if(($("task_name").value=="") || $("task_statement").value=="" || $("task_date_add").value=="" || $("task_date_exp").value=="")
        {
            Message("msg_status", "red", "ERROR, Some form field is empty.");
            return false;
        }

        $("OPC").value="NEW_TASK";
        
        var resp = ModelCall("usr_prof/03_tareas", "form_tasks", "JSON");

        if(resp[0])
        {
            // TO UPDATE THE TABLE OF TEACHERS' RECORDS
            GetModule('usr_prof/03_tareas', 'contentCourse');
            
            $("form_tasks").reset(); // To reset the content of the modal window form
            CloseModal(1); //To close the modal window
        }
        else
        {
            Message("msg_status", "red", "An error occurred, no task has been created");
        }
        return false; // To prevent submission and page reload
    }
}

let edit_task = function()
{
    var data_task = ModelCall("usr_prof/03_tareas","OPC=GET_TASK&Id_Task="+this.dataset.id,"JSON");

    //We fill in the form fields:

    $("task_id").value = data_task[0][0]; //Is same that this.dataset.id
    $("task_name").value = data_task[0][1]; 
    $("task_statement").value = data_task[0][2];
    $("task_date_add").value = data_task[0][3];
    $("task_date_exp").value = data_task[0][4];

    OpenModal(1,300);

    // ALL THESE PROPERTIES ARE DEFAULT, BUT IF THE USER USES THE ADD TEACHER FORM,
    // THE STYLES THAT WERE DEFAULT IN THE FORM SHOULD BE RESTORED.

    $("my_h2").innerHTML = "Task edit";
    $("my_h2").style.color = "#5f5f5f";
    $("task_send").innerHTML = "Save changes";

    $("task_send").onclick=function()
    {
        //We check that the name and surname fields are not empty

        $("task_name").value=$("task_name").value.trim();
        $("task_statement").value=$("task_statement").value.trim();
        $("task_date_add").value=$("task_date_add").value.trim();
        $("task_date_exp").value=$("task_date_exp").value.trim();
        
        if(($("task_name").value=="") || $("task_statement").value=="" || $("task_date_add").value=="" || $("task_date_exp").value=="")
        {
            Message("msg_status", "red", "ERROR, some field is empty. No changes have been made");
            return false;
        }

        $("OPC").value="EDIT_TASK";
        
        var resp = ModelCall("usr_prof/03_tareas", "form_tasks", "JSON");

        if(resp[0])
        {
            Message("msg_status", "green", "The data has been modified successfully");
            
            //TO UPDATE THE TABLE OF TEACHERS RECORDS
            GetModule('usr_prof/03_tareas', 'contentCourse');
            
            $("form_tasks").reset(); //To reset the content of the modal window form
            CloseModal(1); //To close the window model
        }
        return false; //To prevent submission and page reload
    }
}

let delete_task = function()
{
    // We get the name of the task:

    var data_task= ModelCall("usr_prof/03_tareas","OPC=GET_TASK&Id_Task="+this.dataset.id,"JSON");

    var confirmation = Confirm(data_task[0][1],"delete");

    if(confirmation)
    { // In case the user confirms, the task will be deleted.

        ModelCall("usr_prof/03_tareas","OPC=DELETE_TASK&Id_Task="+this.dataset.id,"TEXT");
        //NOW WE UPDATE THE TABLE
        GetModule('usr_prof/03_tareas', 'contentCourse');
    }
    else
    { 
        // If the operation is canceled, nothing is done.
    }
}

/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();