<?php
session_start();
if(!isset($_SESSION["Rol"]) || ($_SESSION["Rol"]!="Administrator" && $_SESSION["Rol"]!="Teacher" && $_SESSION["Rol"]!="Student"))
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must match the identifier of the view part.

$id = $_SESSION["ID"];

switch($_POST["OPC"])
{
    case "GET_DATA":
		
		$SentenceSQL = "select ID, Name, Surname, Rol, Password, Email from user where ID='$id'";
		echo Query2JSON($SentenceSQL);
        break;

    case "RECORD":
        $rol = $_SESSION["Rol"]; //Cannot be modified

		if ((strcmp($Name,"") != 0) && (strcmp($Surname,"") != 0))
		{    //If they are not empty
			//Check with a select if the old password entered by the user is equal to the one stored, the result should be 1
			$match_old_pass_validate = "SELECT * from user WHERE Password=PASSWORD('$Pass_Vieja') and ID='$id'";
			$res_match_admin = $mysqli->query($match_old_pass_validate);

			if($res_match_admin->num_rows == 1)
			{//CHECK THE OLD PASSWORD TO MAKE CHANGES
				
				if(strcmp($New_Pass,"") == 0)
				{	//If the new password is empty and the user does not want to change it
					$SentenceSQL = "UPDATE user SET Name='$Name', Surname='$Surname' WHERE ID='$id'";
					$res = $mysqli->query($SentenceSQL);
					$_SESSION["Name"] = $Name;
					echo '([1])';
				}
				else if(strcmp($New_Pass,"") != 0)
				{	//If the user wants to change the password as well
					$SentenceSQL = "UPDATE user SET Name='$Name', Surname='$Surname', Password=PASSWORD('$New_Pass') WHERE ID='$id'";
					$res = $mysqli->query($SentenceSQL);
					$_SESSION["Name"] = $Name;
					echo '([1])';
				}
			}
			else
			{
				//The old password is incorrect
				echo '([0, "ERROR, The old password is incorrect. No changes have been made"])';
			} 
		}
		else
		{
			//There is an empty modifiable field
			echo '([0, "ERROR, The field cannot be left empty \'Name\' and/or \'Surname\'"])';
		}
        break;

    default:
        print_r($_POST);
        break;
}
?>