<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

</head>



<h1>Vulnerability: SQL Injection-blind</h1>
<?php

if( isset( $_COOKIE[ 'id' ] ) ) {
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    // Get input
    $id = $_COOKIE[ 'id' ];

    // Check database
    $getid  = "SELECT first_name, last_name FROM users WHERE user_id = '$id' LIMIT 1;";
    $result = mysqli_query($GLOBALS["con"],  $getid ); // Removed 'or die' to suppress mysql errors

    // Get results
    $num = @mysqli_num_rows( $result ); // The '@' character suppresses errors
    if( $num > 0 ) {
        // Feedback for end user
        echo '<pre>User ID exists in the database.</pre>';
    }
    else {
        // Might sleep a random amount
        if( rand( 0, 5 ) == 3 ) {
            sleep( rand( 2, 4 ) );
        }

        // User wasn't found, so the page wasn't!
        header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 404 Not Found' );

        // Feedback for end user
        echo '<pre>User ID is MISSING from the database.</pre>';
    }

    ((is_null($___mysqli_res = mysqli_close($GLOBALS["con"]))) ? false : $___mysqli_res);
}

?>
<body>

<div class="body_padded">


    <div class="vulnerable_code_area">Click <a href="#" onclick="javascript:popUp('cookie-input.php');return false;">here to change your ID</a>.

    </div>