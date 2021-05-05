<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="assesment";


// Creating connection
$conn = new mysqli($servername, $username, $password,$dbname);


// Checking connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$conn->select_db("assesment");

?>
