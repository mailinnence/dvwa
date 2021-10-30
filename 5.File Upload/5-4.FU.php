<!--
참조
https://haruhiism.tistory.com/120?category=832125


보안
1.무늬만 이미지 파일인 척하는 파일을 막기위하여 다시 이미지파일을 생성한다.
2.업로드된 파일의 이름을 랜덤하게 바꾼다. 즉...패쓰워드를 보안하는 것처럼 해시값을 준다.
  이렇게 하면 해커는 자신이 올린 파일을 찾을 수 없다.
3.업로드하는 폴더도 랜덤의 이름값을 주어 더욱더 찾을 수 없게 만든다

dvwa 외의 보안
4.업로드된 서버를 웹어플리케이션 서버와 분리한다.
5.업로드된 폴더의 실행권한을 막고 파일 인클루전 공격을 확실히 막아 설사 업로드되더라도 실행되지 않도록 철처히 막는다
6.백엔드에서 보안프로그램을 코딩하여 실시간으로 폴더의 파일에 올라오기전 확장자를 검사하여 해당되지 않는 확장자는 지우고 파일을 업로드한 ip를 차단한다.
-->



<!--php 보안
전체과정
파일이 업로드 되면
1.임시파일과 최종적으로 저장할 위치를 uniqid()+md5() 더 찾기 힘들도록 만든다
2.파일의 유형,파일이름의 확장자,이미지전용 함수 getimagesize()를 통해 검사
3.서버에서 imagecreatefromjpeg(), imagecreatefrompng() 함수를 호출하여 이미지 리소스를 생성하는 것이다.
  이렇게 생성된 이미지는 imagejpeg(), imagepng() 함수로 새로운 이미지로 만들어져 임시 파일에 저장된다.
  즉 사용자가 업로드한 파일을 기반으로 새 이미지를 만들어서 원본 대신 이를 저장하는 것이며 이 경우 사용자가 의도적이었든 비의도적이었든
  원래 파일에 남겨놨던 메타데이터들이 모두 버려지게 된다.
4.rename() 함수를 사용하여 이 임시 파일을 실제로 파일들이 저장될 디렉터리로 옮길 수 있는지 확인하고
  이동 시 그냥 덮어씌워 버리는 move_uploaded_file() 함수와 달리 이름 변경(또는 이동. 리눅스의 mv 명령을 생각하면 된다)
  함수를 통해 파일을 옮기는 것을 '시도'하여 만약 파일이 이미 존재한다면 에러 메시지와 함께 파일을 덮어 씌우지 않게 한다.
5.임시 파일은 unlink() 함수 호출을 통해 삭제함으로써 사용자가 업로드한 파일이 웹 서버에 더 이상 남아있지 않도록 한다
-->


<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: File Upload - impossible</h1>



    <?php
include "C:\\xampp\\htdocs\\3.dvwa\\1-0.token.php";
if( isset( $_POST[ 'Upload' ] ) ) {


    //파일업로드가 php 자체보안에서 가능한지 확인하는 함수
    $WarningHtml = '';
    if (!ini_get('allow_url_fopen')) {
        $WarningHtml .= "<div class=\"warning\">The PHP function <em>allow_url_fopen</em> is not enabled.</div>";
    }
    echo $WarningHtml;


    // Check Anti-CSRF token
    checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ]);
    if ($k==0){


    // File information
    $uploaded_name = $_FILES[ 'uploaded' ][ 'name' ];
    $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
    $uploaded_size = $_FILES[ 'uploaded' ][ 'size' ];
    $uploaded_type = $_FILES[ 'uploaded' ][ 'type' ];
    $uploaded_tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ];

    // Where are we going to be writing to?
    $target_path  ="C:\\xampp\\htdocs\\3.dvwa\\5.File Upload\\";
    //$target_path =  $target_path .$_FILES["uploaded"]["name"];
    $target_file   = '\\'. md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
    //확장자를 제외한 파일의 이름을 암호화하고 확장자를 붙인다
    //42de50254853b0b9a8cec04521b7a9f0.PNG

    //$temp_file     = (( ini_get( 'upload_tmp_dir' ) == '' ) ? ( sys_get_temp_dir() ) : ( ini_get( 'upload_tmp_dir' ) ) );
    $temp_file= "C:\\xampp\\htdocs\\100.temp\\";

    //temp_file >> 임시파일이라는 뜻
