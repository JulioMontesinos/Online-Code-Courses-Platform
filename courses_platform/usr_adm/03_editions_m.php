<?php
session_start();
if(!isset($_SESSION["Rol"]) || $_SESSION["Rol"]!="Administrator")
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must match the identifier of the view part

switch($_POST["OPC"]){
	
	case "GET_DATA_EDITIONS":
		$SQL="SELECT E.Id_Edition, E.Id_Edition, E.Date, E.Name_Edition, E.Status_Edition, U.Name "
			."FROM edition E, impart I, user U "
			."WHERE E.Id_Edition = I.Id_Edition and I.Id_Teacher = U.ID and I.responsible=1 ORDER BY E.Name_Edition ASC";
		echo Query2JSON($SQL);
		break;

	case "GET_DATA_EDITION":
		$SQL="SELECT E.Id_Edition, E.Date, E.Name_Edition, E.Status_Edition, I.Id_Teacher "
			."FROM edition E, impart I "
			."WHERE E.Id_Edition = '$Id_Edition' and E.Id_Edition = I.Id_Edition and I.responsible=1";
		echo Query2JSON($SQL);
		break;

	case "GET_LIST_TEACHERS":
		$SQL="SELECT ID, CONCAT(Name, ' (', Email, ')') from user WHERE Rol='Teacher' or Rol='Administrator' ORDER BY Name";
		echo Query2JSON($SQL);
		break;

	case "GET_LIST_COURSES":
		$SQL="SELECT Id_Course, Name_Course from course ORDER BY Name_Course";
		echo Query2JSON($SQL);
		break;

	case "EDIT_EDITION":

			$SQL="UPDATE edition "
				."SET Date='$edicion_fecha', Name_Edition='$edicion_nombre', Status_Edition='$edicion_estado' "
				."WHERE Id_Edition='$edicion_id'";
			$res=$mysqli->query($SQL);

			if($select_edition_teacher != $edicion_id_profesor)
			{
				$SQL="DELETE FROM impart WHERE Id_Edition='$edicion_id'; "
					."INSERT INTO impart (Id_Teacher, Id_Edition, Responsible) "
					."VALUES ('$select_edition_teacher','$edicion_id', 1)";
				$res=$mysqli->multi_query($SQL);
			}

		echo '([1])';  
		break;
	
	case "DELETE_EDITION":
		$SQL_eliminar = "DELETE FROM edition WHERE Id_Edition='$Id_Edition'";
		$res_delete = $mysqli->query($SQL_eliminar);
		break;

	case "NEW_EDITION":
		//In case any field is empty,
		//we will check if the edition is recorded in the database. The edition name must be unique.	
		$SQL = "select Name_Edition from edition where Name_Edition='$edicion_nombre'";
		$res = $mysqli->query($SQL);

		if($res->num_rows > 0){ 
			echo '([0, "ERROR, El user ya está registrado."])';
		
		}else{
			//THE EDITION IS CREATED:
			$SQL="INSERT INTO edition (Id_Edition, Date, Id_Course, Name_Edition, Status_Edition, Description) VALUES (NULL, '$edicion_fecha','$select_edition_course','$edicion_nombre','$edicion_estado','')";
			$res=$mysqli->query($SQL);

			//CREATING THE TEACHER'S RELATIONSHIP WITH THE EDITION
			//To do this, we need to obtain the ID of the new edition created earlier.

			$SQL="select Id_Edition from edition "
				."where Name_Edition='$edicion_nombre' and Date='$edicion_fecha' and Id_Course='$select_edition_course'"; //I include multiple fields to avoid any coincidence with another edition, as none of those fields are unique.
			$res = $mysqli->query($SQL);

			$mi_array = array();

			while( ($row=$res->fetch_array()) ) //To populate the $rows array with the IDs of the editions.
				array_push($mi_array, $row);

			//The value of the query ID will be $my_array[0][0] because there is only 1 record.
			$Id_Edition_nueva = $mi_array[0][0];

			$SQL = "INSERT INTO impart (Id_Teacher, Id_Edition, responsible) VALUES ('$select_edition_teacher','$Id_Edition_nueva', 1)";
			$res = $mysqli->query($SQL);

			echo '([1])';
		}
		break;

	default:
		print_r($_POST);
		break;
}

?>