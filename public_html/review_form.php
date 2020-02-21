<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력"; //default로 입력이다. 
$action = "review_insert.php";

$data = array();
$query = "select * from data"; // db server에서 가져온 것.
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $data[$row['data_no']] = $row['title'];
}

?>
    <div class="container">
        <form name="review_form" action="<?=$action?>" method="post" class="fullwidth"> 
            <input type="hidden" name="review_no" value="<?=$review['review_no']?>"/>
            <h3>리뷰 정보 <?=$mode?></h3>
            
            <p>
                <label for="review_title">리뷰 제목</label>
                <input type="text" placeholder="리뷰제목 입력" id="review_title" name="review_title" value="<?=$review['review_title']?>"/>
            </p>
            
            <p>
                <label for="reviewer">작성자</label>
                <input type="text" placeholder="작성자 입력" id="reviewer" name="reviewer" value="<?=$review['reviewer']?>"/>
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
            
            <p>
                <label for="contents">리뷰 내용</label>
                <textarea placeholder="리뷰내용 입력" id="contents" name="contents" rows="10"><?=$reivew['contents']?></textarea>
            </p>
            
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p> 

            <script> // 제대로 입력했는지 검사해본다. 
                function validate() {
                    if(document.getElementById("review_title").value == "") {
                        alert ("리뷰제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("reviewer").value == "") {
                        alert ("작성자를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("data_no").value == "-1") {
                        alert ("자료명을 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("contents").value == "") {
                        alert ("리뷰내용을 입력해 주십시오"); return false;
                    }
                    return true; // true면 submit하면 action으로 간다. 
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>