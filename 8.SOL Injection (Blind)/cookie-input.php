<?php

function dvwaVersionGet() {
	return '1.10 *Development*';
}


function &dvwaPageNewGrab() {
	$returnArray = array(
		'title'           => 'Damn Vulnerable Web Application (DVWA) v' . dvwaVersionGet() . '',
		'title_separator' => ' :: ',
		'body'            => '',
		'page_id'         => '',
		'help_button'     => '',
		'source_button'   => '',
	);
	return $returnArray;
}

$page = dvwaPageNewGrab();
$page[ 'title' ] = 'Blind SQL Injection Cookie Input' . $page[ 'title_separator' ].$page[ 'title' ];

if( isset( $_POST[ 'id' ] ) ) {
	setcookie( 'id', $_POST[ 'id' ]);
	$page[ 'body' ] .= "Cookie ID set!<br /><br /><br />";
	$page[ 'body' ] .= "<script>window.opener.location.reload(true);</script>";
}

$page[ 'body' ] .= "
<form action=\"#\" method=\"POST\">
	<input type=\"text\" size=\"15\" name=\"id\">
	<input type=\"submit\" name=\"Submit\" value=\"Submit\">
</form>
<hr />
<br />

<button onclick=\"self.close();\">Close</button>";

dvwaSourceHtmlEcho( $page );

?>


