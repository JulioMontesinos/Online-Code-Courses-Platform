<?php
session_start();

include("libs/mysql.php");
POST2EscapeString();

switch($_POST["OPC"])
{
	case "LOGIN":
		$SQL = "SELECT * from user where Email='$usrID' AND Password=PASSWORD('$usrPWD')";
		$res = $mysqli->query($SQL);

		if($res->num_rows == 1)
		{ 
			$registro = $res->fetch_assoc(); // Returns the next record, but since there is only one in this case, it would only be done once
			$_SESSION["ID"] = $registro["ID"];
			$_SESSION["User"] = $usrID;
			$_SESSION["Rol"] = $registro["Rol"];
			$_SESSION["Name"] = $registro["Name"];
			echo "([1])";
		}
		else
			echo "([0])";/* USER ERROR */
		break;
	default:
		print_r($_POST); 
		break;
}

?>