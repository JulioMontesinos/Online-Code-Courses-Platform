$("Initialize").onclick=function()
{
	$("LoadTable_Tasks").onclick();
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function()
    {
        var confirmation = Confirm("The code editor. (IF NOT SAVED BEFOREHAND, PROGRESS OF THE PROGRAMMED CODE CAN BE LOST)","cerrar");

        if(confirmation)
        { //In the event that the user confirms, the modal window of the editor will be closed.
            
            $("txt_output").innerHTML =""; //We clear the results textarea.
            editor.toTextArea(); //We unload the editor so that the next time it is loaded, there is no leftover debris from the previous load.

            CloseModal(1);
        }
        else
        { 
            //If the operation is canceled, nothing is performed. It is not necessary to include the "else" statement, but it is included for better understanding.
        }
    }
}

$("LoadTable_Tasks").onclick=function()
{
   
    var JSON = ModelCall("usr_alu/04_tareas","OPC=GET_TASKS","JSON");
	var header = ["", "Title", "statement", "Creation date","Expiration date"]; //The first one is empty because in the SQL statement there is a "hidden" ID and a visible ID.
    
    var opc = {
        "header": [    ] ,

        "rows": [
                    ["💻", enter_editor], /*enter_editor is a function*/

                    ["🎓", show_score] /*show_score is a function*/
                ]
    };
    
    CreateTable(header, JSON, opc, "Full_table");
    if(JSON.length == 0)
        $("Full_table").innerHTML+="<h4>There are no tasks created for this course....</h4>";

}

/****************************************************************************************************************/
/////////////////////////////////////SECTION FUNCTIONS WITHIN THE JSON OBJECT/////////////////////////////////////

let enter_editor = function()
{
    var data_task = ModelCall("usr_alu/04_tareas","OPC=GET_TASK&Id_Task="+this.dataset.id,"JSON");
    $("Task_h1").innerHTML = "Task name: '"+data_task[0][1]+"'";
    $("statement").innerHTML = data_task[0][2];

    var editor_open = ModelCall("usr_alu/04_tareas","OPC=PREVIOUSLY_OPENED_EDITOR","TEXT");
    
    if(editor_open==0)
    {
        //In this case, all libraries should be loaded for the first time.

        async function init() {
    
            loadPyodide({ indexURL: "https://cdn.jsdelivr.net/pyodide/v0.19.1/full/" }).then((pyodide) => {
                globalThis.pyodide = pyodide;
                pyodide.loadPackage(["numpy"]);
                console.log("Module loaded.");		
            });
        }
        init();

        //USED TO PREVENT FURTHER ENTRY INTO THIS FUNCTION.
        ModelCall("usr_alu/04_tareas","OPC=EDITOR_OPENED","TEXT"); 
    
    }//IN ANOTHER CASE, IT SHOULDN'T LOAD ANYTHING, AS IT IS ALREADY LOADED PREVIOUSLY.

    //NOW LET'S LOAD THE SCRIPT FOR THE EDITOR
    var script = document.createElement('script');
    script.src = "libs/editor.js";
    document.head.appendChild(script); 

    //NOW, THE CONTENT OF THE USER'S SAVED SUBMISSION MUST BE RETRIEVED; IF THERE WAS NOTHING BEFORE, IT WILL BE EMPTY.
    //FIRST, WE EMPTY THE CONTENT JUST IN CASE THERE IS ANY LEFTOVER FROM PREVIOUS EXECUTIONS:

    $("code").innerHTML = "";

    var student_submission = ModelCall("usr_alu/04_tareas","OPC=GET_SUBMISSION&Id_Task="+this.dataset.id,"JSON");
    if(student_submission.length >0)
        $("code").value = student_submission[0][0];
    else
        $("code").value = ""; //To prevent it from being null.

    OpenModal(1,"MAX");

    //NOW WE CHECK IF THE EXPIRATION DATE HAS PASSED OR NOT.

    var expiration_date = data_task[0][4];

    //NOW WE COMPARE THE EXPIRATION DATE WITH THE CURRENT DATE.
    var has_expired = expired_date(expiration_date);

    if(has_expired)
    {   //If it has expired, we prevent the user from clicking.
        $("save_code").style.backgroundColor = "#E88585";
        $("save_code").style.cursor = "auto";
        $("Task_h1").innerHTML = $("Task_h1").innerHTML+" 🔒";
    
    }
    else
    {   //TO RESTORE THE BUTTON PROPERTIES, IN CASE IT SHOULD WORK.
        $("save_code").style.backgroundColor = "#bfe1fb";
        $("save_code").style.cursor = "pointer";
    }

    var Id_Task=this.dataset.id; //I create it so that within the "save_code" button function, this value can be retrieved.
    $("save_code").onclick = function()
    {   
        if(!has_expired)
        {
            var submission_date = current_date();
            ModelCall("usr_alu/04_tareas","OPC=SAVE_SUBMISSION&Id_Task="+Id_Task+"&content_entrega="+encodeURIComponent(editor.getValue())+"&Fecha_entrega="+submission_date,"TEXT");
            alert("Content saved successfully");
        }else
        {
            alert("The submission deadline has EXPIRED; saving or submitting is not possible :(")
        }
    }
}

let show_score = function()
{
    //THIS CONCERNS THE BUTTON TO CHECK THE TASK GRADE:
    //FIRST, WE CHECK IF THE TASK HAS BEEN SUBMITTED.
    //SECOND, WE CHECK IF THE TEACHER HAS GRADED THE TASK.

    var submission = ModelCall("usr_alu/04_tareas","OPC=HAS_SUBMITTED_TASK&Id_Task="+this.dataset.id,"TEXT");
    if(submission == 0)
    {
        //In this case, the submission has not been made.
        alert("TASK SCORE: 'NOT SUBMITTED'");
    }
    else
    {
        //IF THE TASK HAS BEEN SUBMITTED:
        var data_task = ModelCall("usr_alu/04_tareas","OPC=GET_SCORE&Id_Task="+this.dataset.id,"JSON");

        //IF IT IS NOT A NUMBER, THE TEACHER HAS NOT YET GRADED THE TASK.

        if(!isNum(data_task[0][0]) || data_task[0][0] == "")
            data_task[0][0] = "'NOT GRADED'";
        
        if(data_task[0][1] == "")
            data_task[0][1] = "None"; //If the teacher has not provided any comments.

        alert("TASK GRADE: "+data_task[0][0]+"\n\nComments: "+data_task[0][1]);
    } 
}

/////////////////////////////////////FUNCTIONS SECTION WITHIN THE JSON OBJECT/////////////////////////////////////
/****************************************************************************************************************/

editor_readOnly = 1; //To make the code in the CodeMirror editor editable

$("Initialize").onclick();