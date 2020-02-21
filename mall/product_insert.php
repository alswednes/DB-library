<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$product_name = $_POST['product_name'];
$product_desc = $_POST['product_desc'];
$manufacturer_id = $_POST['manufacturer_id'];
$price = $_POST['price']; //post로 받을 수 있는 이유는 product form에서 method가 post였기 때문 

$ret = mysqli_query($conn, "insert into product (product_name, product_desc, manufacturer_id, price, added_datetime) values('$product_name', '$product_desc', '$manufacturer_id', '$price', NOW())");

// 결과 확인
if(!$ret)
{
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>"; // 새로고침하고 product list로 이동한다.
}

?>

