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
                <h1>5</h1>
                <br>
                Categories
            </div>

            <div id="col-4" class="text-center">
                <h1>5</h1>
                <br>
                Categories
            </div>

            <div id="col-4" class="text-center">
                <h1>5</h1>
                <br>
                Categories
            </div>

            <div id="col-4" class="text-center">
                <h1>5</h1>
                <br>
                Categories
            </div>

            <div id="clear-fix"></div>

        </div>
    </div>
</div>


<?php
include('partials/_footer.php');
?>