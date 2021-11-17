<?php include('partials/_header.php'); ?>
<?php include('partials/_dbconnect.php'); ?>


<div class="container mt-5 py-5">
    <h1 class="text-center">Change Password</h1>
    <div id="main-content" class="py-3">
        <div id="wrapper">

            <?php
            // 
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            ?>


            <form action="/rcw/admin/update-password.php" method="post">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" placeholder="Current Password" name="current_password" class="form-control" id="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" placeholder="New Password" class="form-control" id="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" id="confirm_password" required>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
            </form>

        </div>
    </div>
</div>


<?php
// checking whether the (submit) change password button is clicked or not
if (isset($_POST['submit'])) {
    // echo " Clicked";

    // 1. Get the Data from form 
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // 2. Check whether the user with current ID and current Password Exists or Not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // Exevute the Query 
    $result = mysqli_query($conn, $sql);

    if ($result == true) {
        // check whether the user data is available
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            // User exists and password can be changed 
            // echo "User Found"; // Testing purpose only

            // Check whether the new password and confirm password matches or not
            if ($new_password == $confirm_password) {
                // Update the Password 
                // Testing
                // echo "password Match";

                // sql Query
                $sql2 = "UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                ";

                // Execute the Query 
                $result2 = mysqli_query($conn, $sql2);

                // check whether the query is executed or not
                if ($result2 == true) {
                    // Display Success Meassage 
                    // Redirect to Manage Admin Page with Success Message
                    $_SESSION['change-pass'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Success!</strong> Password Changed Succesfully
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                ';
                    header("location: " . SITEURL .  'admin/manage-admin.php');
                } else {
                    // Display Error Message
                    // Redirect to Manage Admin Page with Error Message
                    $_SESSION['change-pass'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <strong>Error!</strong> Failed to Change Password 
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                    ';
                    header("location: " . SITEURL .  'admin/manage-admin.php');
                }
            } else {
                // Redirect to Manage Admin Page with Error Message
                $_SESSION['pass-not-match'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Error!</strong> Password Didn\'t Match
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                ';
                header("location: " . SITEURL .  'admin/manage-admin.php');
            }
        } else {
            //  user does not exists Set Message and Redirect the user
            // create a variavle to display Message
            $_SESSION['user-not-found'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> User Not Found
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            ';

            // Redirecting page to Manage admin page
            header("location: " . SITEURL .  'admin/manage-admin.php');
        }
    }
    // 3. Check Whether the New Password and Confirm Password Match or Not



    // 4. Change if all The above is True
}

?>

<?php include('partials/_footer.php'); ?>