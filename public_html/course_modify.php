<?php
include "config.php";    
include "util.php";      

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$course_no = $_POST['course_no'];
$course_name = $_POST['course_name'];
$code = $_POST['code'];

mysqli_query($conn, "set autocommit = 0"); //추가
mysqli_query($conn, "set transaction isolation level serializable"); //추가
mysqli_query($conn, "begin"); //추가

$ret = mysqli_query($conn, "update course set course_name = '$course_name', code = '$code' where course_no = $course_no");


if(!$ret)
{
	mysqli_query($conn, "rollback"); //추가
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit"); //추가
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=course_list.php'>";
}

?>

