<?php
include "config.php";    
include "util.php";      

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$data_no = $_POST['data_no']; 
$title = $_POST['title'];
$p_id = $_POST['p_id'];
$type_id = $_POST['type_id'];
$location = $_POST['location'];
$call_number = $_POST['call_number'];

mysqli_query($conn, "set autocommit = 0"); //추가
mysqli_query($conn, "set transaction isolation level serializable"); //추가
mysqli_query($conn, "begin"); //추가

$ret = mysqli_query($conn, "update data set title = '$title', p_id = $p_id, type_id = $type_id, location = '$location', call_number = '$call_number' where data_no = $data_no");


if(!$ret)
{
	mysqli_query($conn, "rollback"); //추가
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit"); //추가
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=data_list.php'>";
}

?>

