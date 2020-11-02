<?include "../head.php"?>
<style>
.content{height:100vh;}
.wrap{margin-top:8vh;padding:10px 20px;}
</style>

<div class="header">
  <h2>회원가입</h2>
</div>

<div class="wrap sign">
  <h4>사업자 등록</h4>
  <label>사업자 등록번호</label>
  <input type="text" placeholder="번호 입력">
  <label>기업명 (상호)</label>
  <input type="text" placeholder="기업명 입력">
  <label>대표자 성명</label>
  <input type="text" placeholder="성명 입력">
  <label>사업장 주소</label>
  <input type="text" placeholder="주소 입력">
  <label>계좌번호 <span>(기업명과 예금주가 동일해야 함)</span></label><br>
  <select name="bank">
  <option value="option1">국민</option>
  <option value="option2">하나</option>
  <option value="option3">우리</option>
  <option value="option4">부산</option>
  </select>
  <input type="text" placeholder="계좌번호 입력" class="bank">

  <div class="photo">
    <div class="photo_box">
      <label>사업자 등록증 사진</label>
      <div><p>+사진 추가하기</p></div>
    </div>
    <div class="photo_box">
      <label>통장 사본 사진</label>
      <div><p>+사진 추가하기</p></div>
    </div>
  </div>

  <div class="checkbox">
    <input type="checkbox" name="color" value="#3F60BF" checked>
    <p>이용약관</p>
  </div>
  <div class="sign_notice">
    <p>(주) 제이엘조경유통은 통신판매중개자이며 통신판매의 당사자가 아닙니다.<br>
    따라서 개별판매자가 등록하여 판매한 모든 상품에 대한 거래 정보 및 거래에 대한
    책임은 각 판매자가 부담하고, 이에 대하여 (주)제이엘조경유통은 일체 책임지지 않습니다.</p>
  </div>

  <a href="./sub13.php" class="sign_ok">가입완료</a>
</div>
