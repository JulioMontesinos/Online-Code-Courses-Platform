<?php
session_start();
if(!isset($_SESSION["Rol"]) || $_SESSION["Rol"]!="Administrator")
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must match the identifier of the view section.

switch($_POST["OPC"]){
    
    case "GET_DATA_COURSES":
        $SentenceSQL = "select Id_Course, Id_Course, Name_Course from course ORDER BY Name_Course ASC";
        echo Query2JSON($SentenceSQL);
        break;

    case "GET_DATA_COURSE":
        $SentenceSQL = "select Id_Course, Name_Course from course where Id_Course='$Id_Course'";
        echo Query2JSON($SentenceSQL);
		break;

    case "EDIT_COURSE":

             //It is necessary to check that, in the case of editing the course name, the new name is not previously registered in the database.
            $SentenciaSQL_Comprobar = "select Id_Course from course where Name_Course='$course_name'";
            $res_comprobar = $mysqli->query($SentenciaSQL_Comprobar);

            if($res_comprobar->num_rows > 0)
            { 
                echo '([0, "ERROR, The course name already exists. No changes have been made."])';
            }
            else
            {
                $SentenceSQL = "UPDATE course SET Name_Course='$course_name' WHERE Id_Course='$course_id'";
                $res = $mysqli->query($SentenceSQL);
                echo '([1])';
            }

        break;

    case "DELETE_COURSE":

       //A COURSE CANNOT BE DELETED IF THERE IS AN ASSOCIATED EDITION TO THAT COURSE.
        $SentenciaSQL_Comprobar_existe_edicion = "select Id_Edition from edition where Id_Course='$Id_Course'";
        $res_comprobar = $mysqli->query($SentenciaSQL_Comprobar_existe_edicion);

        if($res_comprobar->num_rows > 0)
        { //In this case, there is an associated edition with this course, so it cannot be deleted.
            echo "0";
        
        }
        else
        { //In this case, there is no associated edition with this course.
            $SentenceSQL_delete = "DELETE FROM course WHERE Id_Course='$Id_Course'";
            $res_delete = $mysqli->query($SentenceSQL_delete);
        }
		break;

    case "NEW_COURSE":
       //We will check if the course is not registered in the database. The name must be unique.
        $SentenciaSQL_Curso = "select Id_Course from course where Name_Course='$course_name'";
        $res_num_curso = $mysqli->query($SentenciaSQL_Curso);

        if($res_num_curso->num_rows > 0)
        {   
            echo '([0, "ERROR, The course is already registered."])';
        }
        else
        {
            $SentenceSQL = "INSERT INTO course (Name_Course) VALUES ('$course_name')";
            $res = $mysqli->query($SentenceSQL);
            echo '([1])';
        }
		break;

    default:
        print_r($_POST);
		break;
}

?>