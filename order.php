<?php
include('partials-front/_header.php');
?>


<?php
// check whether food id is set or not
if (isset($_GET['food_id'])) {
    // Get the food id and details of the selected food
    $food_id = $_GET['food_id'];

    // get the details of selected food 
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // count the rows
    $count = mysqli_num_rows($result);

    // check whether the data is available or not
    if ($count == 1) {
        // we have data
        // Get the data from database
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
    } else {
        // food not available
        // redirect the user to homepage
        header('location:' . SITEURL);
    }
} else {
    // redirect the user to Homepage
    header('location:' . SITEURL);
}
?>
<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="post" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    //check whether image is available or not
                    if ($image_name == "") {
                        // Image not available
                        echo '<div class="text-danger">Image Not Available</div>';
                    } else {
                        // Image  available
                    ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                    <?php

                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title;?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price;?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" length="10" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
            // check whether submit button is clicked or not
            if(isset($_POST['submit'])) {
                // get all the details from the form
                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty  = $_POST['qty'];
                $total = ($price * $qty);
                echo $total; // total price = price * quantity
                // $order_date = date("Y-m-d h:i:sa"); // order date

                $status = "ordered"; // ordered , On delivery, Delivered and cancelled
                
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];


                // save the order in Database
                // create sql query to save data
                
                $sql2 = "INSERT INTO `tbl_order` (`id`, `food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) VALUES (NULL, '$food', '$price', '$qty', '$total', current_timestamp(), '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address')";
            
                // echo $sql2;die();

                // Execute the query
                $result2 = mysqli_query($conn, $sql2);

                // check whether query executed succesfully or not or not
                if($result2==true) {
                    //query executed and order Saved
                    $_SESSION['order'] = '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert ">
                    <strong>Success!</strong> Food Ordered Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  header('location:'.SITEURL);
                }
                else {
                    // query failed and order failed
                    $_SESSION['order'] = '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong>Error!</strong> Failed to Order Food.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  header('location:'.SITEURL);
                }

            }       
        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->
<?php
include('partials-front/_footer.php');
?>