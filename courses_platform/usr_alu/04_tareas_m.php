<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Student"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must be the same as the identifier in the view part.

$Id_Edition = $_SESSION["Id_Edition"];
$Id_Alu = $_SESSION["ID"];

switch($_POST["OPC"]){
    
    case "GET_TASKS": //ALL TASKS
		$SQL = "SELECT Id_Task, Task_Name, Statement, Creation_Date, Expiration_Date"
				." FROM task WHERE Id_Edition = '$Id_Edition' ORDER BY Expiration_Date ASC";
		echo Query2JSON($SQL);
		break;

	case "GET_TASK": //A SPECIFIC TASK
		$SQL = "SELECT * from task where Id_Task='$Id_Task'";
		echo Query2JSON($SQL);
		break;

    case "GET_SCORE": 
        $SQL = "SELECT Score, Observations from submission where Id_Task='$Id_Task' and Id_Student='$Id_Alu'";    
        echo Query2JSON($SQL);
		break;

	case "HAS_SUBMITTED_TASK":
		$SQL = "SELECT Id_Submission from submission where Id_Task='$Id_Task' and Id_Student='$Id_Alu'";
		$res=$mysqli->query($SQL);
		
		if($res->num_rows==0)
		{
			echo "0";
		}
		else
		{
			echo "1";
		}
		break;

	case "PREVIOUSLY_OPENED_EDITOR":
		if($_SESSION["EDITOR"]==0)
		{
			echo "0";
		}
		else
		{
			echo "1";
		}
		break;	
	
	case "EDITOR_OPENED": //It is used to prevent reopening the code editor, loading the JavaScript file, or executing Pyodide.
		$_SESSION["EDITOR"]=1;
		break;

	case "GET_SUBMISSION":
		$SQL ="SELECT Submission FROM submission WHERE Id_Task='$Id_Task' and Id_Student='$Id_Alu'";
		echo Query2JSON($SQL);
		break;

	case "SAVE_SUBMISSION":
		$existe_entrega = "SELECT Id_Submission from submission WHERE Id_Task='$Id_Task' and Id_Student='$Id_Alu'";
		$res=$mysqli->query($existe_entrega);
		
		if($res->num_rows==0)
		{ //IN THIS CASE, IT SAVES THE SUBMISSION FOR THE FIRST TIME, SO AN INSERT WILL BE MADE.
			$SQL_insert = "INSERT INTO submission (Id_Submission, Score, Submission_Date, Type, Submission, Observations, Id_Task, Id_Student) VALUES ('','','$Fecha_entrega','Codigo Python','$content_entrega','','$Id_Task','$Id_Alu')";
			$res = $mysqli->query($SQL_insert);
		}
		else
		{ //IN THIS CASE, THE SUBMISSION HAS BEEN SAVED PREVIOUSLY, SO AN UPDATE WILL BE MADE.
			$SQL_update = "UPDATE submission SET Submission_Date='$Fecha_entrega', Submission='$content_entrega' WHERE Id_Task='$Id_Task' and Id_Student='$Id_Alu'";
			$res = $mysqli->query($SQL_update);
		}
		break;

    default:
        print_r($_POST);
        break;
}
?>