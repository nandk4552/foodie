<?php
include('partials/_dbconnect.php');
include('partials/_header.php');
?>




<div class="container my-5">
    <div id="main-content">

        <div id="wrapper">
            <h1 class="text-center py-3">Update Category</h1>


            <?php
            // check whether the id is set or not
            if (isset($_GET['id'])) {
                // Get the ID and all other details
                // echo "Getting the data";
                $id = $_GET['id'];

                // Create SQL Query to get all other details
                $sql = "SELECT * FROM `tbl_category` WHERE `id` = $id";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // count the rows to check whether the ID is valid or not
                $count = mysqli_num_rows($result);

                if ($count == 1) {
                    // Get all the data
                    $row = mysqli_fetch_assoc($result);

                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    // Redirect the user with Session message
                    $_SESSION['no-category-found'] = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> category Not Found.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';

                    header("Location: " . SITEURL . "admin/manage-category.php");
                    die();
                }
            } else {
                // redirect to manage category page
                header("Location: " . SITEURL . "admin/manage-category.php");
                die();
            }

            ?>


            <form action="" class="was-validated" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title </label>
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>" aria-describedby="emailHelp">
                </div>



                <div class="mb-2 d-flex align-items-center">
                    <label for="exampleInputEmail1" class="form-label">Featured: </label>
                    <div class="form-check">

                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> class="form-check-input mx-1" name="featured" type="radio" value="Yes" id="featured">
                        <label class="form-check-label" for="featured">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> class="form-check-input mx-2" type="radio" name="featured" value="No" id="featured">
                        <label class="form-check-label" for="featured">
                            No
                        </label>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="exampleInputEmail1" class="form-label">Active: </label>
                    <div class="form-check">

                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> class="form-check-input mx-1" type="radio" name="active" value="Yes" id="active">
                        <label class="form-check-label" for="active">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> class="form-check-input mx-2" type="radio" name="active" value="No" id="active">
                        <label class="form-check-label" for="active">
                            No
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Current Image </label>
                    <div>
                        <?php
                        if ($current_image != "") {
                            // Display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="image Can't Preview right now" width="100px">
                        <?php
                        } else {
                            // Display the message
                            echo '<div class="text-danger">Image Not Added</div>';
                        }
                        ?>
                    </div>

                </div>



                <div class="mb-3">
                    <label for="image" class="form-label">Select New Image </label>
                    <input type="file" class="form-control" name="image" id="image" aria-label="file example">
                    <div class="invalid-feedback">Invalid Field</div>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="curren_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button class="btn btn-primary" type="submit" name="submit">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    //    echo "Clicked";
    // 1.Get all the data from form

    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // 2. Update New Image if Selected 
    // Check whether the image is selected or not
    if (isset($_FILES['image']['name'])) {
        // Get the Image Details
        $image_name = $_FILES['image']['name'];

        // check whether the image name is available or not
        if ($image_name != "") {
            // Image Available
            //A. Upload the new Image


            // Auto rename the image
            $ext = end(explode('.', $image_name));

            // Rename the image
            $image_name = "Food-Category-" . rand(0000, 9999) . '.' . $ext;


            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;

            // Finally upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            // check whether the image is uploaded or not
            // And if the image is not uploaded then we will stop the process redirect the user with error message
            if ($upload == false) {
                // Set sesssion message
                $_SESSION['upload'] = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Image Failed to Upload.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                // Redirect the user to manage category page
                header("Location: " . SITEURL . "admin/manage-category.php");
                exit;
            }

            //B. Remove the Current Image If available
            if ($current_image != "") {


                $remove_path = "../images/category/" . $current_image;
                $remove = unlink($remove_path);

                // Check whether the image is removed or not
                // If failed to remove then display message and stop the process
                if ($remove == false) {
                    // Failed to remove image
                    $_SESSION['failed-remove'] = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">   
                        <strong>Error!</strong> Failed to remove the current Image.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>   ';
                    header("location: " . SITEURL .  "admin/manage-category.php");
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    // 3. Update the Database
    $sql2 = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
            ";

    // Execute the Query 
    $result2 = mysqli_query($conn, $sql2);

    // 4. Redirect the user to Manage Category Page
    if ($result2 == true) {
        // Category Updated
        $_SESSION['update-category'] = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Category Updated Successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        header("Location: " . SITEURL . "admin/manage-category.php");
        exit;
    } else {
        // Failed to Update Category
        $_SESSION['update-category'] = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Failed to Update Category.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        header("Location: " . SITEURL . "admin/manage-category.php");
        exit;
    }
}
?>


<?php include('partials/_footer.php'); ?>