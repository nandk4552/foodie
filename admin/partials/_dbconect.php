<?php

// Start Session
session_start();


// Script to connect to the database
define('SITEURL', 'http://localhost/rcw/');


// creating connection
$servername = "localhost";
$username = "root";
$password = '$K!$h0r9007';
$database = "food-order";

$conn = mysqli_connect($servername, $username, $password, $database);
