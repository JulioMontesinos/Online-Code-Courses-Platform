<?php

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION) || count($_SESSION)==0)
    exit();
if($_SESSION["Rol"] != "Administrator" && $_SESSION["Rol"] != "Student" && $_SESSION["Rol"] != "Teacher")
    exit();
?>