//------------------------------------------------------------------------
//물음표(?) 가 if를 대신하고, 콜론(:) 이 else문을 대신한다.
// a = "A";
// if ($a == "A") {echo "조건 만족"; }
// else { echo "조건 불만족"; }
//
// echo $a == "A" ? "조건 만족" : "조건 불만족";
//
//------------------------------------------------------------------------

    //ini_get() 는 ini_set() 소속 함수로 php.ini에 지정되어 있는 지시어의 값을 읽어오는 함수이다.
    //php.ini에 upload_tmp_dir 설정이 따로 되어있는게 없다면 파일업로드를 하는데 따로 파일을 업로드할 폴더를 따로 지정하지 못했다면
    //임시파일 보관에 사용할 폴더 경로를 반환하는 PHP 함수인 sys_get_temp_dir() 실행하여 따로 파일을 업로드할 폴더를 만들으라는 애기
    //그밖에라면 즉 파일업로드를 하는데 따로 파일을 업로드할 폴더를 따로 지정하였다면 ini_get( 'upload_tmp_dir' )를 설정 한대로
    //설정 위치ㄹ 업로드한다

    $temp_file    .= md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
    //임시파일에 확장자를 제외한 파일의 이름을 암호화하고 확장자를 붙인 (ex)42de50254853b0b9a8cec04521b7a9f0.PNG ) 파일로 경로를 잡으라는 뜻

    // Is it an image?
    if( ( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) &&
        ( $uploaded_size < 1000000 ) &&
        ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) &&
        getimagesize( $uploaded_tmp ) ) {

        //파일의 유형,파일이름의 확장자,이미지전용 함수 getimagesize()를 통해 검사

        // Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD)
        if( $uploaded_type == 'image/jpeg' ) {
            $img = imagecreatefromjpeg( $uploaded_tmp );
            //imagecreatefromjpeg — 파일 또는 URL에서 새 이미지를 만듭니다
            //imagecreatefromjpeg ( string $filename ) : resource
            //$filename=JPEG 이미지의 경로

            imagejpeg( $img, $temp_file, 100);
            //imagejpeg — 이미지를 브라우저 또는 파일로 임시파일로 출력
            //imagejpeg ( resource $image [, mixed $to = null [, int $quality = -1 ]] ) : bool
            //image = imagecreatetruecolor () 와 같은 이미지 생성 함수 중 하나에 의해 반환되는 이미지 리소스 입니다.
            //to = 파일을 저장할 경로 또는 열린 스트림 리소스 (이 함수가 반환 된 후 자동으로 닫힘)입니다. 설정하지 않거나 null 이면 원시 이미지 스트림이 직접 출력됩니다.
            //quality = quality 은 선택 사항이며 범위는 0 (최저 품질, 작은 파일)에서 100 (최고 품질, 가장 큰 파일)까지입니다. 기본값 ( -1 )은 기본 IJG 품질 값 (약 75)을 사용합니다.

        }
        else {
            $img = imagecreatefrompng( $uploaded_tmp );
            imagepng( $img, $temp_file, 9);
        }
        imagedestroy( $img );
        //
        //bool imagedestroy ( resource $image ) : 생성된 이미지 객체를 메모리에서 해제한다.


        // Can we move the file to the web root from the temp folder?
        if( rename( $temp_file, ( getcwd() . $target_file ) ) ) {

            //https://solbel.tistory.com/1691
            //rename('원본파일전체경로','변경후파일전체경로');
            //파일명 변경 함수
            //getcwd() >> 현재 작업 디렉토리를 얻는 PHP 함수  ex) C:\xampp\htdocs\3.dvwa
            //
            //C:\xampp\htdocs\100.temp\5ceee76a9e6c0a68fd95b69a204a20c1.PNG      이걸
            //C:\xampp\htdocs\3.dvwa\5.File Upload\5cf11a6c43959e991c85deec60019e33.PNG 이렇게 바꿔라
            //
            // Yes!
            echo  "<pre>";
            //echo   "{$target_path}";
            //상식적으로 파일이 어디에 업로드 되었는지 개발자는 절대 알려주지 않을 것이다!
            //공격을 할거라면 이 업로드 위치를 찾아야한다.!
            echo  " succesfully uploaded!</pre>";

        }
        else {
            // No
            echo '<pre>Your image was not uploaded.</pre>';
        }

        // Delete any temp files
        if( file_exists( $temp_file ) )
            unlink( $temp_file );
            //해당 파일 삭제 명령어

    }
    else {
        // Invalid file
        echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
    }
}
}

else
    echo "<h1>There is a problem with the token</h1>";

// Generate Anti-CSRF token
generateSessionToken();

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
            <?php echo tokenField()?>
        </form>

    </div>

</body>

</html>