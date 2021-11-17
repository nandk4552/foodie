<?php
// Database Connection
include 'partials/_dbconnect.php';

// 1. get the ID of the admin to be deleted
$id = $_GET['id'];

// 2. Create SQL Query to Delete Admin
$sql = "DELETE FROM `tbl_admin` WHERE `tbl_admin`.`id` = $id";

// execute the query 
$result = mysqli_query($conn, $sql);

// Checking whether the query is executed or not
if ($result) {
    // Query is Executed and Deleted succesfully
    // echo "Deleted Succefully";

    // create a Session variable to display Message 
    $_SESSION['delete'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> Admin Deleted Succefully
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
    // Redirecting to Manage admin page
    header("location: " . SITEURL .  'admin/manage-admin.php');
} else {
    // Failed to Delete Admin
    // echo "Not Deleted! ";

    // create a Session variable to display Message 
    $_SESSION['delete'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Warning!</strong> Failed to Delete Admin , Try Again Later.     
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
    // Redirecting to Manage admin page
    header("location: " . SITEURL .  'admin/manage-admin.php');
}

    // 3. Redirect to Manage Admin Page with message (success/error)