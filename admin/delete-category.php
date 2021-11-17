<?php
    include 'partials/_dbconnect.php';
    // echo"Delete Page";

    // check whether the id and image_name value is set or not
    if(isset($_GET['id']) && isset($_GET['image_name'])) {
        // Get the value and Delete 
        // echo "Get value and Delete";

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the Physical image file is available
        if($image_name!="") {
            // Image is Available
            $path = "../images/category/".$image_name; 

            // Remove the Image 
            $remove = unlink($path);

            // if failed to remove image then add an error message and stop the process
            if($remove == false) {
                // Set the session Message
                session_start();
                $_SESSION['remove'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Failed to Remove category Image.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
                // Redirect to manage category page
                header("Location: ".SITEURL."admin/manage-category.php");
                // stop the process
                die();
            }
        }


        // Delete Data from Database 
        $sql = "DELETE FROM `tbl_category` WHERE `tbl_category`.`id` = $id";

        // execute the query 
        $result = mysqli_query($conn, $sql);

        // check whether the data is deleted from database or not

        if($result==true) {
            // set success message and redirect 
            session_start();
            $_SESSION['delete'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> Category Deleted Successfully.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';

            header("Location: ".SITEURL."admin/manage-category.php");
        }
        else {
            // set fail message and redirect the user
            session_start();
            $_SESSION['delete'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>warning!</strong> Failed to Delete Category.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';

            header("Location: ".SITEURL."admin/manage-category.php");
            
        }

    }
    else {
        // redirect to manage category page
        header("Location: ".SITEURL."admin/manage-category.php");
        exit;
    }
