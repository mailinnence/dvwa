<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



    <?php
    //server
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";

    // 따로 만들어 두지 않았다면
    // ex) $con = mysqli_connect("localhost", "120180366DB", "123456", "dvwa");
    // 자신의 db를 가지고 있어야 한다


    //-------------------------------------------------------------------------------------------------------
//high 단계부터는 난이도가 많이 오른다
//두 가지 방법을 사용한다
//1.middle에서 사용하던 간단한 딜레이 방식을 랜덤으로 바꾼것
//2.토큰을 사용한 것!!!!(중요요)
//CSRF토큰
//CSRF 토큰은 서버 측 응용 프로그램에서 생성되고 클라이언트가 만든 후속 HTTP 요청에 포함되는 방식으로 클라이언트에
//전송되는 예측할 수 없는 고유한 비밀 값입니다. 나중에 요청하면 서버 측 응용 프로그램은 요청에 예상 토큰이 포함되어
//있는지 확인하고 토큰이 없거나 유효하지 않은 경우 요청을 거부합니다.
//먼저 토큰값을 만들어줄 함수를 만들고

    function token($length)
    {
        $characters  = "0123456789";
        $characters .= "abcdefghijklmnopqrstuvwxyz";
        $characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $characters .= "_+/|<>";

        $string_generated = "";

        $nmr_loops = $length;
        while ($nmr_loops--)    //숫자일 경우 하나씩 빠져가면서 끝까지 도달하게 하는 배열 ec)5 >>43210
            //문자일 경우 무한반복
        {
            $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];

        }

        return $string_generated;
    }

    $a=md5(token(15));
    $sql="insert into token (token) values ('$a')";
    mysqli_query($con, $sql);

    $sql="set @CNT=0;";
    mysqli_query($con, $sql);

    $sql="UPDATE token set token.num=@CNT:=@CNT+1;";
    mysqli_query($con, $sql);

    $sql = "delete from token where num >3";
    $result = mysqli_query($con, $sql);


    $sql = "SELECT token FROM token where num='2'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $z=$row["token"];
    }
    session_start();
    $_SESSION['session_token']=$z;

//    $user ='';
//    $pass ='';
//    $_REQUEST[ 'user_token' ]='';

    $sql = "delete from token where num= '1' ";
    $result = mysqli_query($con, $sql);
    //------------------------------------------------------------------------------------------------------
    if( isset( $_GET[ 'Login' ])) {


//        echo '유저토큰'.'<br>';
//        echo $_GET[ 'user_token' ] .'<br>';
//        echo '세션토큰'.'<br>';
//        echo $_SESSION[ 'session_token'].'<br>';
//
//        //sumblit를 했을떄 세션토큰이 유저토큰의 자리로 가야한다
//
//
        $k=1;
        if ($_GET[ 'user_token' ] == $_SESSION[ 'session_token']){$k=0;}
        //해시값이다. = 으로 비교해야한다!!!!
//        echo $k;


        // checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ ' session_token'], 'index.php' );
        //어려워 하지마라 $_REQUEST[] 은 get방식과 post방식을 모두 받는 변수 기능을 한다
        //공식적인 함수가 아니라 만들어진 함수이다 아마 index.php 에서 POST방식으로 받은 것 같다.
        //함수의 형태는 함수(A,B,C) 인 것 같다
        // Get username
        $user = $_GET[ 'username' ];
        $user = stripslashes( $user );
        //$user = mysqli_real_escape_string( $user );
        //이거는 sql injection 파트에서 자세히 배우니 일단 넘어가자
        //짧게 설명하면 아이디를 만드는 웹페이지가 있다고 해보자 그떄 html과 php의 구조상 input 받는 구간이
        //sql 문법일 수밖에 없다. 이를 이용하여 공격자가 sql 문장을 넣어 drop table [테이블명] 둥
        //db 자체를 공격할 수 있기 때문에 이를 방지하고자 sql 문을 필터링해주는 역할 을 해주는 코드이다

        // Get password
        $pass = $_GET[ 'password' ];
        $pass = stripslashes( $pass );
        //$pass = mysqli_real_escape_string( $pass );
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
        $result = mysqli_query( $con, $query ) or die( '<pre>' . mysqli_error() . '</pre>' );
        //불러온 값을 저장하거나 오류가 발생시 그 오류의 종류 $result에 저장해라

        if( isset( $result) && mysqli_num_rows( $result ) == 1 ) {
            //            #$avatar = mysqli_result( $result, 0, "avatar" );
            //            //mysqli_num_rows($변수) >> 변수의 해당 db의 행이 몇개인지 출력하는 함수
           // isset( $result) && mysqli_num_rows( $result ) == 1
           // 이 말을 즉 $result의 값이 있고  mysqli_num_rows( $result ) 해당하는 값이 하나일때를 의미한다다
           //
              // Login successful
            if($k==0) {
                echo "<h1>Congratulations. The attack was successful.<br>That's right,<br> The password is {$_GET[ 'password' ]}</h1>";
                //echo "<script>alert('공격이 성공하였습니다.!');</script>";
            }
            #    echo "<img src=\"{$avatar}\" />";
            else{
                echo "<h1>There is a problem with the token</h1>";
            }


        }
        else {
            //-------------------------------------------------------------------------------------------------------------------------------------
            // Login failed
            //row 단계는 어떠한 설정도 없다
            //middle 단계는 일정한 시간 지연
            //sleep( 2 );
            //high 단계는 랜덤한 시간을 지연
           //sleep( rand( 0, 5 ) );
            //-------------------------------------------------------------------------------------------------------------------------------------
            if($k==0) {
                echo "<h1><br />Username and/or password incorrect.</h1>";
            }
            else
                echo "<h1>There is a problem with the token</h1>";
        }


        //알아 둘것
        //$sql = "select * from users where user='$user'";
        //$num_match = mysqli_num_rows($result); //총 레코드 수를 반환합니다.
        // 값이 없으면 0(false),
        // 값이 있으면 레코드 갯수를 반환한다


            mysqli_close($con);
    }

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
                    <br/>
                    <input type='hidden' name='user_token' value= <?php echo $a?> />
                    <input type="submit" value="Login" name="Login">

                </form>


<!--
sudo cat /var/log/apache2/access.log 에서 볼 수 있다.
https://blog.naver.com/kdi0373/220522832069 리눅스 구조 참조

 tail -f cat /var/log/apache2/access.log
 https://sisiblog.tistory.com/218 리눅스 명령어 참조

-->
</body>
</html>