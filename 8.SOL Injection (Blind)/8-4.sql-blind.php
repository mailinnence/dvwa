<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

</head>
<h1>Vulnerability: SQL Injection-blind</h1>
<?php
include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
$servername = "localhost";
$username = "root";
$password = "";


$con = new PDO("mysql:host=$servername;dbname=dvwa", $username, $password);
// set the PDO error mode to exception



if( isset( $_GET[ 'Submit' ] ) ) {


    // Check Anti-CSRF token
    checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ] );

    // Get input
    $id = $_GET[ 'id' ];

    // Was a number entered?
    if(is_numeric( $id )) {
        // Check the database
        $data = $con->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' );
        $data->bindParam( ':id', $id, PDO::PARAM_INT );
        $data->execute();

        // Get results
        if( $data->rowCount() == 1 ) {
            // Feedback for end user
            if ($k == 0) {
            echo '<pre>User ID exists in the database.</pre>';
            }
            else
                echo "<h1>There is a problem with the token</h1>";
        }
        else
            echo "User is not exist";
    }
}





// Generate Anti-CSRF token
generateSessionToken();

?>
<body>


<div class="vulnerable_code_area">
    <form action="#" method="GET">
        <p>
            User ID:
            <input type="text" size="15" name="id">
            <input type="submit" name="Submit" value="Submit">
            <?php echo tokenField()?>
        </p>

    </form>

</div>