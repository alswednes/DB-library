<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from course";

    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>과목명</th>
            <th>학수번호</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='course_view.php?course_no={$row['course_no']}'>{$row['course_name']}</a></td>";
            echo "<td>{$row['code']}</td>";
            echo "<td width='17%'>
                <a href='course_form.php?course_no={$row['course_no']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['course_no']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(course_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "course_delete.php?course_no=" + course_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
