<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <?php
    //server
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";

    if( isset( $_GET[ 'Login' ] ) ) {
        // Check Anti-CSRF token
        checkToken($_REQUEST['user_token'], $_SESSION['session_token']);
//CSRF토큰
//CSRF 토큰은 서버 측 응용 프로그램에서 생성되고 클라이언트가 만든 후속 HTTP 요청에 포함되는 방식으로 클라이언트에
//전송되는 예측할 수 없는 고유한 비밀 값입니다. 나중에 요청하면 서버 측 응용 프로그램은 요청에 예상 토큰이 포함되어
//있는지 확인하고 토큰이 없거나 유효하지 않은 경우 요청을 거부합니다.
//먼저 토큰값을 만들어줄 함수를 만들고

        // Get username
        $user = $_GET['username'];
        $user = stripslashes( $user );
        $user = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

        // Get password
        $pass = $_GET['password'];
        $pass = stripslashes( $pass );
        $pass = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $pass = md5($pass);



        // Check the database
        $query = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
        $result = mysqli_query($con, $query) or die('<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>');

      if( isset( $result) && mysqli_num_rows( $result ) == 1 ) {
             // Login successful
            if($k==0) {
                echo "<h1>Congratulations. The attack was successful.<br>That's right,<br> The password is {$_GET[ 'password' ]}</h1>";

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


    // Generate Anti-CSRF token
    generateSessionToken();

    ?>


</head>

<body class="home">
<div id="container">

    <div id="main_body">


        <div class="body_padded">
            <h1>Vulnerability: Brute Force-high</h1>

            <div class="vulnerable_code_area">
                <h2>Login</h2>

                <form action="#" method="GET">
                    Username:<br />
                    <input type="text" name="username"><br />
                    Password:<br />
                    <input type="password" AUTOCOMPLETE="off" name="password"><br />
                    <br />
                    <input type="submit" value="Login" name="Login">
                    <?php echo tokenField()?>
                </form>


                <br /><br />



</body>

</html>



