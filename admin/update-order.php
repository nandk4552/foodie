<?php
include('partials/_header.php');
?>

<div class="container my-5">
    <div id="main-content" class="zindex-2" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,0.3);">

        <div id="wrapper">
            <h1 class="text-center py-3">Update Order</h1>

            <?php

            // check whether id is set or not
            if (isset($_GET['id'])) {
                // Get the order details
                $id = $_GET['id'];


                // Get all other details based on this id 
                // SQL query to get the order details
                $sql = "SELECT * FROM tbl_order WHERE id=$id";

                // Execute the query 
                $result = mysqli_query($conn, $sql);

                // Count Rows
                $count = mysqli_num_rows($result);

                if ($count == 1) {
                    // Details Available
                    $row = mysqli_fetch_assoc($result);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                } else {
                    // REdirect the user to manage order
                    header('location:' . SITEURL . 'admin/manage-order.php');
                    die();
                }
            } else {
                // redirect to manage order page
                header('location:' . SITEURL . 'admin/manage-order.php');
                die();
            }

            ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Food Name: </label>
                    <label for="exampleInputEmail1" class="form-label mx-4"><b> <?php echo $food; ?></b></label>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <label for="exampleInputEmail1" class="form-label mx-4"><b> $<?php echo $price; ?></b></label>
                </div>
                <div class="mb-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="number" value="<?php echo $qty; ?>" class="form-control" name="qty" id="qty" aria-describedby="emailHelp">
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect02">Status</label>
                    <select name="status" class="form-select" id="inputGroupSelect02">

                        <option <?php if ($status == "Ordered") {
                                    echo "selected";
                                } ?> value="Ordered">Ordered</option>
                        <option <?php if ($status == "On Delivery") {
                                    echo "selected";
                                } ?> value="On Delivery">On Delivery</option>
                        <option <?php if ($status == "Delivery") {
                                    echo "selected";
                                } ?> value="Delivered">Delivered</option>
                        <option <?php if ($status == "Cancelled") {
                                    echo "selected";
                                } ?> value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="form-control" id="customer_name" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="customer_contact" class="form-label">Customer Contact</label>
                    <input value="<?php echo $customer_contact; ?>" type="text" class="form-control" id="customer_contact" value="<?php echo $customer_contact; ?>" name="customer_contact">
                </div>
                <div class="mb-3">
                    <label for="customer_email" class="form-label">Customer Email</label>
                    <input value="<?php echo $customer_email; ?>" type="text" class="form-control" id="customer_email" name="customer_email">
                </div>
                <div class="mb-3">
                    <label for="customer_address" class="form-label">Customer Address</label>
                    <textarea type="text" class="form-control" id="customer_address" name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                </div>

                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <button type="submit" name="submit" class="btn btn-primary my-3">Update Order</button>
            </form>

            <?php
            // check whether the update button is clicked or not
            if (isset($_POST['submit'])) {
                // echo "Clicked!";

                // get all the values from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price * $qty;
                $status = $_POST['status'];
                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];
                // UPDATE `tbl_order` SET `customer_email` = 'sfe7@5xtb.com' WHERE `tbl_order`.`id` = 5;

                // update the values
                $sql2 = " UPDATE tbl_order SET
                            qty = $qty,
                            total = $total,
                            status = '$status',
                            customer_name = '$customer_name',
                            customer_contact = '$customer_contact',
                            customer_email = '$customer_email',
                            customer_address = '$customer_address'
                            WHERE id=$id;
                    ";
                    // echo $sql2; die();
                // Execute the query
                $result2 = mysqli_query($conn, $sql2);

                // check whether update or not
                // and redirect to manage order with message
                if ($result2 == true) {
                    // Updated
                    $_SESSION['update'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Order Updated Successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    header('location:' . SITEURL . 'admin/manage-order.php');
                } else {
                    // Failed to Update
                    $_SESSION['update'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Failed to Update Order.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    header('location:' . SITEURL . 'admin/manage-order.php');
                }
            }
            ?>
        </div>
    </div>
</div>
<?php
include('partials/_footer.php');
?>