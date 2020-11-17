<?php
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

$return_url = $_SERVER['HTTP_REFERER'];
$sql = "SELECT * FROM f_wait_service";
$wbox = sql_fetch($sql);
$cur = $wbox['cur_partner'];
$max = $wbox['max_partner'];

?>

<style>
.content{background-color:#F8F8F8}
</style>


<div class="ready">
  <img src="<?=$img_src?>/new_backimg.jpg" />
  <div class="ready_head">
    <p class="head_txt">트리넥트에 농원 파트너가 되신 걸 축하합니다.</p>
  </div>
  <div class="ready_sub">
    <p class="sub_txt">트리넥트는 정직한 기준을 통해 신뢰와 품질을 우선으로<br>조경수 납품 경력과 노하우를 갖춘 농원만의 새로운<br>온라인 조경수 판매 판로입니다.</p>
  </div>
  <div class="ready_cont">
    <p class="cont_txt">트리넥트 서비스를 위해<br>농원 파트너스를 유치중이니<br>기다려주시면 감사하겠습니다.</p>
  </div>
  <div class="ready_sub_cont">
    <p class="sub_cont_txt"><?=$cur?> / <?=$max?></p>
  </div>
  <div class="ready_tail">
    <p class="tail_txt">이제는 조경수 판매도 온라인 시대<br>트리넥트가 함께합니다.</p>
  </div>

</div><!-- 전체 끝 -->




<?include "./p_tail3.php"?>
