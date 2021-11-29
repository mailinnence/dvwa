<!--
https://webhack.dynu.net/?idx=20161227.001&print=friendly
특정 문자를 바꾸는 방법을 사용하였으나 조건을 우회 할수 있다.
이 경우 대문자로 바꾸거나
<SCRIPT>alert(document.cookie)</SCRIPT>
한 글자만 조건에 해당되지 않는다
<Script>alert(document.cookie)</Script>

문자를 대신하는 것은 조건을 우회 할 방법이 많아
근본적인 보안 방법이 아니다


-->


<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Reflected Cross Site Scripting (XSS) - middle</h1>

    <div class="vulnerable_code_area">
        <form name="XSS" action="#" method="GET">
            <p>
                What's your name?
                <input type="text" name="name">
                <input type="submit" value="Submit">
            </p>

        </form>

    </div>

    <?php

    header ("X-XSS-Protection: 0");
    $b = setcookie("cookie",md5( uniqid() ), time()+300);

    // Is there any input?
    if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
        // Get input
        $name = str_replace( '<script>', '', $_GET[ 'name' ] );

//     str_replace( 1번째 인수 : 변경대상 문자 , 2번째 인수 : 변경하려는 문자 , 3번째 인수 : 변수, replace가 바꾸고자 하는 문자열(변수수))


        // Feedback for end user
        echo "<pre>Hello ${name}</pre>";
    }

    ?>



</div>
</body>

</html>

