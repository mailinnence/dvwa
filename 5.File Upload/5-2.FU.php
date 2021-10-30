<!--특정 확장자만 오도록 검사한다
파일의 타입을 검사하여 해당 타입이 아니면 업로드 불가능하게 만든다.
그러나 이 경우 패킷을 조작하면 쉽게 우회할 수 있다.
파일의 타입을 content-type 에서 판단하는데 패킷을 파일의 해당 타입외의 타입의 파일을
보내놓고는 패킷은 파일의 해당 타입의 확장자로 바꾸어 보내면 이를 쉽게 우회할 수 있다.
-->

<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: File Upload - middle</h1>



<?php


//파일업로드가 php 자체보안에서 가능한지 확인하는 함수
$WarningHtml = '';
if (!ini_get('allow_url_fopen')) {
    $WarningHtml .= "<div class=\"warning\">The PHP function <em>allow_url_fopen</em> is not enabled.</div>";
}
echo $WarningHtml;



if( isset( $_POST[ 'Upload' ] ) ) {
    // Where are we going to be writing to?
    $target_path  ="C:\\xampp\\htdocs\\3.dvwa\\5.File Upload\\";
    $target_path =  $target_path .$_FILES["uploaded"]["name"];

    // File information
    $uploaded_name = $_FILES[ 'uploaded' ][ 'name' ];
    $uploaded_type = $_FILES[ 'uploaded' ][ 'type' ];
    $uploaded_size = $_FILES[ 'uploaded' ][ 'size' ];

    //업로드하는 파일의 타입과 사이즈를 변수에 저장하여 조건에 해당될때만 파일이 업로드 되도록 한다.


    // Is it an image?
    if( ( $uploaded_type == "image/jpeg" || $uploaded_type == "image/png" ) &&
        ( $uploaded_size <  900000 ) ) {


        // Can we move the file to the upload folder?
        if( !move_uploaded_file( $_FILES[ 'uploaded' ][ 'tmp_name' ], $target_path ) ) {
            // No
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
    else {
        // Invalid file
        echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
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

