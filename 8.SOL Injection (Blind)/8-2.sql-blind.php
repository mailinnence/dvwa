<!--
참조
https://dydgh499.tistory.com/32

mysql_real_escape_string()
위 경우는 ' 가 없는 명령어로 알아내기는 쉽지않다. 물론 엄청난시간을 들이면 참, 거짓으로 알아낼 수 있으나
그보다는 특수문자를 무효화하는 함수를 우회하는 것이 더 빠른 방법이다.
방법은 ' 의 url 대체코드가 %5C%27 가 다른 코드와 결합되어
먼저 mysql_real_escape_string() 의 원리를 생각해보자 php 뿐만이 아니라
모든 언어에서 특수문자를 처리하는 방법은 툭수문자 앞에 특정 기호를 붙이는 것으로 해결한다.
' -> \' 가 되므로써
특수문자를 처리한다.

여기서 url 대체코드를 보자
' ->  %27
\ ->  %5c
\' -> %a1%5c%27

의 과정으로 이를 수행한다.
여기서

%5c%27에다가 %a1~%fe 를 앞에다가 집어넣으면 인코딩이 꺠진다.

%a1%5c%27

우회 방법을 모르겠음

-->



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

</head>
<h1>Vulnerability: SQL Injection-blind</h1>
<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    // Get input
    $id = $_POST[ 'id' ];
    $id = ((isset($GLOBALS["con"]) && is_object($GLOBALS["con"])) ? mysqli_real_escape_string($GLOBALS["con"],  $id ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    // Check database
    $getid  = "SELECT first_name, last_name FROM users WHERE user_id = $id;";
    $result = mysqli_query($GLOBALS["con"],  $getid ); // Removed 'or die' to suppress mysql errors

    // Get results
    $num = @mysqli_num_rows( $result ); // The '@' character suppresses errors
    if( $num > 0 ) {
        // Feedback for end user
        echo '<pre>User ID exists in the database.</pre>';
    }
    else {
        // Feedback for end user
        echo '<pre>User ID is MISSING from the database.</pre>';
    }

    //mysql_close();
}

?>
<body>

<div class="vulnerable_code_area">
    <form action="#" method="POST">
        <p>
            User ID:
            <select name="id"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
            <input type="submit" name="Submit" value="Submit">
        </p>

    </form>

</div>
