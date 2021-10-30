
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div id="main_body">
    <h1>-high-</h1>

</div>
</body>
<?php
include "C:\\xampp\\htdocs\\3.dvwa\\1-1.fi.php";
$file = $_GET[ 'page' ];

if( isset( $file ) ){
if( !fnmatch( "file*", $file ) && $file != "include.php" ) {
    echo "ERROR: File not found!";
    exit;
}
else{
    include( $file );
}
}
//원리는 커맨드 인젝션과 같다. 때문에 우회방법도 원리가 같다
//여기서 http로 시작하는 RFI 공격은 여기서부터는 불가능하다 그러나 패스트래버 공격은 가능하다
//먼저 이 웹사이트의 제작자가 됬다고 생각해보자. 그렇다면 어떤 조건을 걸었겠는가??
//공통적으로 나타나는 파일이름의 규칙을 의심하게 될 것 이다.
//그렇다면 자연스레 file이라는 문자만 들어가면 되는구나를 깨닫게 될 것이다.
//그렇다면 4-1.FI.php에 써놓은 것처럼 숨겨진 파일에 접근하거나. ex)  http://localhost/3.dvwa/4.File%20Inclusion/4-3.FI.php?page=file4.php
//패스트래버 공격과 활용할 수 있다.
//이렇게 ex)(리눅스 기준) file/../../../../../../../../../../../../../etc/passwd >> 최상위 디렉터리로 가야하므로 ../를 여유롭게 많이 적어준다.



else {
    header( 'Location:?page=include.php' );

    exit;
}

dvwaHtmlEcho( $page );



?>

</html>


