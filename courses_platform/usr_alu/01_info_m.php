<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Student"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must be the same as the identifier of the view section.

$Id_Edition = $_SESSION["Id_Edition"];

switch($_POST["OPC"]){
    
    case "GET_DESCRIPTION":
		$SQL = "SELECT * from edition where Id_Edition = '$Id_Edition'";
		echo Query2JSON($SQL);
        break;

    default:
        print_r($_POST);
        break;
}
?>