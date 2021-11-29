<!--
txtMessage 부분은 보안이 imposible이라 공격이 불가능하나
txtName 은 보안이 되어 있지 않다.
보안은 어느 하나라도 잘못되면 안된다는 예시이다다


들어온 정보를 대소문자 가리지않고 특정 순서로 오면 싹다 지우는 방법이다.
그러나 이 또한 뚫린다
왜냐면 xss는 막지만 공격법을 바꾸면 같은 효과를 낼 수 있다.
대표적으로 html 인젝션이 있다

-->


<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Stored Cross Site Scripting (XSS) - high</h1>

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

    <?php

    if( isset( $_POST[ 'btnSign' ] ) ) {
        // Get input
        $message = trim( $_POST[ 'mtxMessage' ] );
        $name    = trim( $_POST[ 'txtName' ] );

        // Sanitize message input
        $message = strip_tags( addslashes( $message ) );
        $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $message = htmlspecialchars( $message );

        // Sanitize name input
        $name = preg_replace( '/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $name );
        $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

        // Update database
        $query  = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";
        $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

        //mysql_close();
    }

    ?>
</body>

</html>
