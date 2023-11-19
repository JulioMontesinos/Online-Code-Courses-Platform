$("Initialize").onclick=function()
{
	$("LoadTable").onclick();
    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}

$("LoadTable").onclick=function()
{
    var JSON = ModelCall("usr_adm/01_courses","OPC=GET_DATA_COURSES","JSON");
	var header = ["", "ID", "Name"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID.
    
    var opc = {
        "header": [ 
                    ["➕", add_course] /*add_course is a function*/ ] ,

        "rows": [
                    ["✏️", edit_course],

                    ["❌", delete_course] /*edit_course and delete_course are functions*/
                ]
    };

    CreateTable(header, JSON, opc, "Full_table");

    if(JSON.length == 0)
        $("Full_table").innerHTML+="<h4>There are no curses created<br/>Press the button [➕] to create a new course</h4>";
    
}

/****************************************************************************************************************/
/////////////////////////////////////SECTION FUNCTION INSIDE THE JSON OBJECT/////////////////////////////////////

let add_course = function()
{
    $("form_courses").reset();
    OpenModal(1,300);

    // ALL THESE CHANGES ARE MADE TO HIDE FIELDS, UNLOCK THE EMAIL INPUT WRITING, AND PRESERVE THE DESIRED STYLES.

    $("course_id").type = "hidden";
    $("my_h2").innerHTML = "Add course";
    $("my_h2").style.color = "#5f5f5f"; 
    $("course_send").innerHTML = "Add";

    $("course_send").onclick=function()
    {

        $("course_name").value=$("course_name").value.trim();
        
        if($("course_name").value=="")
        {
            Message("msg_status", "red", "ERROR, The form field cannot be empty.");
            return false;
        }

        $("OPC").value="NEW_COURSE";
            
        var resp = ModelCall("usr_adm/01_courses", "form_courses", "JSON");

        if(resp[0])
        {
            //TO UPDATE THE TABLE OF TEACHER RECORDS
            GetModule('usr_adm/01_courses', 'main');
            
            $("form_courses").reset(); //To reset the content of the modal window form.
            CloseModal(1);//To close the modal window
        }
        else
        {
            Message("msg_status", "red", resp[1]);
        }

        return false; //To prevent submission and page reload.
    }
}

let delete_course = function()
{
    //We obtain the name of the teacher:
    var data_course = ModelCall("usr_adm/01_courses","OPC=GET_DATA_COURSE&Id_Course="+this.dataset.id,"JSON");

    var confirmation = Confirm(data_course[0][1],"delete");

    if(confirmation)
    { //In case the user confirms, the deletion of the user will proceed.

        var resp = ModelCall("usr_adm/01_courses","OPC=DELETE_COURSE&Id_Course="+this.dataset.id,"TEXT");

        if(resp == "0")
        {
            alert("ERROR, the course has not been deleted because there is an associated edit linked to that course.")
        }
        else
        { 
            //NOW WE UPDATE THE TABLE
            GetModule('usr_adm/01_courses', 'main');
        }
    }
    else
    { 
        //If the operation is canceled, nothing is performed.
    }
}

let edit_course = function()
{
    var data_course = ModelCall("usr_adm/01_courses","OPC=GET_DATA_COURSE&Id_Course="+this.dataset.id,"JSON");
            
    //We fill in the form fields:
    
    $("course_id").value = data_course[0][0]; //It is same that  this.dataset.id
    $("course_name").value = data_course[0][1];

    OpenModal(1,300);
    
    //ALL THESE PROPERTIES ARE DEFAULT, BUT IF THE USER USES THE ADD EDITION FORM,
    //THE STYLES THAT WERE DEFAULT IN THE FORM SHOULD BE RESTORED.
    
    $("course_id").type = ""; //To remove the hidden input
    $("my_h2").innerHTML = "Edit course";
    $("my_h2").style.color = "#5f5f5f";
    $("course_send").innerHTML = "Changes saved";

    $("course_send").onclick=function()
    {
    
        $("course_name").value=$("course_name").value.trim();
        if($("course_name").value=="")
        {
            Message("msg_status", "red", "ERROR, The form field cannot be empty.");
            return false;
        }
        $("OPC").value="EDIT_COURSE";

        var resp = ModelCall("usr_adm/01_courses", "form_courses", "JSON");

        if(resp[0])
        {
            Message("msg_status", "green", "The data has been successfully modified");
            
            //TO UPDATE THE TABLE OF COURSE RECORDS
            GetModule('usr_adm/01_courses', 'main');
            
            $("form_courses").reset(); //To reset the content of the modal window form.
            CloseModal(1); //To close the modal window.
        }else
        {
            Message("msg_status", "red", resp[1]);
        }
    
        return false; //To prevent submission and page reload.
    }
}

/////////////////////////////////////JSON OBJECT FUNCTIONS SECTION/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();
