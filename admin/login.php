<?php
include('partials/_dbconnect.php');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>foodie | Admin Login</title>
</head>

<body class="text-center">
    <?php
    // Checking whether the session is set for login to display message or not
    if (isset($_SESSION['login'])) {
        echo $_SESSION['login']; // Displaying message
        unset($_SESSION['login']); //REmoving after showing message once
    }
    // Checking whether the session is set for admin is login or not
    if (isset($_SESSION['no-login-message'])) {
        echo $_SESSION['no-login-message']; // Displaying message
        unset($_SESSION['no-login-message']); //Removing after showing message once
    }
    ?>

    <div class="container d-flex align-items-center justify-content-center my-5">



        <form action="/rcw/admin/login.php" method="post">
            <h1 class="display-4 text-dark font-weight-700">foodie</h1>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating my-3">
                <input type="text" name="username" class="form-control" style="width: 300px;" id="username" placeholder="username">
                <label for="username">Username</label>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Login </button>
            <p class="mt-5 mb-3 text-muted">© 2021–2024</p>
        </form>

    </div>

    <?php

    // check whether the submit button is clicked or not
    if (isset($_POST['submit'])) {
        // Process for login

        // 1. Get the Data from form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // 2. SQL query to check whether the username with password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the Query 
        $result = mysqli_query($conn, $sql);

        // 4. Check whether the user exists or not
        $count = mysqli_num_rows($result);

        if ($count == 1) {

            // user Available and Login Success 
            // create a variable to display Message
            $_SESSION['login'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Login successfull.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
            // Check  whether the user is logged in or not and logout will unset it
            $_SESSION['user'] = $username;



            // Redirecting to  Home Page or DashBoard page
            header("location: " . SITEURL .  'admin/');
        } else {
            // User Not Available and Login Faile Message

            // create a variable to display Message
            $_SESSION['login'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> username or password didn\'t match.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';


            // Redirecting to  Home Page or DashBoard page
            header("location: " . SITEURL .  'admin/login.php');
        }
    }
    ?>






    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>