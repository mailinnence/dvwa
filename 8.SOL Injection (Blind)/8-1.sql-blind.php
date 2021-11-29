<!--
참조
https://webhack.dynu.net/?idx=20161227.002&print=friendly

있냐 없냐를 확인하는 것
// 블라인드 SQL 인젝션 참 구문
1' AND 1=1#

// 블라인드 SQL 인젝션 거짓 구문
1' AND 1=2#

만약 웹의 반응으로 판별하기 어렵다면 시간차를 두므로써 이를 해결한다
// 시간기반 블라인드 SQL 인젝션 탐지 구문
1' AND SLEEP(5)#
F12 를 누르고 network 에서 이를 실행했을때 참이라면
지정한 시간만큼 기다렸다가 반응한다
거짓이라면 바로 반응한다

위의 3가지 원리는 활용되어 공격이 가능하다.
왜냐면 여기서 AND 1=1# 이 아니라 다른 명제를 주면
어떤 조건으로 DB가 이루어져 있는지 직접적으로는 아니지만 어느 정도는 알아낼수 있기 때문이다


-->


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

</head>
<h1>Vulnerability: SQL Injection-blind</h1>
<?php

if( isset( $_GET[ 'Submit' ] ) ) {
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";

    // Get input
    $id = $_GET[ 'id' ];

    // Check database
    $getid  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
    $result = mysqli_query($GLOBALS["con"],  $getid ); // Removed 'or die' to suppress mysql errors

    // Get results
    $num = @mysqli_num_rows( $result ); // The '@' character suppresses errors
    if( $num > 0 ) {
        // Feedback for end user
        echo '<pre>User ID exists in the database.</pre>';
    }
    else {
        // User wasn't found, so the page wasn't!
        header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 404 Not Found' );

        // Feedback for end user
        echo  '<pre>User ID is MISSING from the database.</pre>';
    }

    ((is_null($___mysqli_res = mysqli_close($GLOBALS["con"]))) ? false : $___mysqli_res);
}

?>
<body>

<div id="system_info">
    <form action="#" method="GET">
        <p>
            User ID:
            <input type="text" size="15" name="id">
            <input type="submit" name="Submit" value="Submit">
        </p>

    </form>

</div>
