<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력"; //default로 입력이다. 
$action = "product_insert.php";

if (array_key_exists("product_id", $_GET)) { // get이라는 array에서 key를 가지고 있다면 list parameter가 있는지 없는지를 check한다. 
    $product_id = $_GET["product_id"];
    $query =  "select * from product where product_id = $product_id"; // 이렇게 쿼리를 바꿔줌 -> 이미 db에 있는 정보를 불러온다.
    $res = mysqli_query($conn, $query);
    $product = mysqli_fetch_array($res);
    if(!$product) {
        msg("물품이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "product_modify.php";
}

$manufacturers = array(); // 처음엔 empty set임

$query = "select * from manufacturer"; // db server에서 가져온 것.
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $manufacturers[$row['manufacturer_id']] = $row['manufacturer_name'];
}
?>
    <div class="container">
        <form name="product_form" action="<?=$action?>" method="post" class="fullwidth"> 
            <input type="hidden" name="product_id" value="<?=$product['product_id']?>"/> // 필요한데 user가 볼필요는 없는 것
            <h3>상품 정보 <?=$mode?></h3> // 상품정보 입력 or 수정 mode를 결정
            <p>
                <label for="manufacturer_id">제조사</label>
                <select name="manufacturer_id" id="manufacturer_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($manufacturers as $id => $name) { // 하나하나 다 뱉어주는 것
                            if($id == $product['manufacturer_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="product_name">상품명</label>
                <input type="text" placeholder="상품명 입력" id="product_name" name="product_name" value="<?=$product['product_name']?>"/>
            </p>
            <p>
                <label for="product_desc">상품설명</label>
                <textarea placeholder="상품설명 입력" id="product_desc" name="product_desc" rows="10"><?=$product['product_desc']?></textarea>
            </p>
            <p>
                <label for="price">가격</label>
                <input type="number" placeholder="정수로 입력" id="price" name="price" value="<?=$product['price']?>" />
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p> // 여기 버튼에도 mode가 사용된다. 

            <script> // 제대로 입력했는지 검사해본다. 
                function validate() {
                    if(document.getElementById("manufacturer_id").value == "-1") {
                        alert ("제조사를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("product_name").value == "") {
                        alert ("상품명을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("product_desc").value == "") {
                        alert ("상품설명을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("price").value == "") {
                        alert ("가격을 입력해 주십시오"); return false;
                    }
                    return true; // true면 submit하면 action으로 간다. 
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>