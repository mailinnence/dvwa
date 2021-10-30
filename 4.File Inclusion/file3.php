<?php
$page['body']="";
global $page;
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Vulnerability: File Inclusion</h1>
	<div class=\"vulnerable_code_area\">
		<h3>File 3</h3>
		<hr>
		Welcome back <em>DVWA 공부하는 친구ㅎㅎㅎㅎ 고생하는구나</em><br />
		Your IP address is: <em>{$_SERVER[ 'REMOTE_ADDR' ]}</em><br />";
if( array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER )) {
	//array_key_exists() 함수는 지정된 키의 배열을 확인하고 키가 키가 존재하지 않는 경우에 존재하는 경우는 false true를 반환
	//array_key_exists( key,array )
	//http://www.w3bai.com/ko/php/func_array_key_exists.html
	$page[ 'body' ] .= "Forwarded for: <em>" . $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
	$page[ 'body' ] .= "</em><br />";
}
		$page[ 'body' ] .= "Your user-agent address is: <em>{$_SERVER[ 'HTTP_USER_AGENT' ]}</em><br />";
if( array_key_exists( 'HTTP_REFERER', $_SERVER )) {
		$page[ 'body' ] .= "You came from: <em>{$_SERVER[ 'HTTP_REFERER' ]}</em><br />";
}
		$page[ 'body' ] .= "I'm hosted at: <em>{$_SERVER[ 'HTTP_HOST' ]}</em><br /><br />
		[<em><a href=\"?page=include.php\">back</a></em>]
	</div>

</div>\n";

//https://m.blog.naver.com/PostView.naver?isHttpsRedirect=true&blogId=psj9102&logNo=220901757331
//HTTP_X_FORWARDED_FOR
//$_SERVER[ 'HTTP_X_FORWARDED_FOR' ]
//$_SERVER[ 'HTTP_USER_AGENT' ]
//$_SERVER[ 'HTTP_REFERER' ]
//$_SERVER[ 'HTTP_HOST' ]
//
//
//
//1.HTTP_X_FORWARDED_FOR
//$_SERVER[ 'HTTP_X_FORWARDED_FOR' ]
//PHP개발을 하다보면, 부정사용을 방지하는 목적 등을 위해
//사용자의 IP를 체크하는 경우가 있다.
//원래라면
//
//<?php
//$ip = $_SERVER['REMOTE_ADDR'];
//echo $ip;
//
//
//하면 ip가 나와야 하는데
//경우에 따라서는 사용자의 IP주소를 올바르게 가져오지 못하는 경우가 있는데요,
//예를 들면 사용자가 프록시 서버를 경유해 특정 웹사이트로 접근하면 프록시 서버에
//의해 사용자의 실제 IP주소를 숨길 수 있기 때문입니다.
//그런데 이러한 경우에도, 다른 방법을 통해 실제 사용자의 IP주소를
//알아낼 수 있습니다.
//웹사이트에 접근할 때, 여러 가지 헤더정보를 넘겨 주게 되는데,
//거기에 원래(실제) 사용자의 IP주소도 같이 넘겨 받게 됩니다.
//그 메소드가 "X-Forwarded-For"이고,
//PHP에서는 "HTTP_X_FORWARDED_FOR" 변수에 저장됩니다.
//즉
//HTTP_X_FORWARDED_FOR 변수로 비교 체크하여 불량IP주소를 어느정도 걸러낼 수 있습니다.
//
//
//
//2.$_SERVER[ 'HTTP_USER_AGENT' ]
//사용자의 웹접속환경 정보를 담고 있는 PHP전역변수
//
//<?php
//echo $_SERVER['HTTP_USER_AGENT'];
//
//
//<!-----------------------------------------------------------------------------------------------------------------------------------------------------------
//<!--Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.155 Safari/537.36
//
//
//
//
//
//
//3.나머지
//$_SERVER['HTTP_REFERER'] : 이전페이지 주소값
//$_SERVER['HTTP_HOST'] : 사이트 도메인 : roadrunner.tistory.com (접속할 때 사용한 도메인)
//
//
//
//
//4.기타
//$_SERVER['DOCUMENT_ROOT'] : 사이트 루트의 물리적 경로. ex) /home/ksprg/www
//$_SERVER['HTTP_ACCEPT_ENCODING'] : 인코딩 받식. ex) gzip, deflate
//$_SERVER['HTTP_ACCEPT_LANGUAGE'] : 언어. ex) ko
//!--$_SERVER['HTTP_USER_AGENT'] : 사이트 접속한 클라이언트 프로그램 정보. ex) Mozilla/4.0(compatible; MSIE 7.0; Windows NT 5.1; Q312461; .NET CLR 1.0.3705
//$_SERVER['REMOTE_ADDR'] : 사이트 접속한 클라이언트의 IP. ex) 192.168.0.100
//$_SERVER['HTTP_REFERER'] : 이전페이지 주소값
//$_SERVER['SCRIPT_FILENAME'] : 실행되고 있는 파일의 전체경로. ex) /home/ksprg/www/index.php
//$_SERVER['SERVER_NAME'] : 사이트 도메인 : roadrunner.tistory.com (virtual host에 지정한 도메인)
//$_SERVER['HTTP_HOST'] : 사이트 도메인 : roadrunner.tistory.com (접속할 때 사용한 도메인)
//$_SERVER['SERVER_PORT'] : 사이트 포트. ex) 8
//$_SERVER['SERVER_SOFTWARE'] : 서버의 소프트웨어 환경 ex) Apache/1.3.23 (Unix) PHP/4.1.2 mod_fastcgi/2.2.10 mod_throttle/3.1.2 mod_ssl/2.8.6
//$_SERVER['GATEWAY_INTERFACE'] : CGI 정보. ex) CGI/1.1
//$_SERVER['SERVER_PROTOCOL'] : 사용된 서버 프로토콜. ex) HTTP/1.1-
//$_SERVER['REQUEST_URI'] : 현재페이지의 주소에서 도메인 제외. ex) /index.php?user=ksprg&name=hong-
//$_SERVER['PHP_SELF'] : 현재페이지의 주소에서 도메인과 넘겨지는 값 제외. ex) /test/index.php 파일명만 가져올때 : basename($_SERVER['PHP_SELF']);
//$_SERVER['APPL_PHYSICAL_PATH'] : 현재페이지의 실제 파일 주소. ex) /home/ksprg/www/
//$_SERVER['QUERY_STRING'] : GET 방식의 파일명 뒤에 붙어서 넘어오는 파라미터 값. ex) ?user=ksprg&name=hong
//
//
//
//


