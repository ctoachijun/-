<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div class="header">
  <h2>회원가입</h2>
</div>

<div class="wrap sub13">
  <div class="sub07">
    <img src="/img/check.png" alt="견적신청 완료">
    <h4>"회원가입 완료"</h4>
    <p>회원가입이 완료되었습니다.</p>

    <div class="click_box">
      <!-- <a href="./" class="ok">확인</a> -->
      <a href="<?=G5_URL ?>" class="go">홈으로</a>
    </div>
  </div>
</div>
