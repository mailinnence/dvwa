<?php
session_start();
function checkToken( $user_token, $session_token) {  # Validate the given (CSRF) token
    if( $user_token !== $session_token || !isset( $session_token ) ) {
        global $k;
        $k=1;
    }
    else if ( $user_token == $session_token || isset( $session_token ) ) {
        global $k;
        $k=0;
    }
}

//1.생성
function generateSessionToken() {  # Generate a brand new (CSRF) token

    if( isset( $_SESSION[ 'session_token' ] ) ) {
        destroySessionToken();
    }
    $_SESSION[ 'session_token' ] = md5( uniqid() );
}

//2.초기화
function destroySessionToken() {  # Destroy any session with the name 'session_token'
    unset( $_SESSION[ 'session_token' ] );
}

//구조상 난이도 별로 등장하게 만들기위해서 나온 코드
function tokenField() {  # Return a field for the (CSRF) token
    return "<input type='hidden' name='user_token' value='{$_SESSION[ 'session_token' ]}' />";
}


function dvwaMessagePush( $p )
{
    echo $p;
}


function &dvwaSessionGrab() {
    if( !isset( $_SESSION[ 'dvwa' ] ) ) {
        $_SESSION[ 'dvwa' ] = array();
    }
    return $_SESSION[ 'dvwa' ];
}

function dvwaCurrentUser() {
    $dvwaSession = dvwaSessionGrab();
    return ( isset( $dvwaSession[ 'username' ]) ? $dvwaSession[ 'username' ] : '') ;
}




function dvwaHtmlEcho( $pPage ) {
	echo "<!DOCTYPE html>
<html lang=\"en-GB\">
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	</head>
	<body class=\"home\">
			<div id=\"main_body\">
				{$pPage[ 'body' ]}
				<br /><br />
			</div>
		</div>
	</body>
</html>";
}














