<?php
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>
<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>거래 내역</h2>
</div>

<div class="wrap p_sub02">

<? getDealList($mb_id) ?>

</div>

<?include "./p_tail2.php"?>
