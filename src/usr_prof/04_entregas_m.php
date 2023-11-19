<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must be the same as the identifier of the view part.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    
    case "GET_SUBMISSIONS": //ALL THE TASKS
		$SQL = "SELECT e.Id_Submission, e.Id_Submission, t.Task_Name, u.ID, u.Name, e.Submission_Date, e.Score"
				." FROM user u, task t, submission e"
                ." WHERE u.ID = e.Id_Student and e.Id_Task = t.Id_Task and e.Id_Task='$Id_Seleccionado' ORDER BY u.Name ASC";
		echo Query2JSON($SQL);
		break;
	
	case "GET_NAME_STUDENT":
		$SQL = "SELECT u.Name"
				." FROM user u, task t, submission e"
                ." WHERE u.ID = e.Id_Student and e.Id_Task = t.Id_Task and e.Id_Submission='$Id_Submission'";
		echo Query2JSON($SQL);
		break;

    case "GET_SUBMISSION": //A SPECIFIC TASK
		$SQL = "SELECT * from submission where Id_Submission='$Id_Submission'";
		echo Query2JSON($SQL);
        break;

	case "GET_TASK": //A SPECIFIC TASK. USED TO FILL IN THE TASK STATEMENT AND NAME FIELD IN THE EDITOR.
		$SQL = "SELECT * from task where Id_Task='$Id_Task'";
		echo Query2JSON($SQL);
		break;

	case "GRADE_SUBMISSION":
		$SQL="UPDATE submission "
			."SET Score='$submission_grade', Observations='$observations' "
			."WHERE Id_Submission='$Id_Submission'";
		$res=$mysqli->query($SQL);
		echo '([1])';
		break;

	case "GET_LIST_TASKS":
		$SQL="SELECT t.Id_Task, CONCAT(t.Task_Name, ' (ID:',t.Id_Task, ')') from task t where Id_Edition='$Id_Edition'";
		$res=$mysqli->query($SQL);
		echo Query2JSON($SQL);
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

	case "EDITOR_OPENED": //Used to prevent the code editor from reopening, loading the JavaScript file, or executing Pyodide.
		$_SESSION["EDITOR"]=1;
		break;

    default:
        print_r($_POST);
        break;
}
?>