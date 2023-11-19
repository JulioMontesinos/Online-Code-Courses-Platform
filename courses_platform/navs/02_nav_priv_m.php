<?php
session_start();

include("../libs/mysql.php");

POST2EscapeString(); // If used, the variable name must be the same as the identifier of the view part.s

$Id_User = $_SESSION["ID"];

switch($_POST["OPC"])
{
    case "LOGOFF":

        $_SESSION["ID"] = NULL;
        $_SESSION["User"] = NULL;
        $_SESSION["Rol"] = NULL;
        $_SESSION["Name"] = NULL;

        unset($_SESSION);

        //session_destroy();  It has been commented out because we cannot delete all sessions, as we need one to determine whether the online code editor has been opened before or not.
        echo("LOGOFF");
        break;

    case "COMPROBAR_SESION":

        if($_SESSION["Rol"] == "Administrator")
        {
            echo("Administrator");
        }
        elseif($_SESSION["Rol"] == "Teacher")
        {
            echo("Teacher");
        }
        elseif($_SESSION["Rol"] == "Student")
        {
            echo("Student");
        }
    break;

    case "GET_COURSES":
        $SQL="SELECT E.Id_Edition, E.Name_Edition, E.Description, "
        ."(SELECT COUNT(m.Id_Student) from enrollment m where m.Id_Edition=E.Id_Edition and Enrollment_Status='Accepted'), "
        ."U.Name, E.Date "
        ."FROM edition E, impart I, user U "
        ."WHERE E.Id_Edition = I.Id_Edition and I.Id_Teacher = U.ID and I.responsible='1' and E.Status_Edition='Activated' ORDER BY E.Date DESC";
		echo Query2JSON($SQL);
		break;

    case "CHECK_ENROLLMENT": //To check if they are a student in that course.
        $SQL = "SELECT Enrollment_Status from enrollment where Id_Student='$Id_User' and Id_Edition='$Id_Edition'";
        echo Query2JSON($SQL);
        break;

    case "CHECK_TEACHES_COURSE": //To check if they are teacher in that course.
        $SQL = "SELECT Responsible from impart where Id_Teacher='$Id_User' and Id_Edition='$Id_Edition'";
        echo Query2JSON($SQL);
        break;

    case "CREATE_INSCRIPTION":
        $SQL = "INSERT INTO enrollment (Id_Student, Id_Edition, Enrollment_Status) VALUES ('$Id_User','$Id_Edition','Pendiente')";
        $res=$mysqli->query($SQL);
        break;

    default:
        print_r($_POST);
        break;
}
?>