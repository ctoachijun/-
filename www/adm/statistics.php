<?php

$sub_menu = "400010";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu400'][0][1];

$curr_title = "품목 별 거래량 및 평균단가";

include_once('./admin.head.php');

$cur_url = "./statistics.php";

// 검색된 품목을 오늘기준으로 3주전까지 주문수 추출
$arr_data = getWeekData($i_stx);

// 각주별로 변수에 대입 - 거래량
for($i=0; $i<count($arr_data[0]); $i++){
    $txt = "week".($i+1);
    $$txt = round(($arr_data[0][$i] / 1000),3);
}

// 각주별로 변수에 대입 - 평균단가
for($i=0; $i<count($arr_data[1]); $i++){
    $txt = "avg".($i+1);
    $$txt = round(($arr_data[1][$i] / 1000),3);
}

$tree_name = $arr_data[2];


?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="./jquery.jqplot.js"></script>
<script type="text/javascript" src="./plugins/jqplot.barRenderer.js"></script>
<script type="text/javascript" src="./plugins/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="./plugins/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="./plugins/jqplot.pointLabels.js"></script>


<div id="stati">

  <div class="st_head">
    <div class="i_search">
      <form name="isearch" id="isearch" action="./statistics.php" class="local_sch01 local_sch" method="post">
        <label for="i_stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="i_stx" id="i_stx" value="<?=$i_stx?>" placeholder="품목명으로 검색 해 주세요" required class="required frm_input" />
        <input type="hidden" id="t_name" value="<?=$tree_name?>" />
        <input type="hidden" class="w1" value="<?=$week1?>" />
        <input type="hidden" class="w2" value="<?=$week2?>" />
        <input type="hidden" class="w3" value="<?=$week3?>" />
        <input type="hidden" class="w4" value="<?=$week4?>" />
        <input type="hidden" class="a1" value="<?=$avg1?>" />
        <input type="hidden" class="a2" value="<?=$avg2?>" />
        <input type="hidden" class="a3" value="<?=$avg3?>" />
        <input type="hidden" class="a4" value="<?=$avg4?>" />

        <input type="submit" value="검색" class="btn_submit"/>
      </form>
    </div>
  </div>
<?

?>
  <div class="st_cont">
    <div class="l_cont" >
      <div class="sub_title">품목별 거래량</div>
      <div class="dan">단위(천주)</div>
        <div id="stick" style=""></div>
    </div>

    <div class="r_cont">
      <div class="sub_title">품목별 평균 단가</div>
      <div class="dan">단위(천원)</div>
      <div id="graph"></div>

    </div>

  </div>




<script>
$(document).ready(function(){

  let stx = $("#i_stx").val();
  let t_name = $("#t_name").val();
  let w1 = Number($(".w1").val());
  let w2 = Number($(".w2").val());
  let w3 = Number($(".w3").val());
  let w4 = Number($(".w4").val());

  let a1 = Number($(".a1").val());
  let a2 = Number($(".a2").val());
  let a3 = Number($(".a3").val());
  let a4 = Number($(".a4").val());

  if(stx){
    show_stick(w4,w3,w2,w1,t_name);
    show_line(a4,a3,a2,a1,t_name);
  }else{
    show_stick(0,0,0,0);
    show_line(0,0,0,00);
  }

});
</script>


<?php
include_once('./admin.tail.php');
?>
