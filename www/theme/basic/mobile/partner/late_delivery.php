<?php
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

$return_url = $_SERVER['HTTP_REFERER'];

?>
<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:7.5vh;}
</style>

<input type="hidden" name="return" value="<?=$return_url?>" />
<div class="header">
  <h2>배송 지연</h2>
</div>

<div class="wrap p_sub07">
  <div class="sub07">
    <h4>배송 지연  사유 선택</h4>
    <p>배송 지연 사유를 선택해 주세요.</p>

    <? getSelMenu(2); ?>

    <div class="click_box">
      <a onclick="call_back()" class="ok">뒤로가기</a>
      <a onclick="cancel_late(2,<?=$e_idx?>)" class="go">배송지연</a>
    </div>
  </div>
</div><!-- 전체 끝 -->

<?include "./p_tail2.php"?>
