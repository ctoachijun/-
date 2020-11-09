<?php
include "./head_sub.php";

?>
<style>
.content{height:100vh;}
</style>

<div class="login content">
  <img src="/img/logo.png" alt="트리넥트 로고">
  <div class="login_box">
    <form method="POST" action="./proc.php" name="login_data">
      <input type="hidden" name="work" value="login" />
      <!-- <div class="id">아이디</div> -->
      <input type="text" id='id' name="m_id" placeholder="아이디">
      <!-- <div class="password">비밀번호</div> -->
      <input type="password" id='pass' name="m_pass" placeholder="비밀번호">
      <div class="login_btn" onclick="submit_login()">로그인</div>
  </form>
  </div>

  <div class="checkbox">
    <input type="checkbox" name="keep" value="ok" checked>
    <p>로그인 상태 유지</p>
  </div>

  <form method="post" name="social_test" action="../skin/social/social_login.skin.php" />
  <input type="hidden" name="cf_social_login_use" value="yes" />
  <a href="./"><div class="sns_login">
    <div class="naver">
      <div class="img"><img src="/img/naver.png" alt="네이버 계정으로 로그인"></div>
      <div class="text"><p>네이버 계정으로 로그인</p></div>
    </div></a>

  </form>

  <a href="<?=$kakao_apiURL;?>"><div class="kakao">
    <div class="img"><img src="/img/kakao.png" alt="네이버 계정으로 로그인"></div>
    <div class="text"><p>카카오 계정으로 로그인</p></div>
    </div>
  </div></a>


  <div class="find">
    <a href="./">아이디 찾기</a>
    <a href="./">비밀번호 찾기</a>
    <a href="./sign_up.php">회원가입</a>
  </div>
</div><!-- 전체 콘텐츠 끝 -->
