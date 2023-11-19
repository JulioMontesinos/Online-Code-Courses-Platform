<?php
session_start();
if(isset($_SESSION["ID"]))
	exit();

include("libs/mysql.php");
POST2EscapeString();

switch($_POST["OPP"])
{
    case "REGISTER":
        /*****************************/
        // Check if the user is not registered in the database. The email must be unique.
        $SentenciaSQL_User = "select Email from user where Email='$Email_R'";

        $res_User = $mysqli->query($SentenciaSQL_User);
        /*****************************/     
		$Name_R = trim($Name_R);
		$Email_R = trim($Email_R);
		$Pass_R   = trim($Pass_R);
		$Pass_R2  = trim($Pass_R2);
        // IF ANY FIELD IS EMPTY
        if((strcmp($Name_R, "") == 0) || (strcmp($Email_R,"") == 0) ||  (strcmp($Pass_R,"") == 0) || (strcmp($Pass_R2,"") == 0))
        {
            echo '([0, "Error, all fields must be filled in."])';
        }
        else if($res_User->num_rows > 0)
        { 
            echo '([0, "Error, the user is already registered."])';
        }
        else if(strcmp($Pass_R, $Pass_R2) != 0) // In case both passwords are not equal
        {
            echo '([0, "Error, both passwords must be the same."])';
        }   
		else
        {
			$SentenceSQL = "INSERT INTO user (Name, Surname, Rol, Password, Email) VALUES ('$Name_R','$Surname_R','Student',PASSWORD('$Pass_R'),'$Email_R')";
			$res = $mysqli->query($SentenceSQL);
			echo '([1])';			
		}        
        break;

    default:
        print_r($_POST);
        break;
}
