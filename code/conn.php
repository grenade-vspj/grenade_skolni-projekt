<?php

session_start();
$servername = "localhost";
$username = "team1";
$password = "Team123*";
$dbname = "team1";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

//$conn = mysqli_connect($servername, $username, $password, $dbname);
 //mysqli_set_charset($conn, "utf8");


?>