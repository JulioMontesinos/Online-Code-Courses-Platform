<?php
session_start();
if(!isset($_SESSION["Rol"]))
	exit();
$ROL = $_SESSION["Rol"];

include("../libs/mysql.php");
POST2EscapeString();

$ID = $_SESSION["ID"]; // To avoid having to put it in every "case" I need.

switch($_POST["OPC"])
{
//////////////////////////////////////////////////////////////////////////
// LEFT SIDE MENUS ACCORDING TO USER ROLE.
	case "MENU_ROL":
		if($ROL=="Student" || $ROL=="Teacher" || $ROL=="Administrator")
			echo "<li id='li_Mycourses'>My courses</li>\n"
				."<ul id='menu_student' style='display:none'><li>zzz</li>"
				."</ul>\n";
		if($ROL=="Teacher" || $ROL=="Administrator")
			echo "<li id='li_Teaching'>Teaching</li>\n"
				."<ul id='menu_teacher' style='display:none'>"
				."</ul>\n";
		if($ROL=="Administrator")
			echo "<li id='li_Administration'>Administration</li>\n"
				."<ul id='menu_admin' style='display:none'>"
				."<li id='menuAdmin_courses'>Courses management</li>"
				."<li id='menuAdmin_teachers'>Teachers management</li>"
				."<li id='menuAdmin_editions'>Editions management</li>"
				."</ul>";
		break;

//////////////////////////////////////////////////////////////////////////
// OPTIONS FOR STUDENTS
	case "COURSES_STUDENT":
		$SQL="SELECT enrollment.Id_Edition, Name_Edition FROM enrollment, edition "
			."WHERE enrollment.Id_Edition = edition.Id_Edition AND enrollment.Id_Student = $ID AND enrollment.Enrollment_Status='Accepted' AND edition.Status_Edition='Activated'";
		echo Query2JSON($SQL);
		break;

//////////////////////////////////////////////////////////////////////////
// OPTIONS FOR TEACHERS
	case "TEACHING_PROFESSOR":
		// To get all the data from the taught course
		$SQL="SELECT impart.Id_Edition, Name_Edition, responsible FROM impart, edition "
			."WHERE impart.Id_Edition = edition.Id_Edition AND Id_Teacher = $ID AND Status_Edition='Activated'";
		echo Query2JSON($SQL);
		break;

	case "VARIABLE_SESSION_EDITION_TEACHER":
		$SQL="SELECT Responsible FROM impart, edition "
			."WHERE impart.Id_Edition = edition.Id_Edition "
			."AND impart.Id_Edition = $Id_Edition AND Id_Teacher = $ID "
			."AND Status_Edition='Activated'";
		$res=$mysqli->query($SQL);
		if($res->num_rows!=1)
			exit(); // ERROR, the teacher has "lost" access to their course.
		$fila = $res->fetch_assoc();

		$_SESSION["Id_Edition"] = $Id_Edition;
		$_SESSION["Responsible"] = $fila["Responsible"];
		break;

	case "VARIABLE_SESSION_EDITION_STUDENT":
		$SQL="SELECT Enrollment_Status FROM enrollment, edition "
			."WHERE enrollment.Id_Edition = edition.Id_Edition "
			."AND enrollment.Id_Edition = $Id_Edition AND Id_Student = $ID "
			."AND Enrollment_Status='Accepted'";
		$res=$mysqli->query($SQL);
		if($res->num_rows!=1)
			exit(); // ERROR, the student has lost access to the course.
		$fila = $res->fetch_assoc();

		$_SESSION["Id_Edition"] = $Id_Edition;
		break;

	case "CREATE_SESSION_TASK":
		$_SESSION["TAREA_PARA_ENTREGA"] = "-1";
		break;

	case "CREAR_SESSION_EDITOR":
		$_SESSION["TAREA_PARA_ENTREGA"] = "-1";
		break;

	default:
		print_r($_POST);
		break;
}
?>