<?php
$servername = "localhost";
$username = "focus";
$password = "paginaia2407";
$dbname = "tfg";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}