<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("course_no", $_GET)) {
    $course_no = $_GET["course_no"];
    $query = "select * from course where course_no = $course_no";
    $res = mysqli_query($conn, $query);
    $course = mysqli_fetch_assoc($res);
    if (!$course) {
        msg("수업이 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>수업 정보 상세 보기</h3>

        <p>
            <label for="course_no">수업 코드</label>
            <input readonly type="text" id="course_no" name="course_no" value="<?= $course['course_no'] ?>"/>
        </p>
        
        <p>
            <label for="code">과목명</label>
            <input readonly type="text" id="course_name" name="course_name" value="<?= $course['course_name'] ?>"/>
        </p>

        <p>
            <label for="code">학수번호</label>
            <input readonly type="text" id="code" name="code" value="<?= $course['code'] ?>"/>
        </p>

        <p>
            <label for="material_no">수업 자료</label>
            <table class="table table-striped table-bordered">
        		<thead>
        		<tr>
        		   <th>No.</th>
        		   <th>자료명</th>
        		   <th>자료유형</th>
        		   <th>기능</th>
               </tr>
        </thead>
        <tbody>
        <?
        $query = "select * from course natural join material natural join data natural join type where course_no = $course_no";
    	$res = mysqli_query($conn, $query);
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='data_view.php?data_no={$row['data_no']}'>{$row['title']}</a></td>";
            echo "<td>{$row['data_type']}</td>";
            echo "<td width='17%'>
                 <button onclick='javascript:deleteConfirm({$row['material_no']}, {$row['course_no']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
        </p>
        
        <script>
        function deleteConfirm(material_no, course_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "material_delete.php?course_no=" + course_no +"&material_no=" + material_no;
            }else{   //취소
                return;
            }
        }
    </script>
    </div>
<? include("footer.php") ?>