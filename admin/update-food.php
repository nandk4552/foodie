<?php
include('partials/_dbconnect.php');
include('partials/_header.php');
?>

<?php
// check whether the id is set or not
if (isset($_GET['id'])) {
    // get all the details
    $id = $_GET['id'];

    // sql query to get the selected food 
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    // Execute the query 
    $result2 = mysqli_query($conn, $sql2);

    // get the value based on query executed 
    $row2 = mysqli_fetch_assoc($result2);

    // get the individual values of selected food 
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    // Redirect to Manage Food
    header('location:' . SITEURL . 'admin/manage-food.php');
    die();
}
?>


<div class="container my-5">
    <div id="main-content" class="zindex-2" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,0.3);">

        <div id="wrapper">
            <h1 class="text-center py-3">Update Food</h1>

            <form action="" class="was-validated" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title </label>
                    <input type="text" value="<?php echo $title; ?>" class="form-control" value="" name="title" id="title" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea placeholder="Description of the food" class="form-control" name="description" id="description"><?php echo $description; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input value="<?php echo $price; ?>" type="number" class="form-control" name="price" id="price">
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <label class="form-label mb-0">Current Image: </label>
                    <div class="ms-5">
                        <?php
                        if ($current_image == "") {
                            // image not available
                            echo '<div class="text-danger">Image not Available</div>';
                        } else {
                            // image available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }

                        ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Select New Image </label>
                    <input type="file" class="form-control" name="image" id="image" aria-label="file example">
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
                            //  categories available
                            while ($row = mysqli_fetch_assoc($result)) {
                                // get the details of categories
                                $category_title = $row['title'];
                                $category_id = $row['id'];
                        ?>
                                <option <?php if ($current_category == $category_id) {
                                            echo 'selected';
                                        } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                            <?php
                            }
                        } else {
                            //  categories not available
                            ?>
                            <option value="0">Category Not Available</option>

                        <?php
                        }


                        // 2. Display on Dropdown

                        ?>
                    </select>
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
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <button class="btn btn-primary" type="submit" name="submit">Add Food</button>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                // echo " Button Clicked!";

                // 1. Get all the details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $description = $_POST['description'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Upload the image if selected
                if (isset($_FILES['image']['name'])) {
                    // Upload button clicked 
                    // New Image Name 
                    $image_name = $_FILES['image']['name'];

                    // check whether the file is available or not
                    if ($image_name != "") {
                        // image is available 
                        // A. Uploading New Image

                        // Rename the image
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext;

                        // get the src path and destination path
                        // source path
                        $src_path = $_FILES['image']['tmp_name'];
                        // destination path
                        $dest_path = "../images/food/" . $image_name;

                        // upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // check whether the image is uploaded or not
                        if ($upload == false) {
                            // Failed to upload
                            $_SESSION['upload'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>Failed to upload new Image.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                            //   redirect to manage food 
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            die();
                        }
                        // 3.Remove the image if new image is uploaded and current image exists

                        // B. Remove current Image if available
                        if ($current_image != "") {
                            // Current Image is Available
                            // remove the image 
                            $remove_path = "../images/food/" . $current_image;

                            $remove = unlink($remove_path);

                            // check whether the image is removed or not
                            if ($remove == false) {
                                // failed to remove current Image
                                $_SESSION['remove-failed'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Failed to remove current image.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';

                                //   redirect to manage food
                                header('location:' . SITEURL . 'admin/manage-food.php');
                                die();
                            }
                        }
                    }
                }
                else {
                    print_r($current_image);

                    // $image_name = $current_image;
                }


                // 4. Update the Food in Database
                $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id=$id
                ";

                // execute the sql query
                $result3 = mysqli_query($conn, $sql3);

                // check whether the query is executed or not
                // Redirect to Manage Food with Session message
                if($result3 == true) {
                    // query executed and food updated
                    $_SESSION['update'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Food Updated Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  header('location:'.SITEURL.'admin/manage-food.php');
                  die();
                }
                else {
                    // Failed to Update food
                    $_SESSION['update'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Failed to update food.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  header('location:'.SITEURL.'admin/manage-food.php');
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