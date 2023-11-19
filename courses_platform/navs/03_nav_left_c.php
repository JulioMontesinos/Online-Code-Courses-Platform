$("LoadOptions").onclick=function()
{
    var resp = ModelCall("navs/03_nav_left", "OPC=MENU_ROL", "TEXT");
	$("sideMenu").innerHTML=resp;

	// Menu MY COURSES
	if($("li_Mycourses"))
	{
		$("li_Mycourses").onclick=function()
		{
			if($("menu_student").style.display=="")
			{
				$("menu_student").style.display="none";
				return false;
			}
			
			// HERE, THE BEHAVIOR OF THE COURSES BEING TAKEN BY THE STUDENT SHOULD BE LOADED (WHETHER THEY ARE AN ADMIN, TEACHER, OR STUDENT).
			var i;
			var courses = ModelCall("navs/03_nav_left", "OPC=COURSES_STUDENT", "JSON");
			
			if(courses.length==0)
			{
				alert("No enrolled courses");
				return false;
			}

			$("menu_student").innerHTML="";
			// In the loop, I add parentheses within the variable courses.length to prevent color changes in VS Code.
			for(i=0 ; i<(courses.length) ; i++)
			{
				var li = document.createElement("li");
				li.dataset.id = courses[i][0];
				li.innerHTML = courses[i][1];
				li.onclick=function()
				{
					// Now we create a session variable for the course.
					ModelCall("navs/03_nav_left", "OPC=VARIABLE_SESSION_EDITION_STUDENT&Id_Edition="+this.dataset.id, "JSON");

					$("h1_text").innerHTML= this.innerHTML;
					$("main").innerHTML="";
					$("main").innerHTML="<nav id='menuCourseStudent'></nav><div id='contentCourseStudent'>Content</div>";

					GetModule('navs/05_nav_student', 'menuCourseStudent');
					GetModule('usr_alu/01_info', 'contentCourseStudent');
					
					// Perform a model call by selecting all data with id = this.dataset.id and then execute the getModules function.
				}
				$("menu_student").appendChild(li);
			}
			$("menu_student").style.display="";
		}
	}

	//TEACHING MENU
	if($("li_Teaching"))
	{
		$("li_Teaching").onclick=function()
		{
			if($("menu_teacher").style.display=="")
			{
				$("menu_teacher").style.display="none";
				return false;
			}
			
			//Here, the behavior of the courses taught by the teacher should be loaded
			var i;
			var courses = ModelCall("navs/03_nav_left", "OPC=TEACHING_PROFESSOR", "JSON");
			
			if(courses.length==0)
			{
				alert("No teaching assigned...");
				return false;
			}

			$("menu_teacher").innerHTML="";
			// In the loop, I add parentheses within the variable courses.length to prevent color changes in VS Code.
			for(i=0 ; i<(courses.length) ; i++)
			{
				var li = document.createElement("li");
				li.dataset.id = courses[i][0];
				li.dataset.responsible = courses[i][2];
				li.innerHTML = courses[i][1] + (courses[i][2]==1?" 🎓":"");
				li.onclick=function()
				{
					//Now we create a variable of course session
					ModelCall("navs/03_nav_left", "OPC=VARIABLE_SESSION_EDITION_TEACHER&Id_Edition="+this.dataset.id, "TEXT");
					$("h1_text").innerHTML = this.innerHTML;
					$("main").innerHTML="<nav id='menuCourse'></nav><div id='contentCourse'>Content</div>";

					// Now we create the task session so that it is already defined in the submissions section.
					ModelCall("navs/03_nav_left", "OPC=CREATE_SESSION_TASK", "TEXT");
					
					GetModule('navs/04_nav_curso', 'menuCourse');
					GetModule('usr_prof/01_teaching', 'contentCourse');
				}
				$("menu_teacher").appendChild(li);
			}
			$("menu_teacher").style.display="";
		}
	}

/// Menu ADMIN
	if($("li_Administration"))
	{
		$("li_Administration").onclick=function()
		{
			if($("menu_admin").style.display=="none")
				$("menu_admin").style.display="";
			else
				$("menu_admin").style.display="none";
		}
		
		$("menuAdmin_courses").onclick=function()
		{
			$("h1_text").innerHTML="Course Management";
			$("main").innerHTML="";
			GetModule('usr_adm/01_courses', 'main');	
		}

		$("menuAdmin_teachers").onclick=function()
		{
			$("h1_text").innerHTML="Teacher Management";
			$("main").innerHTML="";
			GetModule('usr_adm/02_teachers', 'main');			
		}

		$("menuAdmin_editions").onclick=function()
		{
			$("h1_text").innerHTML="Edition Management";
			$("main").innerHTML="";
			GetModule('usr_adm/03_editions', 'main');
		}
	}
}

$("LoadOptions").onclick();