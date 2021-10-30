<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    </style>
    <?php
   // include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
    include "header.php";


    $servername = "localhost";
    $username = "root";
    $password = "";
    $con = new PDO("mysql:host=$servername;dbname=dvwa1", $username, $password);
    // set the PDO error mode to exception


    if( isset( $_GET[ 'Change' ] ) ) {
	// Check Anti-CSRF token
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ] );

	// Get input
	$pass_curr = $_GET[ 'password_current' ];
	$pass_new  = $_GET[ 'password_new' ];
	$pass_conf = $_GET[ 'password_conf' ];

	// Sanitise current password input
	$pass_curr = stripslashes( $pass_curr );
	//$pass_curr = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass_curr ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	$pass_curr = md5( $pass_curr );

	// Check that the current password is correct
	$data = $con->prepare( 'SELECT password FROM users WHERE password = (:password) LIMIT 1;' );
	//$data->bindParam( ':user', dvwaCurrentUser(), PDO::PARAM_STR );
	$data->bindParam( ':password', $pass_curr, PDO::PARAM_STR );
	$data->execute();

	// Do both new passwords match and does the current password match the user?
	if( ( $pass_new == $pass_conf ) && ( $data->rowCount() == 1 ) ) {
		// It does!
		$pass_new = stripslashes( $pass_new );
		//$pass_new = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass_new ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$pass_new = md5( $pass_new );

		// Update database with new password
		$data = $con->prepare( 'UPDATE users SET password = (:password) WHERE num=3;' );
		$data->bindParam( ':password', $pass_new, PDO::PARAM_STR );
		//$data->bindParam( ':user', dvwaCurrentUser(), PDO::PARAM_STR );
		$data->execute();

		// Feedback for the user

        if($k==0) {
            echo "<h1><pre>Password Changed.</pre></h1>";

        }
        #    echo "<img src=\"{$avatar}\" />";
        else{
            echo "<h1>There is a problem with the token</h1>";
        }


    }
	else {
		// Issue with passwords matching
		  if($k==0) {
                echo "<h1>Passwords did not match.</h1>";
                sleep( rand( 0, 5 ) );
            }
            else
                echo "<h1>There is a problem with the token</h1>";
        }


}

// Generate Anti-CSRF token
generateSessionToken();
?>

</head>


<body>
<div class="body_padded">
    <h1>Vulnerability: Cross Site Request Forgery (CSRF) - impossible</h1>
    <div class="vulnerable_code_area">
        <h3>Change your admin password:</h3> <br />
        <form action="#" method="GET">
            Current password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_current"><br />
            New password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_new"><br />
            Confirm new password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_conf"><br /> <br />
            <input type="submit" value="Change" name="Change">
            <?php echo tokenField()?>
        </form>
    </div>
</div>
</body>
</html>