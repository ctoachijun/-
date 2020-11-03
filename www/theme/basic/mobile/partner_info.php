<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

$partn = getPartnInfo($idx);
$m_idx = getMbIdx($mb_id);
// 농원 평가 정보 - 코멘트가 공백이 아닌것
$sql = "SELECT * FROM f_partner_ship WHERE p_idx = {$idx}";
$re = sql_query($sql);
$pscore_num = sql_num_rows($re);
if(!$pscore_num){
  $pscore_num = 0;
}


// 평균 평점계산
$t_point = 0;
while($row = sql_fetch_array($re)){
  $t_point += $row['point'];
}
$t_point /= $pscore_num;
$t_point = round($t_point, 1);

if($pscore_num == 0){
    $t_point = "-";
}

$o_num = getOrderNum($idx);

?>


<style>
.content{background-color:#F8F8F8;}
.wrap{margin-top:7vh;}
</style>

<div class="header">
  <img onclick="call_back()" src="<?=$img_src?>/left.png" alt="뒤로가기">
  <h2><?=$partn['c_name']?></h2>
</div>

<div class="wrap sub12">
  <div class="address">
    <div>
      <img src="<?=$img_src?>/location_b.png" alt="농원 주소">
      <p><?=$partn['addr1']?><?=$partn['addr2']?></p>
    </div>
    <div>
      <img src="<?=$img_src?>/admin.png" alt="대표자">
      <p><?=$partn['c_boss']?></p>
    </div>
    <div class="ad_btn">
      <div class="bg_blue" onclick="addPartner(<?=$idx?>,<?=$m_idx?>,1)">+거래처 등록</div>
      <div onclick="addPartner(<?=$idx?>,<?=$m_idx?>,2)">거래처 삭제</div>
    </div>
  </div>

  <div class="big_score">
  <div class="score_box">
    <div>
    <div>
      <h4 class="score"><?=$t_point?></h4>
      <p>평점</p>
    </div>
    <div>
      <h4><?=$o_num?></h4>
      <p>납품횟수</p>
    </div>
    <div>
      <h4><?=$pscore_num?></h4>
      <p>후기</p>
    </div>
    </div>
  </div>
  </div>

  <h4 class="sub12_title">후기<span class="bold"> <?=$pscore_num?></span> 건</h4>
  <div class="review">

    <? getReply($idx) ?>

    <!-- <p class="review_add">후기 더보기</p> -->

    <h4 class="sub12_title">납품<span class="bold"> <?=$o_num?></span> 건</h4>
    <div class="delivery">

    <? getOrderComp($idx) ?>

    </div>

  </div>

<?include "./tail2.php"?>
