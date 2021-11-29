<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <?php
    $b = setcookie("cookie",md5( uniqid() ), time()+300);
# Don't need to do anything, protction handled on the client side

?>


</head>
<body class="home">
<div class="body_padded">
    <h1>Vulnerability: DOM Based Cross Site Scripting (XSS)</h1>

    <div class="vulnerable_code_area">

        <p>Please choose a language:</p>

        <form name="XSS" method="GET">
            <select name="default">
                <script>
                    if (document.location.href.indexOf("default=") >= 0) {
                        var lang = document.location.href.substring(document.location.href.indexOf("default=")+8);
                        document.write("<option value='" + lang + "'>" + (lang) + "</option>");
                     //document.write("<option value='" + lang + "'>" + decodeURI(lang) + "</option>");
                     //디코딩을 해주고 있지 않다.그렇게되면 이안에 들어가는 모든요소는 url 인코딩된채 나오게 되고
                     //물론 이를 packet을 조작한다면 공격의 동작은 할 수있으나 공격은 주소를 보내야 하기에
                     //주소가 전부 url 인코딩으로 나오고 패킷과 다르게 전부 문자로 인식하기 때문에 공격이 불가능해진다.

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