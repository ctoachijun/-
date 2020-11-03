<?include "../head.php"?>
<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:7.5vh;}
</style>

<div class="header">
  <h2>입찰 취소</h2>
</div>

<div class="wrap p_sub07">
  <div class="sub07">
    <h4>입찰 취소  사유 선택</h4>
    <p>입찰 취소 사유를 선택해 주세요.</p>

    <select name="gray_select">
			<option value="기상악화로 인한 작업불가">기상악화로 인한 작업불가</option>
			<option value="제품 소진">제품 소진</option>
			<option value="작업량 초과">작업량 초과</option>
      <a href="./p_sub08.php"><option value="직접 입력">직접 입력</option></a>
		</select>

    <div class="click_box">
      <a href="./" class="ok">뒤로가기</a>
      <a href="./sub01.php" class="go">입찰취소</a>
    </div>
  </div>
</div><!-- 전체 끝 -->

<?include "./p_tail2.php"?>
