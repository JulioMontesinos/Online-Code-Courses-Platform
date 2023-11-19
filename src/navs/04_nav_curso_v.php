<?php
session_start();
if($_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Administrator")
	exit();
?>
<button class="button_menu_teacher" id="nav_courses_info">Info.</button>
<button class="button_menu_teacher" id="nav_courses_material">Material</button>
<button class="button_menu_teacher" id="nav_courses_tasks">Tasks</button>
<button class="button_menu_teacher" id="nav_courses_submissions">Submissions</button>

<?php
if($_SESSION["Responsible"]!=1)
	exit();
?>
<button class="button_menu_teacher_resp" id="nav_courses_students">Students</button>
<button class="button_menu_teacher_resp" id="nav_courses_teachers">Teachers</button>
