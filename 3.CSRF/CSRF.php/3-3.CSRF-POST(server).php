<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    </style>
</head>
<?php

include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";

if( isset( $_POST[ 'Change' ] ) ) {
    checkToken($_REQUEST['user_token'], $_SESSION['session_token']);
    // Get input
    $pass_new  = $_POST[ 'password_new' ];
    $pass_conf = $_POST[ 'password_conf' ];

    // Do the passwords match?
    if( $pass_new == $pass_conf ) {
        // They do!
        $pass_new = mysqli_real_escape_string( $con ,$pass_new );
        $pass_new = md5( $pass_new );

        // Update the database
        $insert = "UPDATE `users` SET password = '$pass_new' WHERE num = '3'";
        $result = mysqli_query( $con,$insert ) or die( '<pre>' . mysqli_error() . '</pre>' );

        // Feedback for the user
        echo"<script>alert('Password Changed.')</script>";
        echo "<script>location.href='3-0.login-POST.php'</script>";
    }
    else {
        // Issue with passwords matching
        echo"<script>alert('Passwords did not match.')</script>";
        echo "<script>location.href='3-3.CSRF-POST(client).php'</script>";
    }


}
generateSessionToken();
?>

<body>

</body>
</html>




