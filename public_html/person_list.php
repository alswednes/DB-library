<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from person";

    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>이름</th>
            <th>출생년월일</th>
            <th>사망년월일</th>
            <th>국적</th>
			<th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='person_view.php?p_id={$row['p_id']}'>{$row['name']}</a></td>";
            echo "<td>{$row['birth_date']}</td>";
            echo "<td>{$row['death_date']}</td>";
            echo "<td>{$row['country']}</td>";
            echo "<td width='17%'>
                <a href='person_form.php?p_id={$row['p_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['p_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(p_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "person_delete.php?p_id=" + p_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
