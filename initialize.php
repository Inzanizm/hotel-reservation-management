<?php 
session_start();

$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "hotel_db";

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

return $connection;
?>