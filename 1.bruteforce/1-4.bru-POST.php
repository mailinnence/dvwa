<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <?php
    //https://www.w3schools.com/php/php_mysql_prepared_statements.asp


    $servername = "localhost";
    $username = "root";
    $password = "";


    $con = new PDO("mysql:host=$servername;dbname=dvwa1", $username, $password);
    // set the PDO error mode to exception

    //include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";


    if( isset( $_POST[ 'Login' ] ) && isset ($_POST['username']) && isset ($_POST['password']) ) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token']);

    // Sanitise username input
    $user = $_POST[ 'username' ];
    $user = stripslashes( $user );
   // $user = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));


     // Sanitise password input
    $pass = $_POST[ 'password' ];
    $pass = stripslashes( $pass );
    //$pass = ((isset($pass) && is_object($con)) ? mysqli_real_escape_string($con,  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
    $pass = md5( $pass );

    // Default values
    $total_failed_login = 3;
    //3번 로그인 실패시 작동
    $lockout_time       = 15;
    //3번 로그인 실패시 15분 기다림
    $account_locked     = false;
    //로그인 가능 상태 false=로그인 가능 상태 ,true=로그인 불가능 상태

    // Check the database (Check user information)
    $data = $con->prepare( 'SELECT failed_login, last_login FROM users WHERE user = (:user) LIMIT 1;' );
    //db로 부터 입력한 $user 의 필드에서 failed_login, last_login을 가져와러라
    $data->bindParam( ':user', $user, PDO::PARAM_STR );

    //----------------------------------------------------------------------------------------------------------------
    //        매개변수(parameter)란
    //        함수의 정의에서 전달받은 인수를 함수 내부로 전달하기 위해 사용하는 변수를 의미합니다.
    //        인수(argument)란 함수가 호출될 때 함수로 값을 전달해주는 값을 말합니다.
    //        자바스크립트에서는 함수를 정의할 때는 매개변수의 타입을 따로 명시하지 않습니다.
    //        함수를 호출할 때에도 인수(argument)로 전달된 값에 대해 어떠한 타입 검사도 하지 않습니다.
    //        함수를 호출할 때 함수의 정의보다 적은 수의 인수가 전달되더라도, 다른 언어와는 달리 오류를 발생시키지 않습니다.
    //        이 같은 경우 자바스크립트는 전달되지 않은 나머지 매개변수에 자동으로 undefined 값을 설정합니다.
    //        즉 자동으로 파라미터의 유형을 잡아주는데 sql injection 공격을 대비해서 사용하는 이유는
    //        sql 명령구문을 그대로 sql 명령구문 유형으로 잡아버리기 떄문에 이를 대비하여 아에 문자열 타입으로 받아버려
    //        편리성이 가져다주는 문제를 없애기 위해 사용하는 것이다.
    //
    //----------------------------------------------------------------------------------------------------------------
    //
    $data->execute();
    $row = $data->fetch();

    // Check to see if the user has been locked out.
    if( ( $data->rowCount() == 1 ) && ( $row[ 'failed_login' ] >= $total_failed_login ) )  {
        //$data가 실행되고 로그인 실패 횟수가 정해놓은 한계를 넘었다면
        $last_login = strtotime( $row[ 'last_login' ] );
        //strtotime() 문자열 시간값을 타임스탬프 값으로 변환하기
        //------------------------------------------------------------------------
        //$date = '2021-09-21';
        //echo strtotime($date);
        //------------------------------------------------------------------------
        //$last_login 에다가 현재시간을 저장
        $timeout    = $last_login + ($lockout_time * 60);
        //$timeout 에다가 현재시간 +15를 저장
        $timenow    = time();
        //현재 시간을 담는 변수

        /*
        print "The last login was: " . date ("h:i:s", $last_login) . "<br />";
        print "The timenow is: " . date ("h:i:s", $timenow) . "<br />";
        print "The timeout is: " . date ("h:i:s", $timeout) . "<br />";
        */

        // Check to see if enough time has passed, if it hasn't locked the account
        if( $timenow < $timeout ) {
            //현재시간이 $timeout 에다가 현재시간 +15를 저장한 것을 넘었다면
            $account_locked = true;
            //로그인 불가능 상태
            // print "The account is locked<br />";
        }
    }

    // Check the database (if username matches the password)
    $data = $con->prepare( 'SELECT * FROM users WHERE user = (:user) AND password = (:password) LIMIT 1;' );
    $data->bindParam( ':user', $user, PDO::PARAM_STR);
    $data->bindParam( ':password', $pass, PDO::PARAM_STR );
    $data->execute();
    $row = $data->fetch();


    // If its a valid login...
    if( ( $data->rowCount() == 1 ) && ( $account_locked == false ) ) {
        // Get users details
        $failed_login = $row[ 'failed_login' ];
        $last_login   = $row[ 'last_login' ];


        // Login successful
        if($k==0) {

            echo "<h1>Congratulations. The attack was successful.<br>That's right,<br> The password is {$_POST[ 'password' ]}</h1>";

        }
        #    echo "<img src=\"{$avatar}\" />";
        else{
            echo "<h1>There is a problem with the token</h1>";
        }

        // Had the account been locked out since last login?
        //공격으로 인한 락킹 시간이 지나고 로그인 성공시 경고창
        if( $failed_login > $total_failed_login ) {
            echo "<h1><p>Warning: Someone might of been brute forcing your account.</p></h1>";
            echo "<h1><p>Number of login attempts: {$failed_login}.<br />Last login attempt was at: ${last_login}.</p></h1>";
        }

        // Reset bad login count
        //로그인 성공시 failed_login 초기화
        $data = $con->prepare( 'UPDATE users SET failed_login = "0" WHERE user = (:user) LIMIT 1;' );
        $data->bindParam( ':user', $user, PDO::PARAM_STR );
        $data->execute();

    } else{
        // Login failed

              if($k==0) {
                  sleep( rand( 0, 5 ) );
                echo "<h1><br />Username and/or password incorrect.</h1>";

            }
            else
                echo "<h1>There is a problem with the token</h1>";


           if ( $account_locked == 1) {
               //bool은 false == 0, true == 1 로 계산한다
               echo "<h1>Alternative, the account has been locked because of too many failed logins.<br />If this is the case, please try again in {$lockout_time} minutes</h1>";
           }

        // Update bad login count
        //로그인 실패시 failed_login +1
        $data = $con->prepare( 'UPDATE users SET failed_login = (failed_login + 1) WHERE user = (:user) LIMIT 1;' );
        $data->bindParam( ':user', $user, PDO::PARAM_STR );
        $data->execute();

    }

    // Set the last login time
    //다 기다렸다면 last_login 초기화
    $data = $con->prepare( 'UPDATE users SET last_login = now() WHERE user = (:user) LIMIT 1;' );
    $data->bindParam( ':user', $user, PDO::PARAM_STR );
    $data->execute();
}

// Generate Anti-CSRF token
generateSessionToken();

?>




</head>
<body class="home">
<div id="container">

    <div id="main_body">


        <div class="body_padded">
            <h1>Vulnerability: Brute Force-impossible</h1>

            <div class="vulnerable_code_area">
                <h2>Login</h2>

                <form action="1-4.bru-POST.php" method="POST">
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


<!--
update users set failed_login=0;
update users set  last_login=0;
-->
