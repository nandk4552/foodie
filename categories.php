<?php
include('partials-front/_header.php');
?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Display all the categories that are active
        // Sql query
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        // count the rows
        $count = mysqli_num_rows($result);

        // check whether categories available or not
        if ($count > 0) {
            // categories available
            while ($row = mysqli_fetch_assoc($result)) {
                // get the values
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>

                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        if ($image_name == "") {
                            // image not available
                            echo '<div class="text-danger"> Image Not Found</div>';
                        } else {
                            // image available and display it
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                        <?php
                        }
                        ?>


                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }
        } else {
            // categories not available
            echo '<div class="text-danger"> Category Not Found!</div>';
        }
        ?>




        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->
<?php
include('partials-front/_footer.php');
?>