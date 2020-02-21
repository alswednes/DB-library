<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>



<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from data natural join type natural join person";
	if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where title like '%$search_keyword%'";
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    <form action="data_list.php" method="post">
        <div class='container'>
            <input type="text" name="search_keyword" placeholder="자료명 검색">
        </div>
	</form><br>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>자료명</th>
            <th>저자</th>
            <th>자료유형</th>
            <th>서가위치</th>
            <th>청구번호</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='data_view.php?data_no={$row['data_no']}'>{$row['title']}</a></td>";
            echo "<td><a href='person_view.php?p_id={$row['p_id']}'>{$row['name']}</td>";
            echo "<td>{$row['data_type']}</td>";
            echo "<td>{$row['location']}</td>";
            echo "<td>{$row['call_number']}</td>";
            echo "<td width='17%'>
                <a href='data_form.php?data_no={$row['data_no']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['data_no']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(data_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "data_delete.php?data_no=" + data_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>



<? include("footer.php") ?>
