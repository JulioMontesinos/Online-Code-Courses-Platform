<?php

$mysqli = @new mysqli('localhost', 'root', '', 'courses');
if ($mysqli->connect_error)
{
	echo "Connection to the database has failed.";
	exit();
}
elseif(!$mysqli->set_charset("utf8"))
{
	echo "Charset=utf8 selection has failed.";
	exit();
}

function Query2JSON($SQL, $OBJ=false)
{
	GLOBAL $mysqli;  // Requires MySQLi connection.

	if(!($res = $mysqli->query($SQL)))
	{
		echo "<hr/><b>ERROR Query2JSON: ".$mysqli->errno."<br/>".$mysqli->error."<hr/>SQL: $SQL</b><hr/>";
		exit();
	}

	// Numeric or associative array.
	$modo=( ($OBJ===true || strtoupper($OBJ)=="OBJ" || strtoupper($OBJ)=="OBJECT")
		   ? MYSQLI_ASSOC : MYSQLI_NUM );

	// Initializes an empty array.
	$rows = array();

	while( ($row=$res->fetch_array($modo)) )
		array_push($rows, $row);
	return json_encode($rows, JSON_UNESCAPED_UNICODE);
}

function POST2EscapeString()
{
	GLOBAL $mysqli; // Requires MySQLi connection (global variable).

	foreach($_POST as $key=>$val)
	{
		GLOBAL $$key;
		$$key = $mysqli->real_escape_string($_POST[$key]);
	}
}
?>