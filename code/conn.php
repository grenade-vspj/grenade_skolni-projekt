<?php

session_start();
$servername = "localhost";
$username = "team1";
$password = "Team123*";
$dbname = "team1";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die('Nepodařilo se připojit k MySQL serveru (' . $conn->connect_errno . ') '
        . $conn->connect_error);
}
//echo 'Připojení proběhlo úspěšně ' . $conn->host_info . "\n";


?>