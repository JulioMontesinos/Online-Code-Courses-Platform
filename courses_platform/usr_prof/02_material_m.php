<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); // If used, the variable name must be the same as the identifier of the view part.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    case "GET_MATERIAL":
		$SQL = "SELECT Id_Content, Id_Content, Text, URL FROM content WHERE Id_Edition = '$Id_Edition' ORDER BY Text ASC";
		echo Query2JSON($SQL);
		break;

    case "GET_MATERIAL_SPECIFIC":
		$SQL = "SELECT * from content where Id_Content='$Id_Content'";
		echo Query2JSON($SQL);
        break;

	case "EDIT_MATERIAL":
		$SQL="UPDATE content "
			."SET Text='$material_text', URL='$material_url' "
			."WHERE Id_Edition='$Id_Edition' and Id_Content = '$Id_Content'";
		$res=$mysqli->query($SQL);
		echo '([1])';
		break;

	case "DELETE_MATERIAL": 
		$SQL_eliminar = "DELETE FROM content WHERE Id_Content='$Id_Content' and Id_Edition='$Id_Edition'";
		$res_delete = $mysqli->query($SQL_eliminar);
		break;

	case "NEW_MATERIAL":
        $SQL = "INSERT INTO content (Text, URL, Id_Edition) VALUES ('$material_text','$material_url','$Id_Edition')";
        $res = $mysqli->query($SQL);
        echo '([1])';
		break;

    default:
        print_r($_POST);
        break;
}
?>