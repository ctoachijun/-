<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

?>
<style>
.content{background-color:#F8F8F8;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>결제완료</h2>
</div>

<div class="wrap">
  <div class="sub07">
    <img src="/img/check.png" alt="견적신청 완료">
    <h4>"결제 완료"</h4>
    <p>결제가 완료되었습니다.</p>
    <p>거래내역에서 진행상황을 확인해보세요!</p>

    <div class="click_box">
      <a href="<?=G5_URL?>" class="ok">확인</a>
      <a href="./view_deta.php" class="go">거래내역 가기</a>
    </div>
  </div>
</div>

<?include "./tail2.php"?>
