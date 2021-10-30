<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <?php
    //server
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";

    if( isset( $_GET[ 'Login' ] ) ) {
        // Get username
        $user = $_GET['username'];
        $user = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        //mysqli_real_escape_string 들어온 문자에 특수문자 앞에 /를 붙여서 특수문자를 무효화 시킴
        // Get password
        $pass = $_GET['password'];
        $pass = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $pass = md5($pass);



        // Check the database
        $query = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
        $result = mysqli_query($con, $query) or die('<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>');

          if( isset( $result) && mysqli_num_rows( $result ) > 0 ) {
            echo "<h1>Congratulations. The attack was successful.<br>That's right,<br> The password is {$_GET[ 'password' ]}</h1>";

        }
        else {
            echo "<h1>Username and/or password incorrect.</h1>";
            // Login failed

            sleep( 2 );


        }

        ((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);

    }

    ?>


</head>

<body class="home">
<div id="container">

    <div id="main_body">


        <div class="body_padded">
            <h1>Vulnerability: Brute Force-low,middle</h1>

            <div class="vulnerable_code_area">
                <h2>Login</h2>

                <form action="#" method="GET">
                    Username:<br />
                    <input type="text" name="username"><br />
                    Password:<br />
                    <input type="password" AUTOCOMPLETE="off" name="password"><br />
                    <br />
                    <input type="submit" value="Login" name="Login">

                </form>


                <br /><br />



</body>

</html>



