<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

?>
<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>거래처</h2>
</div>

<div class="wrap">


<? getAccoList($mb_id) ?>


</div>



<?
 include G5_THEME_MOBILE_PATH."/tail2.php";
?>
