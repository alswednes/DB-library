<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from review natural join data";

    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>리뷰 제목</th>
            <th>자료명</th>
            <th>작성자</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='review_view.php?review_no={$row['review_no']}'>{$row['review_title']}</a></td>";
            echo "<td><a href='data_view.php?data_no={$row['data_no']}'>{$row['title']}</a></td>";
            echo "<td>{$row['reviewer']}</td>";
            echo "<td width='17%'>
                <button onclick='javascript:deleteConfirm({$row['review_no']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(review_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "review_delete.php?review_no=" + review_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
