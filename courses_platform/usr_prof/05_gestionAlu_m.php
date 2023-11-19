<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must be the same as the identifier of the view part.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    case "GET_STUDENTS": //ALL STUDENTS OF THAT EDITION
        $SQL = "SELECT u.ID, u.ID, u.Name, u.Surname, u.Email from user u, enrollment m WHERE u.ID = m.Id_Student and m.Id_Edition = '$Id_Edition' and m.Enrollment_Status = 'Accepted'  ORDER BY u.Name ASC";
		echo Query2JSON($SQL);
		break;

    case "GET_STUDENTS_ADD": //GET THE LIST OF ALL STUDENTS WHO HAVE APPLIED TO JOIN THE COURSE.
        $SQL = "SELECT u.ID, u.ID, u.Name, u.Surname, u.Email from user u, enrollment m WHERE u.ID = m.Id_Student and m.Id_Edition = '$Id_Edition' and m.Enrollment_Status = 'Pendiente'";
        echo Query2JSON($SQL);
		break;
        
	case "GET_STUDENT": //A SPECIFIC STUDENT
		$SQL = "SELECT u.Name, u.Surname from user u, enrollment m where u.ID=m.Id_Student and m.Id_Edition='$Id_Edition' and Id_Student='$Id_Student'";
		echo Query2JSON($SQL);
		break;

	case "DELETE_STUDENT":
		$SQL_eliminar = "DELETE FROM enrollment WHERE Id_Student='$Id_Student' and Id_Edition='$Id_Edition' and Enrollment_Status='Accepted'";
		$res_delete = $mysqli->query($SQL_eliminar);
		break;

    case "ACCEPT_STUDENT": 
        $SQL ="UPDATE enrollment SET Enrollment_Status='Accepted' WHERE Id_Edition='$Id_Edition' and Id_Student='$Id_Student'";
        $res=$mysqli->query($SQL);
        break;

    case "REJECT_STUDENT":
        $SQL ="DELETE FROM enrollment WHERE Id_Student='$Id_Student' and Id_Edition='$Id_Edition' and Enrollment_Status='Pendiente'";
        $res=$mysqli->query($SQL);
        break;

    case "DELETE_SUBMISSIONS_STUDENT":
        $SQL ="DELETE FROM submission WHERE Id_Submission "
            ."IN (SELECT e.Id_Submission FROM submission e, task t WHERE t.Id_Task = e.Id_Task and e.Id_Student='$Id_Student' and e.Id_Task "
            ."IN (SELECT t.Id_Task FROM task WHERE t.Id_Edition='$Id_Edition'))";
        $res=$mysqli->query($SQL);
        break;

    default:
        print_r($_POST);
        break;
}
?>