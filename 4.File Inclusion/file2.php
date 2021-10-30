<?php
$page['body']="";
global $page;
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Vulnerability: File Inclusion</h1>
	<div class=\"vulnerable_code_area\">
		<h3>File 2</h3>
		<hr />
		\"<em>이 페이지는 그냥 문자열 출력해주는 파일이라 따로 분석안해도 됨</em>\" ㅎㅎ<br /><br />
		[<em><a href=\"?page=include.php\">back</a></em>]	</div>


</div>\n";

?>
