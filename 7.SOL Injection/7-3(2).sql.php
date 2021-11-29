<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <h1>Vulnerability: SQL Injection</h1>

</head>

<script>
    function popUp(z){
        window.open(z,  "width=500, height=200" );
    }


</script>

<?PHP
include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";

if( isset( $_POST[ 'id' ] ) ) {

    $_SESSION[ 'id' ] =  $_POST[ 'id' ];

}

if( isset( $_SESSION [ 'id' ] ) ) {
    // Get input
    $id = $_SESSION[ 'id' ];

    // Check database
    $query  = "SELECT first_name, last_name FROM users WHERE user_id = $id;";
    $result = mysqli_query($con,  $query ) or die( '<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

    // Get results
    while( $row = mysqli_fetch_assoc( $result ) ) {
        // Get values
        $first = $row["first_name"];
        $last  = $row["last_name"];
        
        // Feedback for end user
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

    ((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
}

?>


<body>
<div class="body_padded">




        <form action="7-3(2).sql.php" method="POST">
            <input type="text" size="15" name="id">
            <input type="submit" name="Submit" value="Submit">
        </form>
        <hr />
        <br />





</div>
</body>
</html>