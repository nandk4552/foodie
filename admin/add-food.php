<?php
include('partials/_dbconnect.php');
include('partials/_header.php');
?>

<?php
if (isset($_SESSION['upload'])) {
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
}
?>


<div class="container my-5">
    <div id="main-content" class="shadow-lg zindex-2">

        <div id="wrapper">
            <h1 class="text-center py-3">Add Food</h1>

            <form action="" class="was-validated" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title </label>
                    <input type="text" placeholder="Title of the food" class="form-control" name="title" id="title" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea placeholder="Description of the food" class="form-control" name="description" id="description"></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input placeholder="Description of the food" type="number" class="form-control" name="price" id="price">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Select Image </label>
                    <input type="file" class="form-control" name="image" id="image" aria-label="file example">
                    <div class="invalid-feedback">Invalid Field</div>
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Category</label>
                    <select class="form-select" name="category" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <?php
                        // Create PHP Code to Display Categories from database
                        // 1. Create a SQL query to get all active categories from database
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                        // Execute the query 
                        $result = mysqli_query($conn, $sql);

                        // Count Rows to check whether we have categories
                        $count = mysqli_num_rows($result);

                        // If count is greater than zero we have categories else we don't have categories 
                        if ($count > 0) {
                            // We have categories
                            while ($row = mysqli_fetch_assoc($result)) {
                                // get the details of categories
                                $id = $row['id'];
                                $title = $row['title'];
                        ?>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                            <?php
                            }
                        } else {
                            // We don't have categories
                            ?>
                            <option value="0">No Category Food</option>

                        <?php
                        }


                        // 2. Display on Dropdown

                        ?>
                        <!-- <option value="1">Food</option>
                        <option value="2">Snack</option> -->
                    </select>
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
                    <button class="btn btn-primary" type="submit" name="submit">Add Food</button>
                </div>
            </form>

            <?php
            // check whether the button is clicked or not
            if (isset($_POST['submit'])) {
                // add the food in database
                // echo"Clicked!";

                // 1. get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                // check whether the radio button for featured and active are checked or not
                if (isset($_POST['featured'])) {
                    $featured = $_POST['featured'];
                } else {
                    // Setting the default value
                    $featured = "No";
                }
                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    // Setting the default value
                    $active = "No";
                }

                // 2. upload the image if selected 
                // check whether the select image button is clicked or not and upload the image only if selected 
                if (isset($_FILES['image']['name'])) {
                    // get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // check whether the image is selected or not and upload only if selected
                    if ($image_name != "") {
                        // Image is selected 
                        // A. Rename the image

                        // get the extension of the selected image
                        $ext = end(explode('.', $image_name));

                        // Create New Name for Image
                        $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;

                        // B. Upload the image

                        // Get the Src Path and Destination Path

                        // Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        // Destination Path for the image to be uploaded
                        $dst = "../images/food/" . $image_name;

                        // Finally Upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        // check whether the image is uploaded or not
                        if ($upload == false) {
                            //Failed  to upload the image
                            // Redirect to Add Food Page with Error Message
                            $_SESSION['upload'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Failed to Upload Image.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                            header('location:' . SITEURL . 'admin/add-food.php');
                            // Stop the process
                            die();
                        }
                    }
                } else {
                    // Setting default as blank
                    $image_name = "";
                }


                // 3. Insert into Database
                // create sql query to save or Add food

                $sql2 = "INSERT INTO `tbl_food` (`title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES ('$title', '$description', '$price', '$image_name', '$category', '$featured', '$active')";
                // Execute the query 
                $result2 = mysqli_query($conn, $sql2);

                // check whether the data is inserted or not
                // 4. Redirect with message to Manage Food

                if ($result2 == true) {
                    // data inserted successfully
                    $_SESSION['add'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Food Added Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    die();
                } else {
                    // failed to insert data
                    $_SESSION['add'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Failed to Add Food.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    die();
                }
            }
            ?>



        </div>
    </div>
</div>




<?php
include('partials/_footer.php');
?>