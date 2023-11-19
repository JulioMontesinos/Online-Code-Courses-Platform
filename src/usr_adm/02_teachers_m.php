<?php
session_start();
if(!isset($_SESSION["Rol"]) || $_SESSION["Rol"]!="Administrator")
	exit();

include("../libs/mysql.php");

POST2EscapeString(); //If used, the variable name must match the identifier of the view section.

switch($_POST["OPC"]){
    
    case "GET_DATA_TEACHERS":
        $SentenceSQL = "select ID, ID, Name, Surname, Rol, Email from user where Rol='Teacher' ORDER BY Name ASC";
        echo Query2JSON($SentenceSQL);
        break;

    case "GET_DATA_TEACHER":
        $SentenceSQL = "select ID, Name, Surname, Rol, Email from user where Rol='Teacher' and ID='$ID_profesor'";
        echo Query2JSON($SentenceSQL);
		    break;

    case "EDIT_TEACHER":

          if(strcmp($teacher_new_pass,"") == 0)
          {//In case the New Password is empty and the user does not want to change it.
            $SentenceSQL = "UPDATE user SET Name='$profesor_nombre', Surname='$profesor_apellidos' WHERE ID='$profesor_id'";
            $res = $mysqli->query($SentenceSQL);
            $_SESSION["Name"] = $profesor_nombre;
            echo '([1])';
          }
          else
          {
            $SentenceSQL = "UPDATE user SET Name='$profesor_nombre', Surname='$profesor_apellidos', Password=PASSWORD('$teacher_new_pass') WHERE ID='$profesor_id'";
            $res = $mysqli->query($SentenceSQL);
            $_SESSION["Name"] = $profesor_nombre;
            echo '([1])';
          }
          break;

    case "DELETE_TEACHER":
        $SentenceSQL_delete = "DELETE FROM user WHERE Rol='Teacher' and ID='$ID_profesor'";
        $res_delete = $mysqli->query($SentenceSQL_delete);
		    break;

    case "IS_RESPONSIBLE":
      $SQL = "SELECT u.ID FROM user u, impart i WHERE (u.Rol='Teacher' or u.Rol='Administrator') and u.ID = i.Id_Teacher and u.ID='$ID_profesor' and i.Responsible='1'";
      $res = $mysqli->query($SQL);

      if($res->num_rows >=1)
        echo "1";
      else
        echo "0";
      
      break;

    case "NEW_TEACHER":

        //Comprobaremos si el user no está registrado en la bbdd. Debe ser único el correo electronico.
        $SentenciaSQL_User = "select Email from user where Email='$profesor_email'";
        $res_User = $mysqli->query($SentenciaSQL_User);
        
        if($res_User->num_rows > 0){ 
          echo '([0, "ERROR, The user is already registered."])';
        
        }else{
          $SentenceSQL = "INSERT INTO user (ID, Name, Surname, Rol, Password, Email) VALUES (NULL, '$profesor_nombre','$profesor_apellidos','Teacher',PASSWORD('$teacher_new_pass'),'$profesor_email')";
          $res = $mysqli->query($SentenceSQL);
          echo '([1])';
        }

		    break;

    default:
        print_r($_POST);
		    break;
}

?>