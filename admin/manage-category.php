<?php
include('partials/_dbconnect.php');
include('partials/_header.php');

?>


<?php
// if success to add category show message 
if (isset($_SESSION['add-category'])) {
    // Displaying message
    echo $_SESSION['add-category'];
    // removing after showing message once
    unset($_SESSION['add-category']);
}
if (isset($_SESSION['remove'])) {
    // Displaying message
    echo $_SESSION['remove'];
    // removing after showing message once
    unset($_SESSION['remove']);
}
if (isset($_SESSION['delete'])) {
    // Displaying message
    echo $_SESSION['delete'];
    // removing after showing message once
    unset($_SESSION['delete']);
}
if (isset($_SESSION['no-category-found'])) {
    // Displaying message
    echo $_SESSION['no-category-found'];
    // removing after showing message once
    unset($_SESSION['no-category-found']);
}
if (isset($_SESSION['update-category'])) {
    // Displaying message
    echo $_SESSION['update-category'];
    // removing after showing message once
    unset($_SESSION['update-category']);
}

?>


<div class="container mt-5 py-5">
    <h1 class="text-center">Manage Category</h1>
    <div id="main-content" class="py-3">
        <div id="wrapper">


            <!-- add category section starts -->
            <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn btn-primary btn-sm">Add Category</a>

            <table class="tbl-full my-2">
                <tr>
                    <th>sno</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php
                // Query to get all category from database 
                $sql = "SELECT * FROM `tbl_category`";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Count the rows
                $count = mysqli_num_rows($result);

                // Create serial number variable
                $sno=0;


                // Check whether we have data in database or not
                if ($count > 0) {
                    // we have data in database
                    // get the data and display
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        $sno++;
                    ?>
                        <tr>
                            <td><?php echo $sno?>.</td>
                            <td><?php echo $title?></td>

                            
                            <td>
                                <?php
                                    // check whether image name is available or not
                                    if($image_name!="")  {
                                        // Display the image
                                        ?>

                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name?>" alt="" width="100px">
                                       
                                       <?php
                                    }
                                    else {
                                        // Display the message
                                        echo '
                                        <div class="text-danger">
                                         Image Not Added
                                      </div>
                                            ';
                                    }
                                ?>
                            </td>


                            <td><?php echo $featured?></td>
                            <td><?php echo $active?></td>
                            <td>
                                <a  href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Update Category</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name;?>" class="btn btn-danger btn-sm">Delete Category</a>
                            </td>
                        </tr>
                        <?php

                    
                    }
                } else {
                    // we donot have data
                    // We'll display message inside table
                    ?>

                    <tr>
                        <td>
                            <div class="text-danger" role="alert">
                                 No Category Added
                            </div>
                        </td>
                    </tr>

                <?php


                }

                ?>


            </table>


            <!-- add category section ends -->





        </div>
    </div>
</div>


<?php
include('partials/_footer.php');
?>