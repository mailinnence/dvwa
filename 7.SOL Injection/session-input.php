
<!DOCTYPE html>

<html lang="en-GB">

<?php
include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";


if( isset( $_POST[ 'id' ] ) ) {
    $_SESSION[ 'id' ] =  $_POST[ 'id' ];
    echo "입력한 id는 ".$_SESSION[ 'id' ]." 입니다. ";
}


?>
<body>

<div id="container">


    <form action="session-input.php" method="POST">
        <input type="text" size="15" name="id">
        <input type="submit" name="Submit" value="Submit">
    </form>
    <hr />
    <br />



    <button onclick="self.close();">Close</button>

</div>

</body>

</html>
