<?php

// Check if the right PHP functions are enabled
$WarningHtml = '';
if( !ini_get( 'allow_url_include' ) ) {
	$WarningHtml .= "<div class=\"warning\">The PHP function <em>allow_url_include</em> is not enabled.</div>";
}
if( !ini_get( 'allow_url_fopen' ) ) {
	$WarningHtml .= "<div class=\"warning\">The PHP function <em>allow_url_fopen</em> is not enabled.</div>";
}

//ini_get() 는 ini_set() 소속 함수로 php.ini에 지정되어 있는 지시어의 값을 읽어오는 함수이다.
//http://www.joshi.co.kr/index.php?mid=board_EudV58&document_srl=293136


global $page;
$page['body']="";
$page['body'] .= "<body>
<div class=\"body_padded\">
	<h1>Vulnerability: File Inclusion</h1>

	{$WarningHtml}
<hr>
	<div class=\"vulnerable_code_area\">
		[<em><a href=\"?page=file1.php\">file1.php</a></em>] - [<em><a href=\"?page=file2.php\">file2.php</a></em>] - [<em><a href=\"?page=file3.php\">file3.php</a></em>]
<!--<a href=\"?page=file1.php\">file1.php</a>
	이렇게 해 놓으면 누르는 것 주소를 줄 수 있다
-->
	</div>

</div></body>\n";

?>
