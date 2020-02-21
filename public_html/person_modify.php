<?php
include "config.php";    
include "util.php";      

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$p_id = $_POST['p_id']; 
$name = $_POST['name'];
$birth_date = $_POST['birth_date'];
$death_date = $_POST['death_date'];
$country = $_POST['country'];

mysqli_query($conn, "set autocommit = 0"); //추가
mysqli_query($conn, "set transaction isolation level serializable"); //추가
mysqli_query($conn, "begin"); //추가

$ret = mysqli_query($conn, "update person set name = '$name', birth_date = '$birth_date', death_date = '$death_date', country = '$country' where p_id = $p_id");

if(!$ret)
{
	mysqli_query($conn, "rollback"); //추가
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit"); //추가
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=person_list.php'>";
}

?>

