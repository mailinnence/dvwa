<?php
//server
include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
// 따로 만들어 두지 않았다면
// ex) $con = mysqli_connect("localhost", "120180366DB", "123456", "dvwa");
// 자신의 db를 가지고 있어야 한다


if( isset(  $_POST['login'] ) ) {
    // Get username
    $user =  $_POST['id'];

    // Get password
    $pass = $_POST['pass'];
    $pass = md5( $pass );
    //md5()는 문자열에서 md5 해시값을 생성하는 함수
    //db에는 진짜 패스워드를 절대 저장하지 않는다 가입할때 입력한 패스워드를 해시함수로 바꾸어서 저장한다
    //때문에 비밀번호를 다시 찾을때 항상 새로 만들어야하는 이유가 이것이다 해시는 일방향성을 가져서
    //원래 값을 다시 찾기 쉽지 않기 때문이다

//(ex---------------------------------------------------------
//    $pass = md5("study is study");
//    echo $pass;  >> 34fec576a8cb664aeabb1883ee76d2d9
//-------------------------------------------------------------

    // Check the database
    $query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
    //필드명 user를 가진 레코드에서 조건에 맞는 레코드를 가져온다
    $result = mysqli_query($con, $query) or die('<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>');
    //불러온 값을 저장하거나 오류가 발생시 그 오류의 종류를 불러와라

    if( isset( $result) && mysqli_num_rows( $result ) > 0 ) {
        // Get users details


        #$avatar = mysqli_result( $result, 0, "avatar" );
        //한번 호출할 때 레코드가 가진 여러 필드 중에서 하나의 필드값만을 반환한다

        // Login successful
        echo "<h1>Welcome to the password protected area {$user}</h1>";
        #    echo "<img src=\"{$avatar}\" />";
    }
    else {
        // Login failed
        echo "<h1><br />Username and/or password incorrect.</h1>";
        //-------------------------------------------------------------------------------------------------------------------------------------
        // Login failed
        //row 단계는 어떠한 설정도 없다
        //middle 단계는 일정한 시간 지연
        //sleep( 2 );
        //high 단계는 랜덤한 시간을 지연
//        sleep( rand( 0, 5 ) );
        //-------------------------------------------------------------------------------------------------------------------------------------



    }

    //$sql = "select * from users where user='$user'";
    //$num_match = mysqli_num_rows($result); //총 레코드 수를 반환합니다.
    // 값이 없으면 0(false),
    // 값이 있으면 레코드 갯수를 반환한다



    ((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);

}

?>
