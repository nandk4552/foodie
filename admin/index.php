<?php
include('partials/_header.php');
?>

<?php
include('partials/_dbconnect.php');
?>
<?php
// Checking whether the session is set for login to display message or not
if (isset($_SESSION['login'])) {
    echo $_SESSION['login']; // Displaying message
    unset($_SESSION['login']); //REmoving after showing message once
}
?>

<div class="container mt-5 py-5">
    <h1 class="text-center">Dashboard</h1>
    <div id="main-content" class="py-3">
        <div id="wrapper">

            <div id="col-4" class="text-center">
                <?php
                // sql query
                $sql = "SELECT * FROM tbl_category";

                // execute the query
                $result = mysqli_query($conn, $sql);
                // count rows
                $count = mysqli_num_rows($result);
                ?>
                <h1><?php echo $count; ?></h1>
                <br>
                Categories
            </div>

            <div id="col-4" class="text-center">
                <?php
                // sql query
                $sql2 = "SELECT * FROM tbl_food";

                // execute the query
                $result2 = mysqli_query($conn, $sql2);
                // count rows
                $count2 = mysqli_num_rows($result2);
                ?>
                <h1><?php echo $count2; ?></h1>
                <br>
                Foods
            </div>

            <div id="col-4" class="text-center">
                <?php
                // sql query
                $sql3 = "SELECT * FROM tbl_order";

                // execute the query
                $result3 = mysqli_query($conn, $sql3);
                // count rows
                $count3 = mysqli_num_rows($result3);
                ?>
                <h1><?php echo $count3; ?></h1>
                <br>
                Total Orders
            </div>

            <div id="col-4" class="text-center">
                <?php
                    // create sql query to get total revenue generated
                    // Aggregate Function in SQL
                    $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                    // Execute the query 
                    $result4 = mysqli_query($conn, $sql4);

                    // Get the Value
                    $row4 = mysqli_fetch_assoc($result4);

                    // Get the total Revenue
                    $total_revenue = $row4['Total'];

                ?>
                <h1>$<?php echo $total_revenue; ?></h1>
                <br>
                Revenue Generated
            </div>

            <div id="clear-fix"></div>

        </div>
    </div>
</div>


<?php
include('partials/_footer.php');
?>