<?include "./head.php"?>
<style>
.content{height:100vh;}
.wrap{margin-top:8vh;padding:10px 20px;}
</style>

<div class="header">
  <h2>회원가입</h2>
</div>

<div class="wrap sign">
  <h4>회원정보</h4>
  <label>아이디</label>
  <input type="text" placeholder="아이디">
  <label>비밀번호</label>
  <input type="password" placeholder="비밀번호" required>
  <label>비밀번호 확인</label>
  <input type="password" placeholder="비밀번호">
  <label>휴대폰 번호</label>
  <input type="text" placeholder="'-'구분없이 입력">
  <label>인증번호</label>
  <input type="text" placeholder="인증번호 입력">
  <label>담당자 성명</label>
  <input type="text" placeholder="이름">
  <label>담당자 직책</label>
  <input type="text" placeholder="담당자 직책 입력">
  <label>담당자 이메일</label>
  <input type="text" placeholder="이메일 입력">
  <a href="./sign_up02.php" class="next">다음</a>
</div>
