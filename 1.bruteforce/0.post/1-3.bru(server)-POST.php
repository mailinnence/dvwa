<?php
//server
include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
// 따로 만들어 두지 않았다면
// ex) $con = mysqli_connect("localhost", "120180366DB", "123456", "dvwa");
// 자신의 db를 가지고 있어야 한다


if( isset(  $_POST['login'] ) ) {
    checkToken($_REQUEST['user_token'], $_SESSION['session_token']);
    // Get username
    $user =  $_POST['id'];
    $user = stripslashes( $user );
    $user = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    // Get password
    $pass = $_POST['pass'];
    $pass = stripslashes( $pass );
    $pass = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
    $pass = md5( $pass );

    // Check the database
    $query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
    $result = mysqli_query($con, $query) or die('<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>');
    if( isset( $result) && mysqli_num_rows( $result ) == 1 ) {
        // Login successful
        if($k==0) {
            echo "<h1>Congratulations. The attack was successful.<br>That's right,<br> The password is {$_POST[ 'pass' ]}</h1>";

        }
        #    echo "<img src=\"{$avatar}\" />";
        else{
            echo "<h1>There is a problem with the token</h1>";
        }


    }
    else {
        if($k==0) {
            echo "<h1><br />Username and/or password incorrect.</h1>";
            sleep( rand( 0, 5 ) );
        }
        else
            echo "<h1>There is a problem with the token</h1>";
    }




}

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);



?>
