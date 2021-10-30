<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>로그인</title>
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script type="text/javascript" src="js/login.js"></script>


</head>
<body>
<header>
    <?php ;
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
    // 따로 만들어 두지 않았다면
    // ex) $con = mysqli_connect("localhost", "120180366DB", "123456", "dvwa");
    // 자신의 db를 가지고 있어야 한다
    ?>
</header>
<section>

    <div id="main_content">
        <div id="login_box">
            <div id="login_title">
                <span>로그인</span>
            </div>
            <div id="login_form">
                <form  name="login_form" method="post" action="1-1.bru(server)-POST.php">
                    <ul>
                        <li><input type="text" name="id" placeholder="아이디" ></li>
                        <li><input type="password" id="pass" name="pass" placeholder="비밀번호" ></li> <!-- pass -->
                        <li><input type="hidden" name="login" value="login" ></li>
                    </ul>
                    <div id="login_btn">
                        <a href="#"><img src="img/login.png" onclick="check_input()"></a>
                        <!--썼는지 안 썼는지 확인하는 코드 -->
                    </div>
                </form>
            </div> <!-- login_form -->
        </div> <!-- login_box -->
    </div> <!-- main_content -->
</section>

</body>
</html>
