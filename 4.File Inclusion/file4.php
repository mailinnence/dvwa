<?php
$page['body']="";
global $page;
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Vulnerability: File Inclusion</h1>
	<div class=\"vulnerable_code_area\">
		<h3>File 4 (Hidden)</h3>
		<hr />
		Good job!<br />
		you accessed a hidden file<br />
		This file isn't listed at all on DVWA. If you are reading this, you did something right ;-)<br />
		<!-- You did an even better job to see this :-)! -->
</div>\n";

?>
