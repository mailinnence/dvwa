<?php
$page['body']="";
//안하면 오류남
global $page;
//안하면 가끔 전달 안될때 있음
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Vulnerability: File Inclusion</h1>
	<div class=\"vulnerable_code_area\">
		<h3>File 1</h3>
		<hr />
		안녕 <em>DVWA 공부하는 친구ㅎㅎㅎㅎ 고생하는구나</em><br />
		너의 IP 주소는 <em>{$_SERVER[ 'REMOTE_ADDR' ]}</em> 야!!<br />
		혹시 '::1' 이라고 나왔다면  IPv6 에서의 자기 자신을 가리키는 loopback address 이니까 놀라지마!!!
		<br />
		
		[<em><a href=\"?page=include.php\">back</a></em>]
	</div>


</div>\n";


//$_SERVER["REMOTE_ADDR"] 는 웹서버에 접속한 접속자의 IP정보를 갖는다.
//https://m.blog.naver.com/diceworld/220253997457

//PHP 에서 $_SERVER['REMOTE_ADDR'] 이 ::1 을 반환하는 경우가 있다.
//이는 IPv6 에서의 자기 자신을 가리키는 loopback address 이다


?>
