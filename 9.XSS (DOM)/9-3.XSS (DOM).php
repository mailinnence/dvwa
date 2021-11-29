<!--
선택을 아예 제한을 걸어두므로써 다른 값이 들어오지 못하도록 한다.
그러나 뚫린다.
방법은 주석을 이용하는 것
#<script>alert(333);</script>

#           은 php 의 주석
< !-- -- >  은 html,css,js 의 주석이다

#<script>alert(333);</script>
하면 뒤에 나올 php 코드는 무효화되지만
자바스크립트의 주석이 아니므로 그대로 발동되게 된다.
주석에 서로 다른점을 이용한 것이다.

-->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php
$b = setcookie("cookie",md5( uniqid() ), time()+300);
// Is there any input?
if ( array_key_exists( "default", $_GET ) && !is_null ($_GET[ 'default' ]) ) {

    # White list the allowable languages
    switch ($_GET['default']) {
        case "French":
        case "English":
        case "German":
        case "Spanish":
            //위 경우가 아니라면 무조건 English가 선택되도록 유도

            break;
        default:
            header ("location: ?default=English");
            exit;
    }
}

?>
    <script>alert(333);</script>


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
