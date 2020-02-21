<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("data_no", $_GET)) {
    $data_no = $_GET["data_no"];
    $query = "select * from data natural join type natural join person where data_no = $data_no";
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($res);
    if (!$data) {
        msg("자료가 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>자료 정보 상세 보기</h3>

        <p>
            <label for="data_no">자료 코드</label>
            <input readonly type="text" id="data_no" name="data_no" value="<?= $data['data_no'] ?>"/>
        </p>

        <p>
            <label for="title">자료명</label>
            <input readonly type="text" id="title" name="title" value="<?= $data['title'] ?>"/>
        </p>
        
        <p>
            <label for="name">저자</label>
            <input readonly type="text" id="name" name="name" value="<?= $data['name'] ?>"/>
        </p>

        <p>
            <label for="data_type">자료유형</label>
            <input readonly type="text" id="data_type" name="data_type" value="<?= $data['data_type'] ?>"/>
        </p>

        <p>
            <label for="location">서가위치</label>
            <input readonly type="text" id="location" name="location" value="<?= $data['location'] ?>"/>
        </p>

        <p>
            <label for="call_number">청구번호</label>
            <input readonly type="text" id="call_number" name="call_number" value="<?= $data['call_number'] ?>"/>
        </p>
    </div>
<? include("footer.php") ?>