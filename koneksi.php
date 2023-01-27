<?php 

$hostname = "localhost";
$username = "root";
$database = "spk_pkh";
$password = "";

$conn = mysqli_connect($hostname, $username, $password, $database);

if(!$conn) {
    die("<script>alert('Connection Failed.')</script>");
} 