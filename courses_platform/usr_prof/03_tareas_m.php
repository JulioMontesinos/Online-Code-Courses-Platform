<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); // If used, the variable name must be the same as the identifier of the view part.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    case "GET_TASKS": //ALL TASKS
		$SQL = "SELECT Id_Task, Task_Name, Statement, Creation_Date, Expiration_Date"
				." FROM task WHERE Id_Edition = '$Id_Edition' ORDER BY Expiration_Date ASC";
		echo Query2JSON($SQL);
		break;

	case "GET_TASK": //A SPECIFIC TASK
		$SQL = "SELECT * from task where Id_Task='$Id_Task'";
		echo Query2JSON($SQL);
		break;

	case "EDIT_TASK":
		$SQL="UPDATE task "
			."SET Task_Name='$task_name', Statement='$task_statement', Creation_Date='$task_date_add', Expiration_Date='$task_date_exp' "
			."WHERE Id_Edition='$Id_Edition' and Id_Task = '$task_id'";
		$res=$mysqli->query($SQL);
		echo '([1])';  
		break;

	case "DELETE_TASK":
		$SQL_eliminar = "DELETE FROM task WHERE Id_Task='$Id_Task' and Id_Edition='$Id_Edition'";
		$res_delete = $mysqli->query($SQL_eliminar);
		break;

	case "NEW_TASK":
        $SQL = "INSERT INTO task (Task_Name, Statement, Creation_Date, Expiration_Date, Id_Edition) VALUES ('$task_name','$task_statement','$task_date_add','$task_date_exp', '$Id_Edition')";
        $res = $mysqli->query($SQL);
        echo '([1])';
		break;

    default:
        print_r($_POST);
        break;
}
?>