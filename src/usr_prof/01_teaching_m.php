<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); // If used, the variable name must be the same as the identifier of the view part.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    case "GET_DESCRIPTION":
		$SQL = "SELECT * from edition where Id_Edition = '$Id_Edition'";
		echo Query2JSON($SQL);
        break;

    case "SAVE_DESCRIPTION":
		$SQL = "UPDATE edition SET Description='$info_textArea' WHERE Id_Edition='$Id_Edition'";
		$res = $mysqli->query($SQL);
        break;

    default:
        print_r($_POST);
        break;
}

?>