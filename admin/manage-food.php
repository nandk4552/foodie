<?php
include('partials/_header.php');
?>

<?php
if (isset($_SESSION['add'])) {
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
?>

<div class="container mt-5 py-5">
    <h1 class="text-center">Manage Food</h1>
    <div id="main-content" class="py-3 shadow-lg ">
        <div id="wrapper">

            <!-- add category section starts -->
            <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn btn-primary btn-sm my-3">Add Food</a>

            <table class="tbl-full my-3 table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Sno</th>
                        <th scope="col">Title</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th scope="col">Featured</th>
                        <th scope="col">Active</th>
                        <th scope="col">Actions</th>
                    </tr>

                </thead>

                <?php
                // create sql query to get all the food
                $sql = "SELECT * FROM tbl_food";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Count the rows to check whether we have food or not
                $count = mysqli_num_rows($result);
                // Create serial number variable
                $sno = 1;

                if ($count > 0) {
                    //  We have food in Database
                    // Get the Foods from Database and Display
                    while ($row = mysqli_fetch_assoc($result)) {
                        // get the values from Individual columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                ?>
                        <tbody>
                            <tr>
                                <td scope="row"><?php echo $sno++; ?>.</td>
                                <td><?php echo $title; ?></td>
                                <td>$ <?php echo $price; ?></td>
                                <td>
                                    <?php
                                    // Check whether the we have image or not
                                    if ($image_name == "") {
                                        // We donot have image Display Error Message
                                        echo "<div class='text-danger'>Image Not Added</div>";
                                    } else {
                                        // we have Image,Display Image
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Image can't Preview right now..." width="100px">

                                    <?php

                                    }

                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Update Food</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger btn-sm">Delete Food</a>
                                </td>

                            </tr>
                        </tbody>


                <?php
                    }
                } else {
                    // Food not Added in Database
                    echo "<tr>
                            <td colspan='7' class='text-danger'>Food not Added Yet.</td>
                          </tr>";
                }


                ?>


            </table>

        </div>
    </div>
</div>



<?php
include('partials/_footer.php');
?>