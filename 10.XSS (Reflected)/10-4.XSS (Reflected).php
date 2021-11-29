<!--
https://webhack.dynu.net/?idx=20161227.001&print=friendly
htmlspecialchars() 의 원리 + 유저토큰


-->


<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />
</head>
<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Reflected Cross Site Scripting (XSS) - impossible</h1>
    <?php
    include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
    // Is there any input?
    if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
        // Check Anti-CSRF token
        checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ]);

        // Get input
        $name = htmlspecialchars( $_GET[ 'name' ] );
        //http://www.w3big.com/ko/php/func-string-htmlspecialchars.html
        //특수문자를 변환시켜서 문자로만 출력되고 기능은 상실시키는 함수
        //          특수 문자			변환된 문자
        //          &(앰퍼샌드)		&amp;
        //          ""(겹따옴표)		&quot;
        //          ''(홑따옴표) 		&#039;
        //          <(미만) 			&lt;
        //          >(이상)			&gt;


        if($k==0) {
            echo "<pre>Hello ${name}</pre>";
        }
        else{
            echo "<h1>There is a problem with the token</h1>";
        }


    }

    // Generate Anti-CSRF token
    generateSessionToken();

    ?>

    <div class="vulnerable_code_area">
        <form name="XSS" action="#" method="GET">
            <p>
                What's your name?
                <input type="text" name="name">
                <input type="submit" value="Submit">
                <?php echo tokenField()?>
            </p>

        </form>

    </div>



</div>
</body>

</html>









