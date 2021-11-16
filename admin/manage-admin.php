<?php
include('partials/_header.php');
?>

<!-- display message -->
<?php
include 'partials/_dbconect.php';

session_start();
if (isset($_SESSION['add'])) {
    // Displaying message
    echo $_SESSION['add'];
    // removing after showing message once
    unset($_SESSION['add']);
}

if (isset($_SESSION['delete'])) {
    // Displaying message
    echo $_SESSION['delete'];
    // removing after showing message once
    unset($_SESSION['delete']);
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

                <!-- Displaying admin's data from dabase -->
                <?php
                // query for getting admin data from db
                $sql = "SELECT * FROM `tbl_admin`";
                // execute the query
                $result = mysqli_query($conn, $sql);

                // check whether the query is executed or not
                if ($result == true) {
                    // count the rows to check whether we have data in database table of admin users
                    $count = mysqli_num_rows($result); // Function to get all the rows in the database
                    
                    $sno = 0; // Creatinga variable and Assign the value

                    // Check the no of rows
                    if ($count > 0) {
                        // we have data in database
                        while ($rows = mysqli_fetch_assoc($result)) {
                            // using while loop to get all the data from database.
                            // and while loop wil run as long as we have data in database.

                            // Get Indiidual data from database
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];
                            $sno++;

                            // Display the values in our Tables.
                            echo '
                            <tr>
                                <td>'.$sno.'.</td>
                                <td>'.$full_name.'</td>
                                <td>'.$username.'</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Update Admin</a>
                                    <a href="'.SITEURL.''."admin/delete-admin.php?id=$id".'" class="btn btn-danger btn-sm">Delete Admin</a>
                                </td>
                            </tr>
                            ';
                





                        }
                    } else {
                        // we don't have data in database
                        echo "No data";
                    }
                }
                ?>
            </table>


        </div>
    </div>
</div>


<?php include('partials/_footer.php'); ?>