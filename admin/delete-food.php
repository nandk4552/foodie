<?php
    include'partials/_dbconnect.php';
    // echo "Delete Food Page";

    if(isset($_GET['id']) && isset($_GET['image_name'])) {
        // Process to Delete      
        // echo "Process to Delete"; 

        // 1. get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. Remove the Image if available
        // Check whether the image is available or not and Delete only if available
        if($image_name != "") {
            // It has image and needed to remove from the folder
            // Get the image path
            $path = "../images/food/".$image_name;

            // Remove Image file from Folder
            $remove = unlink($path);

            // check whether the image is removed or not
            if($remove == false) {
                // Failed to remove Image
                $_SESSION['upload'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Failed to Remove Image File.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
                header('location:'.SITEURL.'admin/manage-food.php');
                // stop the process deleting food
                die();

            }

        }
        
        // 3. delete the food from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        // Execute the query
        $result = mysqli_query($conn, $sql);

        // check whether the query executed or not and set the session message respectively
        // 4. Redirect to Manage food with session message

        if($result == true) {
            // food deleted
            $_SESSION['delete'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Food Deleted Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location:'.SITEURL.'admin/manage-food.php');
        die();
        }
        else {
            // failed to delete food
        $_SESSION['delete'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to Delete Food.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location:'.SITEURL.'admin/manage-food.php');
        die();
        }
    }
    else{
        // Redirect to Manage Food Page
        // echo "Redirect";

        $_SESSION['unauthorize'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Unauthorized Access.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location:'.SITEURL.'admin/manage-food.php');
        die();
    }
