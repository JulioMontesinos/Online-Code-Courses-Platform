<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must be the same as the identifier of the view part.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    case "GET_TEACHERS": //ALL NON-RESPONSIBLE TEACHERS FOR THAT EDITION
        $SQL = "SELECT u.ID, u.ID, u.Name, u.Surname, u.Email from user u, impart i where u.ID=i.Id_Teacher and i.Id_Edition='$Id_Edition' and i.Responsible='0' ORDER BY u.Name ASC";
		echo Query2JSON($SQL);
		break;

	case "GET_TEACHER": //A SPECIFIC TEACHER
		$SQL = "SELECT u.Name, u.Surname from user u, impart i where u.ID=i.Id_Teacher and i.Id_Edition='$Id_Edition' and i.Responsible='0' and Id_Teacher='$Id_Teacher'";
		echo Query2JSON($SQL);
		break;

	case "DELETE_TEACHER":
		$SQL_eliminar = "DELETE FROM impart WHERE Id_Teacher='$Id_Teacher' and Id_Edition='$Id_Edition' and Responsible='0'";
		$res_delete = $mysqli->query($SQL_eliminar);
		break; 

	case "NEW_TEACHER":
        $SQL = "INSERT INTO impart (Id_Teacher, Id_Edition, Responsible) VALUES ('$Id_Teacher','$Id_Edition','0')";
        $res = $mysqli->query($SQL);
        echo '([1])';
		break;

    case "GET_LIST_TEACHERS":
        //SHOW THE TEACHERS THAT ARE AVAILABLE AND ARE NOT TEACHERS OF THAT EDITION
		$SQL="SELECT u.ID, CONCAT(u.Name, ' (',u.Email, ')') from user u where (u.Rol='Teacher' or u.Rol='Administrator') and u.ID NOT IN ( SELECT Id_Teacher from impart WHERE Id_Edition='$Id_Edition')";
        echo Query2JSON($SQL);
        break;

    default:
        print_r($_POST);
        break;
}
?>