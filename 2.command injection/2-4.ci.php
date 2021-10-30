<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<body xmlns="http://www.w3.org/1999/xhtml">

<head>
</head>


    <?php
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
    if( isset( $_POST[ 'Submit' ]  ) ) {
        // Check Anti-CSRF token
       checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ]);

        // Get input
        $target = $_REQUEST[ 'ip' ];
        $target = stripslashes( $target );
        //stripslashes() 백슬러쉬 제거

        // Split the IP into 4 octects
        $octet = explode( ".", $target );
        //explode( "기준", 문지열 or 문자열을 담고 있는 변수 );
        //기준이 되는 기호나 문자로 문지열 or 문자열을 담고 있는 변수을 잘라서 배열화 시켜주는 함수

        // Check IF each octet is an integer
        if( ( is_numeric( $octet[0] ) ) && ( is_numeric( $octet[1] ) ) && ( is_numeric( $octet[2] ) ) && ( is_numeric( $octet[3] ) ) && ( sizeof( $octet ) == 4 ) && $k==0) {
            //is_numeric()
            // 데이터 타입이 숫자인지 확인해주는 함수 숫자면 1을 반환해준다.그 외라면 아무것도 반환하지 않는다.
            //sizeof( 배열 ) 이는 행의 갯수를 반환한다.

            $target = $octet[0] . '.' . $octet[1] . '.' . $octet[2] . '.' . $octet[3];

            // Determine OS and execute the ping command.
            if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
                // Windows
                $cmd = shell_exec( 'ping  ' . $target );
            }
            else {
                // *nix
                $cmd = shell_exec( 'ping  -c 4 ' . $target );
            }

            // Feedback for the end user
            echo "<pre>{$cmd}</pre>";
        }
        else {
            if ($k==0)
            // Ops. Let the user name theres a mistake
            echo '<pre>ERROR: You have entered an invalid IP.</pre>';

            else
                echo "<h1>There is a problem with the token</h1>";
        }
    }

    // Generate Anti-CSRF token
    generateSessionToken();

    ?>

<div class="body_padded">
    <h1>Vulnerability: Command Injection</h1>
    <div class="vulnerable_code_area">
        <h2>Ping a device</h2>
        <form name="ping" action="2-4.ci.php" method="post">
            <p> Enter an IP address:
                <input type="text" name="ip" size="30">
                <input type="submit" name="Submit" value="Submit">
                <?php echo tokenField()?>
            </p>
        </form>
    </div>



</div>
</body>
</html>
