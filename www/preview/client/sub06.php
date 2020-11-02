<?php

$today = date("Y-m-d");


include "../head.php"




?>

<style>
.content{background-color:#fff;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>견적의뢰서</h2>
</div>



<div class="wrap">
  <div class="sub06">
    <form method="POST" action="./sub_proc.php" name="esti_form">
    <h2>포레스트</h2>
    <p class="date"><?=$today?></p>

    <div class="work_na">
      <h4>공사명</h4>
      <div><input type="text" class="in_txt" maxlength="50" placeholder="공사명 입력" /></div>
    </div>

    <p class="notice">공사 등급과 수목 품목은 둘 중 한가지만 선택가능합니다.</p>

    <div class="choice">
      <div class="w_class">
        <div class="red" onclick="sel_w_class(1)"><p>관급공사 (A급 조경수)</p></div>
        <div class="non_mar" onclick="sel_w_class(2)"><p>사급공사 (B급 조경수)</p></div>
      </div>
      <div class="tree_ca">
        <div class="red2"><p>교목</p></div>
        <div class="non_mar2"><p>관목</p></div>
      </div>
    </div>

    <div class="size">
      <div class="size_title"><p>품목</p> <p>규격</p> <p>수량</p></div>
      <hr style="width:100%;margin:0 auto;border:1px solid #bbb;margin-top:5px;margin-bottom:10px;">
      <div><p>산철쭉</p> <p>H0.3 x W0.3</p> <p>5,000</p></div>
      <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
      <div class="input"><p>입력</p> <p>입력</p> <p>입력</p></div>
      <div class="add"><p>+품목 추가</p></div>
    </div>

    <div class="delivery_date">
      <div class="date">
        <p>납품현장</p><p>납품날짜</p><p>요청사항</p>
      </div>
      <div class="box">
        <div></div> <div><img src="/img/date_b.png" alt="납품 날짜"></div> <div></div>
      </div>
    </div>

    <div class="date_dead">
      <div>개찰 마감일</div>
      <div>2020-00-00<img src="/img/date_w.png" alt="개찰 마감일"></div>
    </div>

    <div class="click_box">
      <a href="./" class="back">뒤로가기</a>
      <a href="./sub07.php" class="enter">견적신청</a>
    </div>
    </form>
  </div>
</div>

<?include "./tail2.php"?>
