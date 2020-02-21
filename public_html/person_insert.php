<?php
include "config.php";    
include "util.php";     

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$name = $_POST['name'];
$birth_date = $_POST['birth_date'];
$death_date = $_POST['death_date'];
$country = $_POST['country'];

mysqli_query($conn, "set autocommit = 0"); //추가
mysqli_query($conn, "set transaction isolation level serializable"); //추가
mysqli_query($conn, "begin"); //추가

$ret = mysqli_query($conn, "insert into person (name, birth_date, death_date, country) values('$name', '$birth_date', '$death_date', '$country')");

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
    echo "<meta http-equiv='refresh' content='0;url=person_list.php'>";
}

?>

