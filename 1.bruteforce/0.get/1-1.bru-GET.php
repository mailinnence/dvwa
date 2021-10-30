<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <?php
    //server
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";


if( isset( $_GET[ 'Login' ] ) ) {
    // Get username
    $user = $_GET['username'];
    // Get password
    $pass = $_GET['password'];
    $pass = md5($pass);

    //md5()는 문자열에서 md5 해시값을 생성하는 함수
    //db에는 진짜 패스워드를 절대 저장하지 않는다 가입할때 입력한 패스워드를 해시함수로 바꾸어서 저장한다
    //때문에 비밀번호를 다시 찾을때 항상 새로 만들어야하는 이유가 이것이다 해시는 일방향성을 가져서
    //원래 값을 다시 찾기 쉽지 않기 때문이다

//(ex---------------------------------------------------------
//    $pass = md5("study is study");
//    echo $pass;  >> 34fec576a8cb664aeabb1883ee76d2d9
//-------------------------------------------------------------

    // Check the database
    $query = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
    //필드명 user를 가진 레코드에서 조건에 맞는 레코드를 가져온다
    $result = mysqli_query($con, $query) or die('<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>');
   //$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
    //위 코드는 dvwa를 벗어난 코드입니다.따로 분석하지않고 위코드처럼 db를 바로 입력하는 방식으로 써도 무방합니다만. 하셨다면 저 좀 알려주세요.....

//------------------------------------------------------------------------
//물음표(?) 가 if를 대신하고, 콜론(:) 이 else문을 대신한다.
// a = "A";
// if ($a == "A") {echo "조건 만족"; }
// else { echo "조건 불만족"; }
//
// echo $a == "A" ? "조건 만족" : "조건 불만족";
//
//------------------------------------------------------------------------

    //불러온 값을 저장하거나 오류가 발생시 그 오류의 종류 $result에 저장해라
        if( isset( $result) && mysqli_num_rows( $result ) > 0 ) {
             echo "<h1>Congratulations. The attack was successful.<br>That's right,<br> The password is {$_GET[ 'password' ]}</h1>";

        }
        else {
            echo "<h1>Username and/or password incorrect.</h1>";
//-------------------------------------------------------------------------------------------------------------------------------------
            // Login failed
            //row 단계는 어떠한 설정도 없다
            //middle 단계는 일정한 시간 지연
            //sleep( 2 );
            //high 단계는 랜덤한 시간을 지연
            //sleep( rand( 0, 5 ) );
//-------------------------------------------------------------------------------------------------------------------------------------

        }

        ((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);

}

?>


</head>

<body class="home">
<div id="container">

    <div id="main_body">


        <div class="body_padded">
            <h1>Vulnerability: Brute Force-low</h1>

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




