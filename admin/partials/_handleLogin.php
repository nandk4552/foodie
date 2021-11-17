<?php
    // Authorization - Access Control
    // Check whether the user is logged in or not
    
    // if user session  is not set
    if(!isset($_SESSION['user'])) { 
        // User is not logged in
        // Redirect to login Page with message

        $_SESSION['no-login-message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Please login to access Admin Panel. 
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        ';

            // Redirecting to login page
            header("location: " . SITEURL .  'admin/login.php' );
         
    }

