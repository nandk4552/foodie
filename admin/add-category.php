<?php
include('partials/_dbconnect.php');
include('partials/_header.php');
?>

<?php
// when ever failed to add category display this below message
if (isset($_SESSION['add-category'])) {
    // Display the message
    echo $_SESSION['add-category'];
    // remove the message after showing once 
    unset($_SESSION['add-category']);
}
if (isset($_SESSION['upload'])) {
    // Display the message
    echo $_SESSION['upload'];
    // remove the message after showing once 
    unset($_SESSION['upload']);
}
?>

<div class="container my-5">
    <div id="main-content">

        <div id="wrapper">
            <h1 class="text-center py-3">Add Category</h1>

            <form action="" class="was-validated" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title </label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
                </div>



                <div class="mb-2 d-flex align-items-center">
                    <label for="exampleInputEmail1" class="form-label">Featured: </label>
                    <div class="form-check">

                        <input class="form-check-input mx-1" name="featured" type="radio" value="Yes" id="featured">
                        <label class="form-check-label" for="featured">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input mx-2" type="radio" name="featured" value="No" id="featured" checked>
                        <label class="form-check-label" for="featured">
                            No
                        </label>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="exampleInputEmail1" class="form-label">Active: </label>
                    <div class="form-check">

                        <input class="form-check-input mx-1" type="radio" name="active" value="Yes" id="active">
                        <label class="form-check-label" for="active">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input mx-2" type="radio" name="active" value="No" id="active" checked>
                        <label class="form-check-label" for="active">
                            No
                        </label>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="image" class="form-label">Select Image </label>
                    <input type="file" class="form-control" name="image" id="image" aria-label="file example">
                    <div class="invalid-feedback">Invalid Field</div>
                </div>

                <div class="mb-3">
                    <button class="btn btn-primary" type="submit" name="submit">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
//Check whether the button is clicked or not
if (isset($_POST['submit'])) {
    // echo " Clicked";

    // 1.Get the data from Category Form
    $title = $_POST['title'];

    // For featured radio input , we need to check whether the button is selected or not
    if (isset($_POST['featured'])) {
        // Get the value from form 
        $featured = $_POST['featured'];
    } else {
        // Set the default value
        $featured = "No";
    }

    // For active radio input , we need to check whether the button is selected or not
    if (isset($_POST['active'])) {
        // Get the value from form 
        $active = $_POST['active'];
    } else {
        // Set the default value
        $active = "No";
    }

    // check whether the image is selected or not and set the value for image name accordingly
    // print_r($_FILES['image']);
    // die();

    if (isset($_FILES['image']['name'])) {
        // Upload the image
        // To Upload Image we need the image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        // Upload the image only if image is selected 
        if ($image_name != "") {



            // Auto rename the image
            $ext = end(explode('.', $image_name));

            // Rename the image
            $image_name = "Food_Category_" . rand(0000, 9999) . '.' . $ext;


            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;

            // Finally upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            // check whether the image is uploaded or not
            // And if the image is not uploaded then we will stop the process redirect the user with error message
            if ($upload == false) {
                // Set sesssion message
                session_start();
                $_SESSION['upload'] = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Image Failed to Upload.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                // Redirect the user to add category page
                header("Location: " . SITEURL . "admin/add-category.php");
                exit;
            }
        }
    } else {
        // Don't upload the image and set the image_name value as blank
        $image_name = "";
    }

    // 2.Create a SQL query to insert Category into Database
    $sql = "INSERT INTO `tbl_category` (`title`, `image_name`, `featured`, `active`) VALUES ('$title', '$image_name', '$featured', '$active')";


    // 3. Execute the Query and Save the data into database
    $result = mysqli_query($conn, $sql);

    // 4. Check whether the query executed or not and data added or not

    if ($result == true) {
        //query executed and Category added   
        session_start();
        $_SESSION['add-category'] = '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Category Added Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';

        // redirect the user to manage category page
        // header("Location: " . SITEURL . "admin/manage-category.php");
        header("location: " . SITEURL .  'admin/manage-category.php');
        exit;
    } else {
        // Failed to add Category
        session_start();
        $_SESSION['add-category'] = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Failed to Add Category.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';

        // redirect the user to add category page
        header("Location: " . SITEURL . "admin/add-category.php");
        exit;
    }
}

?>



<?php
include('partials/_footer.php');
?>