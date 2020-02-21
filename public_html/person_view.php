<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("p_id", $_GET)) {
    $p_id = $_GET["p_id"];
    $query = "select * from person where p_id = $p_id";
    $res = mysqli_query($conn, $query);
    $person = mysqli_fetch_assoc($res);
    if (!$person) {
        msg("저자가 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>인물 정보 상세 보기</h3>

        <p>
            <label for="p_id">인물 코드</label>
            <input readonly type="text" id="p_id" name="p_id" value="<?= $person['p_id'] ?>"/>
        </p>

        <p>
            <label for="name">이름</label>
            <input readonly type="text" id="name" name="name" value="<?= $person['name'] ?>"/>
        </p>

        <p>
            <label for="birth_date">생년월일</label>
            <input readonly type="text" id="birth_date" name="birth_date" value="<?= $person['birth_date'] ?>"/>
        </p>

        <p>
            <label for="death_date">사망년월일</label>
            <input readonly type="text" id="death_date" name="death_date" value="<?= $person['death_date'] ?>"/>
        </p>
        
        <p>
            <label for="country">국적</label>
            <input readonly type="text" id="country" name="country" value="<?= $person['country'] ?>"/>
        </p>

        <p>
            <label for="data_no">저술 자료</label>
            <table class="table table-striped table-bordered">
        		<thead>
        		<tr>
        		   <th>No.</th>
        		   <th>자료명</th>
        		   <th>자료유형</th>
               </tr>
        </thead>
        <tbody>
        <?
        $query = "select * from person natural join data natural join type where p_id = $p_id";
    	$res = mysqli_query($conn, $query);
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='data_view.php?data_no={$row['data_no']}'>{$row['title']}</a></td>";
            echo "<td>{$row['data_type']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
        </p>

        
    </div>
<? include("footer.php") ?>