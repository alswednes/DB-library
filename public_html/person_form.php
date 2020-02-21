<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력"; //default로 입력이다. 
$action = "person_insert.php";

if (array_key_exists("p_id", $_GET)) { // get이라는 array에서 key를 가지고 있다면 list parameter가 있는지 없는지를 check한다. 
    $p_id = $_GET["p_id"];
    $query =  "select * from person where p_id = $p_id"; // 이렇게 쿼리를 바꿔줌 -> 이미 db에 있는 정보를 불러온다.
    $res = mysqli_query($conn, $query);
    $person = mysqli_fetch_array($res);
    if(!$person) {
        msg("인물이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "person_modify.php";
}

?>
    <div class="container">
        <form name="person_form" action="<?=$action?>" method="post" class="fullwidth"> 
            <input type="hidden" name="p_id" value="<?=$person['p_id']?>"/> 
            <h3>인물 정보 <?=$mode?></h3>
            <p>
                <label for="name">이름</label>
                <input type="text" placeholder="이름 입력" id="name" name="name" value="<?=$person['name']?>"/>
            </p>
            <p>
                <label for="birth_date">생년월일</label>
                <input type="text" placeholder="YYYY-MM-DD" id="birth_date" name="birth_date" value="<?=$person['birth_date']?>"/>
            </p>
            <p>
                <label for="death_date">사망년월일</label>
                <input type="text" placeholder="YYYY-MM-DD" id="death_date" name="death_date" value="<?=$person['death_date']?>"/>
            </p>
            <p>
                <label for="country">국적</label>
                <input type="text" placeholder="국적 입력" id="country" name="country" value="<?=$person['country']?>"/>
            </p>            

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p> 
            <script> // 제대로 입력했는지 검사해본다. 
                function validate() {
                    if(document.getElementById("name").value == "") {
                        alert ("이름을 입력해 주십시오"); return false;
                    }

                    return true; // true면 submit하면 action으로 간다. 
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>