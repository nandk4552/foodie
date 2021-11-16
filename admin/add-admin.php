<?php
include('partials/_header.php');
?>
<?php
// <!-- checking whether the session is set or not -->
session_start();
if (isset($_SESSION['add'])) {
    // Displaying session message if set
    echo $_SESSION['add'];
    // Remove session message
    unset($_SESSION['add']);
}
?>

<!-- logic part -->
<?php
// Process the value from Form into Database

// check whether the submit button is clicked or not

if (isset($_POST['submit'])) {
    // buttom clicked 
    // echo "Button clicked";
    // connection with db
    include 'partials/_dbconect.php';

    //1. get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //2. SQL query to save the data into database
    $sql = "INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES (NULL, '$full_name', '$username', '$password')";

    //3. Execute Query and Save Data in Database
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4. check whether the (QUERY is executed) data is inserted or not and display appropriate message
    if ($result == true) {
        // Data inserted into DB
        // echo "Data inserted";
        // create a variavle to display Message
        $_SESSION['add'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> Admin added successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';


        // Redirecting page to Manage admin page
        header("location: " . SITEURL .  'admin/manage-admin.php');
    } else {
        // Failed to inserted into DB
        // echo "Failed to inserted";

        // create a variavle to display Message
        $_SESSION['add'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Failed to add Admin
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';



        // Redirecting page to Add admin page
        header("location: " . SITEURL . 'admin/add-admin.php');
    }
}

?>


<div id="main-content">

    <div id="wrapper">
        <h1 class="text-center py-3">Add Admin</h1>



        <form action="/rcw/admin/add-admin.php" method="post">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" id="full_name" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Admin</button>
        </form>

    </div>

</div>


<?php
include('partials/_footer.php');
?>