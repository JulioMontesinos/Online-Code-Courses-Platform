$("navCourses").onclick=function()
{
	$("main").innerHTML ="Available courses"+"<br/><br/><div id='Full_table'></div>"; // Public view table of courses.

	// ------------------------------------------------------
    // INFORMATION ABOUT THE CREATED TABLE
    // Columns --> Header
    // Rows --> Provided by the JSON object
    // ------------------------------------------------------

    // 1st We obtain the records of all courses
   
    var JSON = ModelCall("navs/01_nav_pub","OPC=GET_COURSES_TABLE","JSON");
	var header = ["", "Course name", "Description", "Number of students", "Date"]; // The first one is empty because in the SQL statement there is a "hidden" ID and another visible ID.
    var opc = {"header": [] , "rows": []};
    
    if(JSON && JSON.length > 0)
        CreateTable(header, JSON, opc, "Full_table"); // The table is created by passing the header and records of the database content.
    else
        $('Full_table').innerHTML="<h4>There are no courses available at the moment</h4>";
}

$("navEnter").onclick=function()
{
	GetModule("01_login", "main");
}

$("navRegistration").onclick=function()
{
	GetModule("02_registration", "main");
}

$("navCourses").onclick();

