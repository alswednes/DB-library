﻿<?php
include "config.php";    
include "util.php";     

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$data_no = $_GET['data_no'];

mysqli_query($conn, "set autocommit = 0"); //추가
mysqli_query($conn, "set transaction isolation level serializable"); //추가
mysqli_query($conn, "begin"); //추가

$ret = mysqli_query($conn, "delete from data where data_no = $data_no");

if(!$ret)
{
	mysqli_query($conn, "rollback"); //추가
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit"); //추가
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=data_list.php'>";
}

?>

