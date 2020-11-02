<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

?>
<style>
.content{background-color:#F8F8F8;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>결제대기</h2>
</div>
<form name="payment_form" action="./proc.php" method="post" />
  <input type="hidden" name="w_type" value="m_payment" />
  <input type="hidden" name="tep" value="<?=$tep?>" />
  <input type="hidden" name="t_price" value="<?=$t_price?>" />
  <input type="hidden" name="e_idx" value="<?=$e_idx?>" />
  <input type="hidden" name="ep_idx" value="<?=$ep_idx?>" />
</form>

<div class="wrap">
  <div class="sub10">
    <h4>"결제 대기 중"</h4>
    <p>아래 계좌로 입금 후 입금확인 요청을 눌러주세요.</p>
    <p>입금 확인 후 농가에 발주됩니다.</p>
    <hr style="width:100%;margin:0 auto;margin-top:20px;margin-bottom:10px;">

    <div class="sub_check">
      <div><p>입금 금액</p> <p class="bold"><?=number_format($t_price)?><span>원</span></p></div>
      <div><p>입금 은행</p> <p class="bold">기업은행</p></div>
      <div><p>예금주</p> <p class="bold">(주) 제이엘조경유통</p></div>
      <div><p>계좌번호</p> <p class="bold">181-155453-04-017</p></div>
    </div>

    <div class="click_box">
      <a onclick="call_back()" class="left_click">결제요청 취소</a>
      <a onclick="submit_pay(2)" class="right_click">입금확인 요청</a>
    </div>
  </div>
</div>

<?include "./tail2.php"?>
