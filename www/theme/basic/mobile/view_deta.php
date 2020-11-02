<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";
?>

<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>거래내역</h2>
</div>

<div class="wrap">

<div class="sub02_box">

<? getEstiList($mb_id)?>

</div>


<?
 include G5_THEME_MOBILE_PATH."/tail2.php";
?>
