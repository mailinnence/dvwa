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
if( isset( $_GET[ 'Change' ] ) ) {

    // Checks to see where the request came from
    if( stripos( $_SERVER[ 'HTTP_REFERER' ] ,$_SERVER[ 'SERVER_NAME' ]) !== false ) {
        //2020버전
//        stripos ()는 첫 번째 항목 (대소 문자 구분)의 다른 문자열에 문자열의 위치를 찾는 기능을한다.
//        참고 : stripos () 함수는 대소 문자를 구분하지 않습니다.
//        참고 :이 함수는 바이너리 안전합니다.
//        strripos은 () - 마지막에 나타나는 다른 문자열에 문자열의 위치를 찾기 (대소 문자 구분)
//        strpos () - 첫 번째 항목의 또 다른 문자열에서 문자열 찾기 (대소 문자 구분)
//        strrpos () - 마지막에 나타나는 다른 문자열에서 문자열 찾기 (대소 문자 구분)
//


        //2015년 버전
       // if( mb_ereg  ( $_SERVER[ 'SERVER_NAME' ], $_SERVER[ 'HTTP_REFERER' ] )) {
        //mb_eregi ( string $pattern , string $string [, array &$matches = null ] ) : bool
        //mb_eregi  >>  $pattern 에 $string이 속해있는지 아닌지 확인하는 메소드 대소문자 구분안하고 있기만 하면 된다.
        //mb_ereg   >>  $pattern 에 $string이 속해있는지 아닌지 확인하는 메소드 대소문자 구분한다

//예시--------------------------------------------------------------------------------------------------------------
//        $a="It is great PHP";
//        $b="GREAT";
//
//        if(mb_eregi($b, $a)) // 대소문자를 구별함 ( 결과: false)
//        {
//            echo "true";
//        }else
//        {
//            echo "false";
//        }
//        echo "<br>";
//        $a="It is GREAT PHP";
//        $b="GREAT";
//
//        if(mb_eregi($b, $a)) // 대소문자를 구별함 ( 결과: false)
//        {
//            echo "true";
//        }else
//        {
//            echo "false";
//        }
//--------------------------------------------------------------------------------------------------------------


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
    }
    else {
        // Didn't come from a trusted source
        echo "<pre>That request didn't look correct.</pre>";
    }
    ((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);

}

?>

<body>
<div class="body_padded">
    <h1>Vulnerability: Cross Site Request Forgery (CSRF) - middle</h1>
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




