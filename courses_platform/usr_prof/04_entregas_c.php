$("Initialize").onclick=function()
{
    $("LoadTable_Submissions").onclick();

    SetModal(1,$("AddContainer_2").innerHTML);
	$("AddContainer_2").innerHTML = "";
    $("button_close_modal_2").onclick=function()
    {
        $("txt_output").innerHTML =""; /// Clear the textarea of results.
        editor.toTextArea(); // We unload the editor so that the next time it is loaded, there is no garbage from the previous load.
        CloseModal(1);  
    }

    SetModal(2,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(2);};
}

//We fill in the tasks dropdown:

ClearSelect("select_task");
SetSelect("usr_prof/04_entregas","OPC=GET_LIST_TASKS","select_task");

$("select_task").onchange=function()
{
    var JSON = ModelCall("usr_prof/04_entregas","OPC=GET_SUBMISSIONS&Id_Seleccionado="+$("select_task").value,"JSON");
	var header = ["", "ID Submit", "Task name", "Student ID","Student name", "Submit date","Notes"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID

    var opc = {
        "header": [    ] ,

        "rows": [
                    ["🔎", open_editor]
                ]
    };

    $("Full_table").innerHTML="";
    if(JSON.length > 0)
        CreateTable(header, JSON, opc, "Full_table");
    else
        $("Full_table").innerHTML="<h4>No submissions available for this task</h4>";


}

$("LoadTable_Submissions").onclick=function()
{

    var JSON = ModelCall("usr_prof/04_entregas","OPC=GET_SUBMISSIONS&Id_Seleccionado="+$("select_task").value,"JSON");
	var header = ["", "ID submit", "Task name", "Student ID","Student name", "Submit date","Notes"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID
    
    var opc = {
        "header": [    ] ,

        "rows": [
                    ["🔎", open_editor]
                ]
    };

    
    CreateTable(header, JSON, opc, "Full_table");

    if(JSON.length == 0)
        $("Full_table").innerHTML="<h4>No submissions available for this task</h4>";   

}

/****************************************************************************************************************/
/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////

let open_editor = function()
{
    // HERE THE TEXT EDITOR SHOULD OPEN.
    var name_student = ModelCall("usr_prof/04_entregas","OPC=GET_NAME_STUDENT&Id_Submission="+this.dataset.id,"JSON");
    var data_submission = ModelCall("usr_prof/04_entregas","OPC=GET_SUBMISSION&Id_Submission="+this.dataset.id,"JSON");
    var data_task = ModelCall("usr_prof/04_entregas","OPC=GET_TASK&Id_Task="+data_submission[0][6],"JSON");

    $("Task_h1").innerHTML = "Task name: '"+data_task[0][1]+"' (Student: "+name_student[0][0]+")"; //name_student[0][0] is the name student
    $("statement").innerHTML = data_task[0][2];

    var editor_open = ModelCall("usr_prof/04_entregas","OPC=PREVIOUSLY_OPENED_EDITOR","TEXT");
    
    if(editor_open==0)
    {
        //In this case, all libraries must be loaded for the first time

        async function init() {
            
            loadPyodide({ indexURL: "https://cdn.jsdelivr.net/pyodide/v0.19.1/full/" }).then((pyodide) => {
                globalThis.pyodide = pyodide;
                pyodide.loadPackage(["numpy"]);
                console.log("Module loaded.");		
            });
        }

        init();

        //USED TO PREVENT RE-ENTRY INTO THIS FUNCTION AND AVOID RELOADING PYODIDE
        ModelCall("usr_prof/04_entregas","OPC=EDITOR_OPENED","TEXT"); 
    
    }//OTHERWISE, IT SHOULD NOT LOAD ANYTHING, AS IT IS ALREADY PREVIOUSLY LOADED.

    //NOW WE ARE GOING TO LOAD THE SCRIPT FOR THE EDITOR:
    var script = document.createElement('script');
    script.src = "libs/editor.js";
    document.head.appendChild(script); 

    //NOW THE CONTENT OF THE SAVED USER SUBMISSION MUST BE RECOVERED, IF THEY DIDN'T HAVE ANYTHING BEFORE, IT WILL BE EMPTY.
    //FIRST, WE EMPTY THE CONTENT JUST IN CASE IT REMAINS FROM PREVIOUS EXECUTIONS:

    $("code").innerHTML = "";

    if(data_submission[0][4].length >0)
        $("code").value = data_submission[0][4];
    else
        $("code").value = ""; //To avoid it being null.
    
    OpenModal(1,"MAX");

    var Id_Submission=this.dataset.id; //I create it so that within the "save_code" button function, that value can be recovered.
    $("add_nota").onclick = function()
    {
        //We fill in the form fields:
    
        $("Id_Submission").value = data_submission[0][0];
        $("submission_grade").value = data_submission[0][1]; 
        $("observations").value = data_submission[0][5]; 
        
        OpenModal(2,300);

        $("my_h2").innerHTML = "Add Score";
        $("my_h2").style.color = "#5f5f5f";
        $("submission_send").innerHTML = "save changes";

        $("submission_send").onclick=function()
        {
            //WE CHECK THAT THE GRADE IS NOT EMPTY, IS A NUMBER, AND IS BETWEEN 0-10.
        
            $("submission_grade").value=$("submission_grade").value.trim();
            
            if($("submission_grade").value=="")
            {
                Message("msg_status", "red", "ERROR, some field is empty. No changes have been made");
                return false;
            }
            else if(!isNum($("submission_grade").value))
            {
                Message("msg_status", "red", "ERROR, a number must be entered. No changes have been made");
                return false;
            }
            else if($("submission_grade").value < 0 || $("submission_grade").value > 10)
            {
                Message("msg_status", "red", "ERROR, a grade between 0-10 must be entered. No changes have been made");
                return false;
            }

            $("OPC").value="GRADE_SUBMISSION";
            
            var resp = ModelCall("usr_prof/04_entregas", "form_Submissions", "JSON");

            if(resp[0])
            {
                Message("msg_status", "green", "The data has been modified successfully");
                
                //TO UPDATE THE TABLE OF TEACHERS' RECORDS
                GetModule('usr_prof/04_entregas', 'contentCourse');
                
                $("form_Submissions").reset(); //To reset the content of the modal window form
                CloseModal(2); //To close the modal window 
            }
            CloseModal(1);
            GetModule('usr_prof/04_entregas', 'contentCourse');
            return false; //To prevent submission and page reload
        }   
    }
}

/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////
/****************************************************************************************************************/

editor_readOnly = 0; //To make the CodeMirror editor code not editable

$("Initialize").onclick();