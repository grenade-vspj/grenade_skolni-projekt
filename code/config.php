<?php
session_start();

date_default_timezone_set("Europe/Prague");

$servername = "localhost";
$username = "team1";
$password = "Team123*";
$dbname = "team1";
$con = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($con, "utf8");

if ($conn->connect_error) {
	die("Chyba pri pripojeni k databazi: " . $conn->connect_error);
}
?>