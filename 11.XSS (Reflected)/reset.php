

<?php
include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";


$sql="delete from guestbook;";
mysqli_query($con, $sql);



?>

<script>

    setTimeout(" alert('리셋되었습니다');", 1000);
    self.close();


</script>