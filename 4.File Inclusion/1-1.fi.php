<?php

//받은 변수의 배열의 ['body'] 값을 가져오는 함수
function dvwaHtmlEcho( $pPage ) {
echo "<!DOCTYPE html>
<html lang=\"en-GB\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
</head>
<body class=\"home\">
<div id=\"main_body\">
    {$pPage[ 'body' ]}
    <br /><br />
</div>
</div>
</body>
</html>";
}