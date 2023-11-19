<?php
session_start();
if($_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Student")
	exit();
?>
$("nav_courses_info").onclick=function()
{
    GetModule('usr_alu/01_info', 'contentCourseStudent');
}

$("nav_courses_material").onclick=function()
{
    GetModule('usr_alu/03_material', 'contentCourseStudent');
}

$("nav_courses_tasks").onclick=function()
{
    GetModule('usr_alu/04_tareas', 'contentCourseStudent');
}