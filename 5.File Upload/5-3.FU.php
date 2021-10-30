<!--1.
파일의 타입을 검사하는 것이 아닌 업로드한 파일의 확장자를 직접검사한다
getimagesize라는 함수를 이용하여 이미지가 아니라면 오류나는것을 이용하여 막는다

공격할 수 있다
그러러면
두 가지를 우회하고 연계 공격을 해야 하는데
먼저 우회를 하여 파일을 일단 업로드하려면
파일이름의 확장자와 getimagesize() 함수를 우회해야 한다
일단 middele 단계처럼 content-type을 검사하는게 아니고 파일의 이름을 검사하는 것이므로
a.php 를 a.php.jpg 로 바꾸고

GIF89a 라고 내용에 추가한다
이는 GIF 이미지 파일의 표준에 정의된 값
이를 파일 내용앞에다가 넣으면 이미지 파일인 것으로 인식한다

이렇게 우회하여 파일을 업로드하였지만
이는 jpg 확장자로 업로드되었기 때문에 업로드한 url로 들어가도 실행 시킬 수 없다
이때 전단원의 파일인루전 공격과 연계 공격을 하여야한다
때문에 당연히 해당 취약웹사이트가 파일인클루전 공격이 가능해야한다.

인클루드 파일을 이용하여 파일인루전 공격을 가하면 jpg로 확장자가 되어있어도 php로 넘어오게 된다
단 실행되서 넘어오는 것이기 떄문에 업로드한 파일이 form을 이용하여 작동하는 구조라면 form을 이용하지 말고
주소에 해당 변수의 값을 모두 주어 공격하는 방식으로 실행해야 한다.
쉽게 말해 넘어오고 나서는 조작이 불가능하니 넘어오기전에 전부 실행 조건을 맞추어 놓고 파일인루전 공격을 하여
넘어오게 하여야 한다.


공격은 서로 활용되기 떄문에
보안은 모든 면에서 최상급 보안을 유지해야한다



참조
https://www.habonyphp.com/2020/07/php-getimagesize.html
-->



<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body class="home">
<div class="body_padded">
    <h1>Vulnerability: File Upload - high</h1>


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
    $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
    //substr()은 문자열의 일부분을 추출하는 함수
    //substr( string, start [, length ] )
    //string : 추출의 대상이 되는 문자열입니다.
    //start : 추출을 시작하는 위치입니다.
    //length : 추출할 문자의 개수입니다.
    //         값이 없으면 문자열의 끝까지 추출합니다. 음수일 때는 위치를 뜻하고, 그 위치 앞까지의 문자를 추출합니다.
    //ex) substr( 'abcdefg', 3, 2 );   >>   abcdefg에서 3 위치의 문자 d부터 2개의 문자를 추출합니다. 즉, de입니다.
    //
    //strpos([대상 문자열], [조건 문자열], [검색 시작위치]);
    //strpos("php strpos", "strpos") >> 4
    //
    //즉 이 코드대로 진행된다면
    //예를 들어 abc.PNG 가 왔다고 해보자.
    //abc.PNG 는 즉 .가 시작하는 시작위치+1 이므로 확장자의 시작위치를 가져다 준다
    //그러므로 확장자의 시작위치부터 자르게 되면
    //업로드한 파일의 확장자를 변수에 저장하게 된다

    $uploaded_size = $_FILES[ 'uploaded' ][ 'size' ];
    $uploaded_tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ];


    // Is it an image?
    if( ( strtolower( $uploaded_ext ) == "jpg" || strtolower( $uploaded_ext ) == "jpeg" || strtolower( $uploaded_ext ) == "png" ) &&
        ( $uploaded_size < 1000000 ) &&
        getimagesize( $uploaded_tmp ) ) {
        //위 코드는 getimagesize(이미지)가  오게될때 이미지의 크기나 Type에 대한 정보를 반환하는 함수로 7개의 엘레먼트를 배열로 제공
        //$k=getimagesize( $uploaded_tmp ) 이라고 할때
        // $k[0]=Width 값,
        // $k[1]=Height 값,
        // $k[2]=Image Type Flag, 타입을 정수로 반환,
        //---------------------------------------------------------------------------------------
        // 1	    GIF
        // 2	    JPG
        // 3	    SWF
        // 4	    PSD
        // 5	    BMP
        // 6	    TIFF(orden de bytes intel)
        // 7	    TIFF(orden de bytes motorola)
        // 8	    JPC
        // 9	    JP2
        // 10	    JPX
        // 11	    JB2
        // 12	    SWC
        // 13	    IFF
        // 14       WBMP
        // 15	    XBM
        //---------------------------------------------------------------------------------------
        //
        // $k[3]=Width, Height값,
        // $k[bits]= bit
        // $k[channels]= channels Ex.) 3
        // $k[mime]=파일 mime-type Ex.) # "image/jpeg"
        // 를 반환한다
        // 즉 이 경우 이미지가 아니라면 함수에서 오류가 나기 때문에 이 점을 이용한 것이다.

        // Can we move the file to the upload folder?
        if( !move_uploaded_file( $uploaded_tmp, $target_path ) ) {
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