<!--
https://webhack.dynu.net/?idx=20161227.001&print=friendly
<script>alert(document.cookie)</script>
자바스크립트 문이 실행된다.
고도의 자바스크립트 코딩 능력으로는 시스템을 거의 장악까지 할 수 있다.

-->


<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Reflected Cross Site Scripting (XSS) - low</h1>

    <div class="vulnerable_code_area">
        <form name="XSS" action="#" method="GET">
            <p>
                What's your name?
                <input type="text" name="name">
                <input type="submit" value="Submit">
            </p>
        </form>


        <?php
        header ("X-XSS-Protection: 0");;
        $b = setcookie("cookie",md5( uniqid() ), time()+300);

        // Is there any input?
        if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {

//----------------------------------------------------------------------------------------------------------------------------------
//              http://www.lug.or.kr/files/docs/PHP/function.array-key-exists.html
//              array_key_exists — 주어진 키와 인덱스가 배열에 존재하는지 확인
//              설명
//              bool array_key_exists ( mixed $key , array $search )
//              array_key_exists()는 주어진 key 가 배열 안에서 설정되어 있으면 TRUE를 반환한다. key 는 배열 인덱스로 사용할수 있는 어떤값이든 될수 있다.
//
//              인수
//              key                       search
//              확인할 값.                 확일할 키를 가진 배열.
//
//              반환값
//              성공할 경우 TRUE를, 실패할 경우 FALSE를 반환합니다.
//----------------------------------------------------------------------------------------------------------------------------------

            // Feedback for end user
            echo '<pre>Hello ' . $_GET[ 'name' ] . '</pre>';
        }
        ?>


    </div>
</body>

</html>



