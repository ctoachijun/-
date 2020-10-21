<?php

$sub_menu = "400100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu400'][0][1];

$curr_title = "가입자현황";

include_once('./admin.head.php');

$cur_url = "./new_member_list.php";


// 검색된 품목을 오늘기준으로 3주전까지 주문수 추출
$arr_data = getNewbiData();

// 각주별로 변수에 대입 - 거래량
for($i=1; $i<=count($arr_data[0]); $i++){
    $txt = "p_new".($i);
    $$txt = $arr_data[0][$i] / 10;
}

// 각주별로 변수에 대입 - 거래량
for($i=1; $i<=count($arr_data[1]); $i++){
    $txt = "m_new".($i);
    $$txt = $arr_data[1][$i] / 10;
}

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="./jquery.jqplot.js"></script>
<script type="text/javascript" src="./plugins/jqplot.barRenderer.js"></script>
<script type="text/javascript" src="./plugins/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="./plugins/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="./plugins/jqplot.pointLabels.js"></script>


<div id="newbi_stat">

  <div class="ns_head">
    <input type="hidden" class="p1" value="<?=$p_new1?>" />
    <input type="hidden" class="p2" value="<?=$p_new2?>" />
    <input type="hidden" class="p3" value="<?=$p_new3?>" />
    <input type="hidden" class="p4" value="<?=$p_new4?>" />
    <input type="hidden" class="m1" value="<?=$m_new1?>" />
    <input type="hidden" class="m2" value="<?=$m_new2?>" />
    <input type="hidden" class="m3" value="<?=$m_new3?>" />
    <input type="hidden" class="m4" value="<?=$m_new4?>" />
  </div>

  <div class="ns_cont">
    <div class="l_cont" >
      <div class="sub_title">농원 가입자</div>
      <div class="dan">단위(십명)</div>
      <div id="p_newbi" style=""></div>
    </div>

    <div class="r_cont">
      <div class="sub_title">고객 가입자</div>
      <div class="dan">단위(십명)</div>
      <div id="m_newbi"></div>
    </div>

  </div>

<script>
$(document).ready(function(){
  show_ns_stick();
});
</script>


<?php
include_once('./admin.tail.php');
?>
