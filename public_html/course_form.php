<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력"; //default로 입력이다. 
$action = "course_insert.php";

if (array_key_exists("course_no", $_GET)) { // get이라는 array에서 key를 가지고 있다면 list parameter가 있는지 없는지를 check한다. 
    $course_no = $_GET["course_no"];
    $query =  "select * from course where course_no = $course_no"; // 이렇게 쿼리를 바꿔줌 -> 이미 db에 있는 정보를 불러온다.
    $res = mysqli_query($conn, $query);
    $course = mysqli_fetch_array($res);
    if(!$course) {
        msg("수업이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "course_modify.php";
}


?>
    <div class="container">
        <form name="course_form" action="<?=$action?>" method="post" class="fullwidth"> 
            <input type="hidden" name="course_no" value="<?=$course['course_no']?>"/>
            <h3>수업 정보 <?=$mode?></h3>
            <p>
                <label for="course_name">과목명</label>
                <input type="text" placeholder="과목명 입력" id="course_name" name="course_name" value="<?=$course['course_name']?>"/>
            </p>
            
            
            <p>
                <label for="code">학수번호</label>
                <input type="text" placeholder="학수번호 입력" id="code" name="code" value="<?=$course['code']?>"/>
            </p>
            
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p> 

            <script> // 제대로 입력했는지 검사해본다. 
                function validate() {
                    if(document.getElementById("course_name").value == "") {
                        alert ("과목명을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("code").value == "") {
                        alert ("학수번호를 입력해 주십시오"); return false;
                    }
                    return true; // true면 submit하면 action으로 간다. 
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>