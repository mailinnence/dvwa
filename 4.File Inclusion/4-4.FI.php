

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div id="main_body">
    <h1>-impossible-</h1>

</div>
</body>
<?php
include "C:\\xampp\\htdocs\\3.dvwa\\4.File Inclusion\\1-1.fi.php";

$file = $_GET[ 'page' ];
if( isset( $file ) ){
    if( $file != "include.php" && $file != "file1.php" && $file != "file2.php" && $file != "file3.php") {
        echo "ERROR: File not found!";
        exit;
    }
    else{
        include( $file );
    }
}
//include 되는 것을 정해놔버리는 것 이다. 이러면 공격이 불가능하다

else {
    header( 'Location:?page=include.php' );
    exit;
}



dvwaHtmlEcho( $page );



?>


<body>
<div id="main_body">


</div>
</body>
</html>

