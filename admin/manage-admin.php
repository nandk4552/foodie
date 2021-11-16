<?php
include('partials/_header.php');
?>
<?php
include('partials/_dbconnect.php');
?>
<!-- display message -->
<?php
session_start();
if (isset($_SESSION['add'])) {
    // Displaying message
    echo $_SESSION['add'];
    // removing after showing message once
    unset($_SESSION['add']);
}
?>



<div class="container mt-5 py-5">
    <h1 class="text-center">Manage Admin</h1>
    <div id="main-content" class="py-3">
        <div id="wrapper">
            <a href="add-admin.php" class="btn btn-primary btn-sm">Add Admin</a>

            <table class="tbl-full my-2">
                <tr>
                    <th>sno</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <tr>
                    <td>1</td>
                    <td>Nand Kishore</td>
                    <td>kishore</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm">Update Admin</button>
                        <button type="button" class="btn btn-danger btn-sm">Delete Admin</button>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Nand Kishore</td>
                    <td>kishore</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm">Update Admin</button>
                        <button type="button" class="btn btn-danger btn-sm">Delete Admin</button>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Nand Kishore</td>
                    <td>kishore</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm">Update Admin</button>
                        <button type="button" class="btn btn-danger btn-sm">Delete Admin</button>
                    </td>
                </tr>
            </table>


        </div>
    </div>
</div>


<?php
include('partials/_footer.php');
?>