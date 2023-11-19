$("navCoursesPriv").onclick=function()
{
    $("h1_text").innerHTML = "Available courses";

    var JSON = ModelCall("navs/02_nav_priv","OPC=GET_COURSES","JSON");
	var header = ["", "Edition name", "Description", "Number of students", "Responsible teacher", "Date"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID.
    var opc = {
        "header": [ ] , 
        "rows": [ 
                    ["Request Enrollment", request_enrollment] /*request_enrollment is a function*/
                ]
    };

    $("main").innerHTML="";
    CreateTable(header, JSON, opc, "main");
}


$("navProfile").onclick=function()
{
    $("h1_text").innerHTML = "User profile";
    GetModule('usr_alu/02_profile', 'main');
}

$("navSalir").onclick=function()
{
    var resp = ModelCall("navs/02_nav_priv", "OPC=LOGOFF", "TEXT"); 
      
    if(resp == "LOGOFF")
    {
        $("h1_text").innerHTML = "";
        $('h1').innerHTML = "Programming course and data science <a href='https://cio.umh.es/' target='_blank'>#CIO</a> <a href='https://umh.es/' target='_blank'>#UMH</a>";
        
        Change(99);
        GetModule('navs/01_nav_pub', 'headnav');
        $('main').style.left='50%';
    }
}

/****************************************************************************************************************/
/////////////////////////////////////JSON Object Functions Section/////////////////////////////////////

let request_enrollment = function()
{
    // NOW WE CHECK IF THE STUDENT WHO HAS REQUESTED ENROLLMENT IS ALREADY IN THE COURSE. 
    var enrolled = ModelCall("navs/02_nav_priv","OPC=CHECK_ENROLLMENT&Id_Edition="+this.dataset.id,"JSON");
    
    if(enrolled == "")
    { // IF THEY HAVE NEVER REQUESTED ENROLLMENT, THE REQUEST WILL BE CREATED.
        
        // IN ADDITION, I MUST CHECK WHETHER THEY ARE A TEACHER OR NOT, AS A TEACHER CANNOT BE A STUDENT IN THEIR OWN TAUGHT COURSE.
        var teaches_course = ModelCall("navs/02_nav_priv","OPC=CHECK_TEACHES_COURSE&Id_Edition="+this.dataset.id,"JSON");

        if(teaches_course == "0" || teaches_course == "1")
        {
            alert("It is not possible to enroll,as you are already teacher for this course. ");
        }
        else
        {
            ModelCall("navs/02_nav_priv","OPC=CREATE_INSCRIPTION&Id_Edition="+this.dataset.id,"TEXT");
            alert("The course enrollment request has been submitted successfully")
        }
    }      
    else
    { // IN CASE THEY HAVE REQUESTED ENROLLMENT BEFORE, WE NEED TO CHECK IF THEY ARE ALREADY IN THE COURSE OR IF THEIR REQUEST IS PENDING.
        if(enrolled =="Pendiente")
        {
            alert("The enrollment has already been requested. The request is pending processing.")
        }
        else if(enrolled == "Accepted")
        {
            alert("You are now enrolled in the course! :)");
        }
    }
}
/////////////////////////////////////FUNCTIONS SECTION WITHIN THE JSON OBJECT/////////////////////////////////////
/****************************************************************************************************************/

$("navCoursesPriv").onclick(); //Para que al principio cargue los courses y que el main no esté vacío