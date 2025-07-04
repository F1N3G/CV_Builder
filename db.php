<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'cv_builder';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}
?>
