<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("review_no", $_GET)) {
    $review_no = $_GET["review_no"];
    $query = "select * from review natural join data where review_no = $review_no";
    $res = mysqli_query($conn, $query);
    $review = mysqli_fetch_assoc($res);
    if (!$review) {
        msg("리뷰가 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>리뷰 정보 상세 보기</h3>

        <p>
            <label for="review_no">리뷰 번호</label>
            <input readonly type="text" id="review_no" name="review_no" value="<?= $review['review_no'] ?>"/>
        </p>

        <p>
            <label for="review_title">리뷰 제목</label>
            <input readonly type="text" id="review_title" name="review_title" value="<?= $review['review_title'] ?>"/>
        </p>

        <p>
            <label for="reviewer">작성자</label>
            <input readonly type="text" id="reviewer" name="reviewer" value="<?= $review['reviewer'] ?>"/>
        </p>

        <p>
            <label for="title">자료명</label>
            <input readonly type="text" id="title" name="title" value="<?= $review['title'] ?>"/>
        </p>

        <p>
            <label for="contents">리뷰 내용</label>
            <textarea readonly id="contents" name="contents" rows="10"><?= $review['contents'] ?></textarea>
        </p>

    </div>
<? include("footer.php") ?>