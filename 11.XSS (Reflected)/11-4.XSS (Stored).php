<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Stored Cross Site Scripting (XSS) - impossible</h1>
    <?php
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
    if( isset( $_POST[ 'btnSign' ] ) ) {
        // Check Anti-CSRF token
        checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );

        // Get input
        $message = trim( $_POST[ 'mtxMessage' ] );
        $name    = trim( $_POST[ 'txtName' ] );

        // Sanitize message input
        $message = stripslashes( $message );
        $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $message = htmlspecialchars( $message );

        // Sanitize name input
        $name = stripslashes( $name );
        $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $name = htmlspecialchars( $name );

        // Update database
        $data = $db->prepare( 'INSERT INTO guestbook ( comment, name ) VALUES ( :message, :name );' );
        $data->bindParam( ':message', $message, PDO::PARAM_STR );
        $data->bindParam( ':name', $name, PDO::PARAM_STR );
        $data->execute();
    }

    // Generate Anti-CSRF token
    generateSessionToken();

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
        <?php echo tokenField()?>
        </form>

    </div>
</body>

</html>



