<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    </style>
</head>
<?php
//보안 안되있음
include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";

if( isset( $_GET[ 'Change' ] ) ) {
    // Get input
    $pass_new  = $_GET[ 'password_new' ];
    $pass_conf = $_GET[ 'password_conf' ];

    // Do the passwords match?
    if( $pass_new == $pass_conf ) {
        // They do!
        $pass_new = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $pass_new ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $pass_new = md5( $pass_new );

        // Update the database
        $insert = "UPDATE `users` SET password = '$pass_new' WHERE num = '3'";
        $result = mysqli_query($con,  $insert ) or die( '<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

        // Feedback for the user
        echo"<h1>Password Changed.</h1>";
    }
    else {
        // Issue with passwords matching
        echo "<h1>Passwords did not match.</h1>";
    }
    ((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);


}

?>

<body>
<div class="body_padded">
    <h1>Vulnerability: Cross Site Request Forgery (CSRF) - low</h1>
    <div class="vulnerable_code_area">
        <h3>Change your admin password:</h3> <br />
        <form action="#" method="GET"> New password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_new"><br /> Confirm new password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_conf"><br /> <br />
            <input type="submit" value="Change" name="Change">

        </form>
    </div>
</body>
</html>




