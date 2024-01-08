<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<body xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


</head>



<div class="body_padded">
    <h1>Vulnerability: Command Injection</h1>
    <div class="vulnerable_code_area">
        <h2>Ping a device</h2>
        <form name="ping" action="2-1.ci.php" method="post">
            <p> Enter an IP address:
                <input type="text" name="ip" size="30">
                <input type="submit" name="Submit" value="Submit">
            </p>
        </form>
    </div>


    <?php
//보안을 안하면 운영체제 명령어 입력시 위험해진다.
// 윈도우 기준 |dir ,리눅스 기준 cat /etc/passwd;
    if( isset( $_POST[ 'Submit' ]  ) ) {        //보냈다면
        // Get input
        $target = $_REQUEST[ 'ip' ];

        // Determine OS and execute the ping command.
        if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
            // Windows
            // stristr("12345","4"); 4를 포함해서 앞으로 출력
            //php_uname( 's' ) 운영체제 출력
            //운영체제가 'Windows NT' 라면
            $cmd = shell_exec( 'ping  ' . $target );
            //PHP상에서 쉘명령어에 대한 결과값을 웹상에 출력하는 명령어
        }
        else {
            // *nix
            $cmd = shell_exec( 'ping  -c 4 ' . $target );
        }

        // Feedback for the end user
        echo "<pre>{$cmd}</pre>";
    }

    ?>




</div>
</body>
</html>
