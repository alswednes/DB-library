<?php
include "config.php";    
include "util.php";      

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$course_name = $_POST['course_name'];
$code = $_POST['code'];

mysqli_query($conn, "set autocommit = 0"); //추가
mysqli_query($conn, "set transaction isolation level serializable"); //추가
mysqli_query($conn, "begin"); //추가

$ret = mysqli_query($conn, "insert into course (course_name, code) values('$course_name', '$code')");

// 결과 확인
if(!$ret)
{
	mysqli_query($conn, "rollback"); //추가
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit"); //추가
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=course_list.php'>"; 
}

?>

