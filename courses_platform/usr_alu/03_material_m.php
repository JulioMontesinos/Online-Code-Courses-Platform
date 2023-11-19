<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Student"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); // If used, the variable name must be the same as the identifier in the view part

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"])
{
    case "GET_MATERIAL":
      $SQL = "SELECT Id_Content, Id_Content, Text, URL FROM content WHERE Id_Edition = '$Id_Edition' ORDER BY Text ASC";
      echo Query2JSON($SQL);
      break;

    default:
      print_r($_POST);
      break;
}
?>