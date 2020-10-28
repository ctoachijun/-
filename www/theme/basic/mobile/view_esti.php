<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";


?>
<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>받은견적</h2>
</div>

<div class="wrap">

<? myEstiList($mb_id) ?>


<?
 include G5_THEME_MOBILE_PATH."/tail.php";
?>
