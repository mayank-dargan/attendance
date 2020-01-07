<?php
$servername = "sql300.epizy.com";
$username = "epiz_24310786";
$password = "bhMe7VRpWLbo";
//$username = "root";
//$password = "";
$dbName = "epiz_24310786_rssb";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
