<!--악성파일을 업로드하여 업로드 후 주소로 들어가서(그걸 알아내는 것도 중요) 파일을 실행시키는 원리-->
<!--웹언어로 커맨드창을 이용하면 서버를 거의 장악할 수 있다. -->


<!--파이썬 관련내용 보고와야하고-->
<!--impossible 보안이 총 3가지-->
<!--1.php 코드 파일경로 지정 + 서버에 올라온 파일이름 암호화-->
<!--2.웹어플레케이션과 서버를 분리하기-->
<!--3.서버측에 백엔드로 파일들 한번 더 거르기-->


<!--http://jun.hansung.ac.kr/SWP/PHP/PHP%20File%20Upload.html-->
<!--https://www.habonyphp.com/2019/02/post.html-->



<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: File Upload - low</h1>

    <?php
    //파일업로드가 php 자체보안에서 가능한지 확인하는 함수
    $WarningHtml = '';
    if( !ini_get( 'allow_url_fopen' ) ) {
        $WarningHtml .= "<div class=\"warning\">The PHP function <em>allow_url_fopen</em> is not enabled.</div>";
    }
    echo $WarningHtml;






    if( isset( $_POST[ 'Upload' ] ) ) {
        $target_path  ="C:\\xampp\\htdocs\\3.dvwa\\5.File Upload\\";;
        $target_path =  $target_path .$_FILES["uploaded"]["name"];
        // Can we move the file to the upload folder?
        if( !move_uploaded_file( $_FILES[ 'uploaded' ][ 'tmp_name' ], $target_path ) ) {
//            move_uploaded_file ( string $filename , string $destination )
//            move_uploaded_file()은 서버로 전송된 파일을 저장할 때 사용하는 함수

            // No
            echo $_FILES["uploaded"]["error"];
            echo '<pre>Your image was not uploaded.</pre>';
        }
        else {
            // Yes!
            echo  "<pre>";
            //echo   "{$target_path}";
            //상식적으로 파일이 어디에 업로드 되었는지 개발자는 절대 알려주지 않을 것이다!
            //공격을 할거라면 이 업로드 위치를 찾아야한다.!
            echo  " succesfully uploaded!</pre>";
        }
    }

    ?>
<br>
<hr>
    <br>
    <div class="vulnerable_code_area">
        <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

            Choose an image to upload:<br /><br />
            <input name="uploaded" type="file" /><br />
            <br />
            <input type="submit" name="Upload" value="Upload" />

        </form>

    </div>

</body>

</html>

