$("Initialize").onclick=function()
{
    $("LoadTable_Students").onclick();

    SetModal(1,$("AddContainer").innerHTML);
	$("AddContainer").innerHTML = "";
    $("button_close_modal").onclick=function(){CloseModal(1);};
}

$("LoadTable_Students").onclick=function()
{
   
    var JSON = ModelCall("usr_prof/05_gestionAlu","OPC=GET_STUDENTS","JSON");
    
	var header = ["", "ID Student", "Name", "Surname","Email"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID
    
    var opc = {
        "header": [ 
                    ["➕", manage_requests] /*manage_requests is a function*/ ] ,

        "rows": [
                    ["❌", delete_student] /*delete_student are functions*/
                ]
    };
    
    CreateTable(header, JSON, opc, "Full_table");
    
    //if(JSON.length == 0)
        //$("Full_table").innerHTML+="<h4>No students are enrolled in the course<br/>Press the button [➕] to manage new requests</h4>";

}

$("LoadTable_Add").onclick=function()
{
   
    var JSON_2 = ModelCall("usr_prof/05_gestionAlu","OPC=GET_STUDENTS_ADD","JSON");
    
	var header_2 = ["", "ID Student", "Name", "Surname","Email"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID
    
    var opc_2 = {
        "header": [  ] ,

        "rows": [
                    ["✔️", accept_request], /*accept_request is a function*/
                    ["❌", decline_request] /*decline_request is a function*/
                ]
    };

    CreateTable(header_2, JSON_2, opc_2, "Full_table_add");
    
    if(JSON_2.length == 0)
        $("Full_table_add").innerHTML="<h4>There are no student requests to join the course...</h4>";

}


/****************************************************************************************************************/
/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////

let delete_student = function()
{
    //We get the name of the student to be deleted:
    var data_student= ModelCall("usr_prof/05_gestionAlu","OPC=GET_STUDENT&Id_Student="+this.dataset.id,"JSON");

    var confirmation = Confirm("a "+data_student[0][0]+" "+data_student[0][1]+"\n(THIS ACTION WILL DELETE THE STUDENT'S SUBMISSIONS)","delete");

    if(confirmation)
    {    //If the user confirms, the student will be deleted.
        //FIRST, WE DELETE ALL HIS/HER SUBMISSIONS AND THEN THE STUDENT.
        ModelCall("usr_prof/05_gestionAlu","OPC=DELETE_SUBMISSIONS_STUDENT&Id_Student="+this.dataset.id,"TEXT");
        ModelCall("usr_prof/05_gestionAlu","OPC=DELETE_STUDENT&Id_Student="+this.dataset.id,"TEXT");
        //NOW WE UPDATE THE TABLE
        GetModule('usr_prof/05_gestionAlu', 'contentCourse');
    }
    else
    { 
        //If the operation is canceled, nothing will be done.
    }
}

let manage_requests = function()
{
    $("my_h2").innerHTML = "<center>Manage admission requests to the course</center>";
    $("my_h2").style.color = " #5f5f5f";

    //------------------
    $("Full_table_add").innerHTML = ""; //Empty previous table
    $("LoadTable_Add").onclick();
    //------------------

    OpenModal(1,800);
}

let accept_request = function()
{
    //ACCEPT A STUDENT INTO THE COURSE

    var data_student= ModelCall("usr_prof/05_gestionAlu","OPC=GET_STUDENT&Id_Student="+this.dataset.id,"JSON");
    var confirmation_2 = Confirm("as a student to"+data_student[0][0]+" "+data_student[0][1],"añadir");

    if(confirmation_2)
    { //If the user confirms, the student will be deleted.

        ModelCall("usr_prof/05_gestionAlu","OPC=ACCEPT_STUDENT&Id_Student="+this.dataset.id,"JSON");
        //NOW WE RETURN TO THE TABLE OF ACCEPTED STUDENTS
        CloseModal(1);
        GetModule('usr_prof/05_gestionAlu', 'contentCourse');
    }
    else
    { 
        //If the operation is canceled, nothing will be done.
    }
}

let decline_request = function()
{
    //REJECT A STUDENT IN THE COURSE

    var data_student= ModelCall("usr_prof/05_gestionAlu","OPC=GET_STUDENT&Id_Student="+this.dataset.id,"JSON");
    var confirmation = Confirm("The student's request "+data_student[0][0]+" "+data_student[0][1]+" for the course","delete");

    if(confirmation)
    { //If the user confirms, the student will be deleted.

        ModelCall("usr_prof/05_gestionAlu","OPC=REJECT_STUDENT&Id_Student="+this.dataset.id,"JSON");
        //NOW WE RETURN TO THE TABLE OF ACCEPTED STUDENTS
        CloseModal(1);
        GetModule('usr_prof/05_gestionAlu', 'contentCourse');
    }
    else
    { 
        //If the operation is canceled, nothing will be done.
    }
}

/////////////////////////////////////FUNCTIONS SECTION INSIDE THE JSON OBJECT/////////////////////////////////////
/****************************************************************************************************************/

$("Initialize").onclick();