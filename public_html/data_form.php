<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력"; //default로 입력이다. 
$action = "data_insert.php";

if (array_key_exists("data_no", $_GET)) { // get이라는 array에서 key를 가지고 있다면 list parameter가 있는지 없는지를 check한다. 
    $data_no = $_GET["data_no"];
    $query =  "select * from data where data_no = $data_no"; // 이렇게 쿼리를 바꿔줌 -> 이미 db에 있는 정보를 불러온다.
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($res);
    if(!$data) {
        msg("자료가 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "data_modify.php";
}

$people = array(); // 처음엔 empty set임
$types = array();
$query = "select * from person"; // db server에서 가져온 것.
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $people[$row['p_id']] = $row['name'];
}

$query2 = "select * from type"; // db server에서 가져온 것.
$res2 = mysqli_query($conn, $query2);
while($row2 = mysqli_fetch_array($res2)) {
    $types[$row2['type_id']] = $row2['data_type'];
}

?>
    <div class="container">
        <form name="data_form" action="<?=$action?>" method="post" class="fullwidth"> 
            <input type="hidden" name="data_no" value="<?=$data['data_no']?>"/>
            <h3>자료 정보 <?=$mode?></h3>
            <p>
                <label for="title">자료명</label>
                <input type="text" placeholder="자료명 입력" id="title" name="title" value="<?=$data['title']?>"/>
            </p>
            
            <p>
                <label for="p_id">저자</label>
                <select name="p_id" id="p_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($people as $id => $name) { // 하나하나 다 뱉어주는 것
                            if($id == $data['p_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            
            <p>
                <label for="type_id">자료유형</label>
                <select name="type_id" id="type_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($types as $id => $name) { // 하나하나 다 뱉어주는 것
                            if($id == $data['type_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            
            <p>
                <label for="location">서가위치</label>
                <input type="text" placeholder="서가위치 입력" id="location" name="location" value="<?=$data['location']?>"/>
            </p>
            
            <p>
                <label for="call_number">청구번호</label>
                <input type="text" placeholder="청구번호 입력" id="call_number" name="call_number" value="<?=$data['call_number']?>"/>
            </p>
            
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p> 

            <script> // 제대로 입력했는지 검사해본다. 
                function validate() {
                    if(document.getElementById("title").value == "") {
                        alert ("자료명을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("p_id").value == "-1") {
                        alert ("저자를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("type_id").value == "-1") {
                        alert ("타입을 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("location").value == "") {
                        alert ("서가위치를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("call_number").value == "") {
                        alert ("청구번호를 입력해 주십시오"); return false;
                    }
                    return true; // true면 submit하면 action으로 간다. 
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>