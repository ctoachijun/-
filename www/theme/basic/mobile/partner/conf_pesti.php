<?php
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

?>
<style>
/* height:82vh -> v20 기준으로 딱 맞음. 크롬에서 s5나 다른기종으로하면 짧음 */
.content{background-color:#F8F8F8;height:91vh;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>견적확인</h2>
</div>

<div class="wrap p_sub06 p_sub12">
  <div class="p_sub02 p_sub05">
    <? getEstiConfirm($idx) ?>

    <div class="click_box">
      <a onclick="call_back()" class="back">뒤로 가기</a>
      <p onclick="submit_wpic()" class="enter">사진 저장</p>
    </div>
  </div>
</div>


<script>

<? setWpic() ?>

</script>


<?
  include_once("./p_tail2.php");
?>
