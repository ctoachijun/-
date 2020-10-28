<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

$m_info = getInfo($mb_id,$mb_type);
$m_idx = $m_info['idx'];

$ep_box = getEpData($ep_idx);
$now = date("Y-m-d H:i:s");
$c_d = ceil( (strtotime($ep_box['e_date']) - strtotime($now)) / 86400 );
$e_date = $re['e_date'];
$ed_box = explode("-",$e_date);

$cnt = getNum($ep_idx);
// 발주 수목 품명 추출
for($i=0; $i<$cnt; $i++){
  $col_name = "item".($i+1);
  $tree_box[$i] = $ep_box[$col_name];
}

$ep_pidx = $ep_box['p_idx'];

?>
<style>
.content{background-color:#F8F8F8;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>견적비교</h2>
</div>

<div class="wrap sub08">
  <!-- 견적비교 top -->
  <div class="sub01_box">
    <div class="sub08_title">
      <h4 class="work_name"><?=$ep_box['w_name']?></h4>
      <p class="cut_date sub08_cut">마감까지 <?=$c_d?>일 남음</p>
    </div>

    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">

    <ul>
    <? for($a=0; $a<count($tree_box); $a++){ ?>
      <li><?=$tree_box[$a]?></li>
    <? } ?>
    </ul>

    <div>
      <img src="/img/date.png" alt="납품 날짜">
      <p>납품 날짜 : 2020년 3월 27일</p>
    </div>
    <div>
      <img src="/img/location.png" alt="납품 장소">
      <p>납품 장소 : <?=$ep_box['target']?></p>
    </div>
  </div>
  <!-- 견적비교 top 끝-->




  <div class="sub03_box">

<? getEstiPartner($ep_pidx,$ep_box['w_name'],$ep_box['ep_idx']) ?>

  </div>

</div>

<?include "./tail.php"?>
