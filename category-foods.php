<?php
include('partials-front/_header.php');
?>

<?php
// check whether the id is passed or not
if (isset($_GET['category_id'])) {
    // category id is set and get the id
    $category_id = $_GET['category_id'];
    // get the category title based on category id
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

    // Execute the query 
    $result = mysqli_query($conn, $sql);

    // Get the value from Database
    $row = mysqli_fetch_assoc($result);

    // get the title based on category id
    $category_title = $row['title'];
} else {
    // category not passed
    // Redirect to home page
    header('location:' . SITEURL);
}
?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Create SQl query to Get foods based on selected category
        $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

        // Execute the query 
        $result2 = mysqli_query($conn, $sql2);

        // count the rows
        $count2 = mysqli_num_rows($result2);

        // chech whether food is available or not
        if ($count2 > 0) {
            // food is available
            while ($row2 = mysqli_fetch_assoc($result2)) {

                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];
        ?>

                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        // check whether image is available or not
                        if ($image_name == "") {
                            // Image Not Available
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

                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>

        <?php
            }
        } else {
            // food not available
            echo '<div class="text-danger">Food Not Available</div>';
        }


        ?>



        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->
<?php
include('partials-front/_footer.php');
?>