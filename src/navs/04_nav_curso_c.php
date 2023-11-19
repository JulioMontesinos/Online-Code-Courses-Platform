<?php
session_start();
if($_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Administrator")
	exit();
?>
$("nav_courses_info").onclick=function()
{
    GetModule('usr_prof/01_teaching', 'contentCourse');
}

$("nav_courses_material").onclick=function()
{
    GetModule('usr_prof/02_material', 'contentCourse');
}

$("nav_courses_tasks").onclick=function()
{
    GetModule('usr_prof/03_tareas', 'contentCourse');
}

$("nav_courses_submissions").onclick=function()
{
    GetModule('usr_prof/04_entregas', 'contentCourse');
}

<?php
if($_SESSION["Responsible"]!=1)
	exit();
?>

$("nav_courses_students").onclick=function()
{
    GetModule('usr_prof/05_gestionAlu', 'contentCourse');
}

$("nav_courses_teachers").onclick=function()
{
    GetModule('usr_prof/06_gestionProf', 'contentCourse');
}
