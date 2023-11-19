<?php

include("../libs/mysql.php");

switch($_POST["OPC"])
{
    case "GET_COURSES_TABLE":
      $SQL = "SELECT E.Id_Edition, E.Name_Edition, E.Description, "
          ."(SELECT COUNT(m.Id_Student) from enrollment m where m.Id_Edition=E.Id_Edition and Enrollment_Status='Accepted'), E.Date "
          ."FROM edition E, impart I "
          ."WHERE E.Id_Edition = I.Id_Edition and I.responsible='1' and E.Status_Edition='Activated' ORDER BY E.Date DESC";
      echo Query2JSON($SQL);
      break;

    default:
        print_r($_POST);
        break;
}
?>