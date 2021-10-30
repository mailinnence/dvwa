<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upfile_name = $_FILES['upload']['name'];
    $upfile_name =file_upload_validation($upfile_name);
}



function file_upload_validation($upfile_name)
{
    $file_dir = "C:\\xampp\\htdocs\\3.dvwa\\5.File Upload\\";
    $file_path = $file_dir.$_FILES["upload"]["name"];
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $file_path)) {
        return $_FILES["upload"]["name"];
    } else {
        echo "파일 업로드 오류가 발생했습니다!!!";
    }
}
?>

<form name="k" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    이미지 업로드 : <input type="file" name="upload"><br><br>
    <input type="submit">
</form>

<?php

if (isset($upfile_name)) {
    echo "업로드 파일: "."<img src=".$upfile_name.'?>';   //모르겠음 그리고 된다해도 이미지가 나오지 않는 이유???



}
?>


