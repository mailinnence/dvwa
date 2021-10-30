<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<body xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


</head>



<div class="body_padded">
    <h1>Vulnerability: Command Injection</h1>
    <div class="vulnerable_code_area">
        <h2>Ping a device</h2>
        <form name="ping" action="2-2,3.ci.php" method="post">
            <p> Enter an IP address:
                <input type="text" name="ip" size="30">
                <input type="submit" name="Submit" value="Submit">
            </p>
        </form>
    </div>


    <?php
    if( isset( $_POST[ 'Submit' ]  ) ) {
        // Get input
        $target = $_REQUEST[ 'ip' ];

        // Set blacklist
        $substitutions = array(
            '&&' => '',
            ';'  => '',
            '&'  => '',
            ';'  => '',
            '| ' => '', //띄어 쓰기도 문자열로 인식하여 '|' 와 '| '는 다른 것이다. 주의하도록 하자
            '-'  => '',
            '$'  => '',
            '('  => '',
            ')'  => '',
            '`'  => '',
            '||' => '',
        );

        // Remove any of the charactars in the array (blacklist).
        $target = str_replace( array_keys( $substitutions ), $substitutions, $target );
//-------------------------------------------------------------------------------------------------------
//        str_replace ( $search , $replace , $subject , $count );
//        search	찾을 문자나 문자열 또는 그들을 담은 배열      array_keys( $substitutions ) >> '&&' ,';'
//        replace	교체할 문자열                             $substitutions               >> ' '
//        subject	교체 대상이 되는 문자열                    $target                       >> $_POST[ 'Submit' ]
//        count	    교체된 문자열의 수를 반환
//-------------------------------------------------------------------------------------------------------

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
    ?>




</div>
</body>
</html>
