<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력"; //default로 입력이다. 
$action = "material_insert.php";

if (array_key_exists("material_no", $_GET)) { // get이라는 array에서 key를 가지고 있다면 list parameter가 있는지 없는지를 check한다. 
    $material_no = $_GET["material_no"];
    $query =  "select * from material where material_no = $material_no"; // 이렇게 쿼리를 바꿔줌 -> 이미 db에 있는 정보를 불러온다.
    $res = mysqli_query($conn, $query);
    $material = mysqli_fetch_array($res);
    if(!$material) {
        msg("자료가 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "material_modify.php";
}

$courses = array(); // 처음엔 empty set임
$data = array();
$query = "select * from course"; // db server에서 가져온 것.
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $courses[$row['course_no']] = $row['course_name'];
}

$query2 = "select * from data"; // db server에서 가져온 것.
$res2 = mysqli_query($conn, $query2);
while($row2 = mysqli_fetch_array($res2)) {
    $data[$row2['data_no']] = $row2['title'];
}

?>
    <div class="container">
        <form name="material_form" action="<?=$action?>" method="post" class="fullwidth"> 
            <input type="hidden" name="material_no" value="<?=$material['material_no']?>"/>
            <h3>수업자료 정보 <?=$mode?></h3>
            
            <p>
                <label for="course_no">과목명</label>
                <select name="course_no" id="course_no">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($courses as $id => $name) { // 하나하나 다 뱉어주는 것
                            if($id == $courses['course_no']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            
            <p>
                <label for="data_no">자료명</label>
                <select name="data_no" id="data_no">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($data as $id => $name) { // 하나하나 다 뱉어주는 것
                            if($id == $data['data_no']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p> 

            <script> // 제대로 입력했는지 검사해본다. 
                function validate() {
                    if(document.getElementById("course_no").value == "-1") {
                        alert ("과목명을 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("data_no").value == "-1") {
                        alert ("자료명을 선택해 주십시오"); return false;
                    }
                    return true; // true면 submit하면 action으로 간다. 
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>