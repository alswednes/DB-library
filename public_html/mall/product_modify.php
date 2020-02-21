<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$product_id = $_POST['product_id']; // auto increment면 자동으로 인식. modify는 increment가 아님. 
$product_name = $_POST['product_name'];
$product_desc = $_POST['product_desc'];
$manufacturer_id = $_POST['manufacturer_id'];
$price = $_POST['price'];

$ret = mysqli_query($conn, "update product set product_name = '$product_name', product_desc = '$product_desc', manufacturer_id = $manufacturer_id, price = $price where product_id = $product_id");
// 받아서 update해준다. 

if(!$ret)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
}

?>

