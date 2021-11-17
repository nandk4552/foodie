<?php include('partials/_header.php'); ?>
<?php
    include('partials/_dbconnect.php');
    
?>
<div class="container mt-5 py-5">
    <h1 class="text-center">Update Admin</h1>
    <div id="main-content" class="py-3">
        <div id="wrapper">

            <?php
            // 1. Get the ID of Selected Admin
            $id = $_GET['id'];


            // 2. Create  SQL Query to Get Details
            $sql = "SELECT * FROM `tbl_admin` WHERE `id` = $id";
            // Execute the Query 
            $result = mysqli_query($conn, $sql);
            // Check whether the query is executed or Not
            if ($result == true) {
                // check whether the data is available or not
                $count = mysqli_num_rows($result);

                // Check whether we have the admin data or not
                if ($count == 1) {
                    // Get the Details
                    // testing
                    // echo " Admin Available";

                    $row = mysqli_fetch_assoc($result);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    // Redirect to Manage Admin Page 
                    header("location: " . SITEURL . 'admin/manage-admin.php');
                }
            }
            ?>

            <form action="/rcw/admin/update-admin.php" method="post">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" value="<?php echo $full_name; ?>" class="form-control" name="full_name" id="full_name" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?php echo $username; ?>" name="username" id="username" aria-describedby="emailHelp" required>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" name="submit" class="btn btn-primary">Update Admin</button>
            </form>

        </div>
    </div>
</div>

<?php
// check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    // echo "button clicked!";
    // Get the data from form
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // Create a sql Query to Update admin
    $sql = "UPDATE tbl_admin SET `full_name` = '$full_name', `username` = '$username'  WHERE `tbl_admin`.`id` = $id";

    // Execute the Query 
    $result = mysqli_query($conn, $sql);

    // Check whether the query is Executed or not
    if ($result == true) {
        // QUERY  Executed and Admin Updated
        // create a variavle to display Message
        $_SESSION['update'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Admin Updated Successfully
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';


        // Redirecting page to Manage admin page
        header("location: " . SITEURL .  'admin/manage-admin.php');
    } else {
        // Failed to Update Admin
        // create a variavle to display Message
        $_SESSION['update'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Warning!</strong> Failed to delete Admin 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';


        // Redirecting page to Manage admin page
        header("location: " . SITEURL .  'admin/manage-admin.php');
    }
}
?>

<?php include('partials/_footer.php'); ?>