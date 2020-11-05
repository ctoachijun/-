<?php
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

?>
<style>
.content{background-color:#F8F8F8}
</style>
<div class="header2">
  <img src="<?=$img_src?>/top_logo.png" alt="포레스트 로고">
</div>
<div class="header_back">
</div>

<div class="p_main">
<p class="w_text">받은 견적 의뢰서를 확인해보세요.</p>
<div class="main_bottom_box p_sub02">

  <? getNewEpInfo($mb_id,$no_deal) ?>

</div>
<a href="<?=$file_src?>partner/view_pesti.php"><p class="w_more">더 많은 견적의뢰서 확인하기 &#187;</p></a>
</div>
<!-- main top 끝 -->

<div>
<div class="main_bottom p_sub02">
  <h2>작업&#38;납품일지</h2>

  <? getDealList($mb_id) ?>
</div>
</div><!--main_bottom 끝-->
<?include "./p_tail.php"?>
