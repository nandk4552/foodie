<?php
include('partials/_header.php');
?>
<?php
if (isset($_SESSION['update'])) {
    echo $_SESSION['update'];
    unset($_SESSION['update']);
}
?>

<div class="container mt-5 py-5">
    <h1 class="text-center">Manage Order</h1>
    <div id="main-content" class="py-3" style="width: 100% !important;">
        <div id="wrapper" style="width: fit-content;">

            <table class="tbl-full my-3 table" id="myTable" style="padding: 20px;">
                <thead>
                    <tr>
                        <th scope="col">Sno</th>
                        <th scope="col">Food</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Customer Contact</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Actions</th>
                    </tr>

                </thead>

                <?php
                // Get all the orders from database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Count the rows
                $count = mysqli_num_rows($result);
                $sno = 1;

                if ($count > 0) {
                    // order available
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Get all the details
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $food; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>

                                <td>
                                    <?php
                                    //  Ordered, On Delivery, Delivary, Cancelled
                                    if ($status == "Ordered") {
                                        echo "<label>$status</label>";
                                    } elseif ($status == "On Delivery") {
                                        echo "<label style='color: orange;'>$status</label>";
                                    } elseif ($status == "Delivered") {
                                        echo "<label class='text-success'>$status</label>";
                                    } else {
                                        echo "<label class='text-danger'>$status</label>";
                                    }

                                    ?>
                                </td>

                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_contact; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $customer_address; ?></td>

                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Update Order</a>
                                </td>
                            </tr>
                        </tbody>


                <?php
                    }
                } else {
                    // order not available
                    echo '<div class="text-danger">Orders Not Available</div>';
                }

                ?>



            </table>


        </div>
    </div>
</div>


<?php
include('partials/_footer.php');
?>