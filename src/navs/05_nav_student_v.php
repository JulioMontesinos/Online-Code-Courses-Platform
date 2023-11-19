<?php
session_start();
if($_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Student")
	exit();
?>
<button class="button_menu_student" id="nav_courses_info">Info.</button>
<button class="button_menu_student" id="nav_courses_material">Material</button>
<button class="button_menu_student" id="nav_courses_tasks">Tasks</button>