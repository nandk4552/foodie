<?php
    // Database Connection as well
    include('partials/_dbconnect.php');

    // 1. Destroy the session
    session_destroy(); // unsets $_SESSION['user'];


    
    //  2. Redirect to login page
    header('location: '.SITEURL.'admin/login.php');

?>