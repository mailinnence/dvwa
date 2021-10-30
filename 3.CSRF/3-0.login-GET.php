<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <?php
    //server
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
    include "header.php";

    if( isset( $_GET[ 'Login' ] ) ) {

        $user = $_GET[ 'username' ];
        $pass = $_GET[ 'password' ];
        $pass = md5( $pass );

        // Check the database
        $query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
        //필드명 user를 가진 레코드에서 조건에 맞는 레코드를 가져온다
        $result = mysqli_query( $con, $query ) or die( '<pre>' . mysqli_error() . '</pre>' );
        //불러온 값을 저장하거나 오류가 발생시 그 오류의 종류 $result에 저장해라

        if( isset( $result) && mysqli_num_rows( $result ) > 0 ) {
       // Login successful
            echo "<script>alert('로그인 성공')</script>";
            if ($_GET[ 'level' ]==1)
            echo "<script>location.href='3-1.CSRF-GET.php'</script>";
            if ($_GET[ 'level' ]==2)
                echo "<script>location.href='3-2.CSRF-GET.php'</script>";
            if ($_GET[ 'level' ]==3)
                echo "<script>location.href='3-3.CSRF-GET.php'</script>";
            if ($_GET[ 'level' ]==4)
                session_start();
            $_SESSION["dvwa"] = $_GET[ 'username' ];;

                echo "<script>location.href='3-4.CSRF-GET.php'</script>";

        }
        else {
            echo "<script>alert('로그인 성공실패')</script>";

        }
        mysqli_close($con);
    }

    ?>

</head>

<body class="home">
<div id="container">

    <div id="main_body">


        <div class="body_padded">
            <h1>Vulnerability: Cross Site Request Forgery (CSRF)</h1>

            <div class="vulnerable_code_area">
                <h2>Login</h2>

                <form action="#" method="GET">
                    Username:<br />
                    <input type="text" name="username"><br />
                    Password:<br />
                    <input type="password" AUTOCOMPLETE="off" name="password"><br />
                    level:<br />
                    <input type="text" name="level"><br />
                    ex)1=low,2=middle,3=high,4=impossible<br /><br />
                    <input type="submit" value="Login" name="Login">

                </form>


                <br /><br />



</body>

</html>



