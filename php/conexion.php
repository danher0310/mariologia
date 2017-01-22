<?php
ini_set('display_errors', 1);//visualizacion de errores
$host   = "localhost";
$user   = "root";
$pass   = 'clon.21079951';
$db     = 'malariologia';
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
	echo "Error: ".$mysqli->connect_error;
}

?>