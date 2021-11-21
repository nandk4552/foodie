<?php
include('partials-front/_header.php');
?>
<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php

        // Get the search keyword
        $search = $_POST['search'];

        ?>
        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

    </div>
</section>

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu" style="min-height: 100vh;">
    <div class="container">

        <h2 class="text-center">Food Menu</h2>

        <?php
        // SQL query to Get foods based on search keyword
        $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR '%$search%'";

        // Execute the query 
        $result = mysqli_query($conn, $sql);

        // count rows
        $count = mysqli_num_rows($result);

        // check whether food availabe or not

        if ($count > 0) {
            // food available
            while ($row = mysqli_fetch_assoc($result)) {
                // get the details
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
        ?>
                <div class="food-menu-box " style="box-shadow: 0 .5rem 1rem rgba(0,0,0,0.3);">
                    <div class="food-menu-img">
                        <?php
                        // check whether image name is available or not
                        if ($image_name == "") {
                            // Image not available
                            echo '<div class="text-danger">Image Not Available</div>';
                        } else {
                            // Image Available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                        <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <a href="#" class="btn btn-primary">Order Now</a>
                    </div>
                </div>


        <?php
            }
        } else {
            // food not available
            echo '<div class="text-danger">Food not found</div>';
        }

        ?>


    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->


<div class="clearfix"></div>



</div>

</section>
<!-- fOOD Menu Section Ends Here -->
<?php
include('partials-front/_footer.php');
?>