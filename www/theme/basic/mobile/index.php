<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}
include_once(G5_THEME_MOBILE_PATH.'/head.php');

if(!$_SESSION['ss_mb_id'] && !$is_member){
  goto_url(G5_BBS_URL."/login.php");
}
if($_SESSION['ss_mb_id']){
  $mb_id = $_SESSION['ss_mb_id'];
}else{
  $mb_id = "";
}



?>

<style>
.content{background-color:#F8F8F8}
</style>
<div class="header2">
  <img src="<?=$img_src?>/top_logo.png" alt="포레스트 로고">
</div>
<div class="header_back"></div>

<div class="main_top">
  <div>
    <div class="main_top_p">
      <p>조경수 <span>비교견적</span>을</p>
      <p>받아보세요.</p>
    </div>

    <div class="main_top_btn">
      <a href="./sub06.php">견적 의뢰서 신청하기 &nbsp; &gt;</a>
    </div>
  </div>

  <div>
    <div class="main_top_p">
      <p>도착한 <span>견적서</span>를</p>
      <p>확인해보세요.</p>
      <img src="<?=$img_src?>/bell.png" alt="견적서 메세지함">
    </div>

    <div class="main_top_btn main_top_btn2" >
      <a href="./sub08.php">받은 견적서 확인하기 &nbsp; &gt;</a>
    </div>
  </div>
</div> <!--main_top 끝-->


<div class="main_bottom">
  <h2>내 거래 현황</h2>

  <div class="main_bottom_box">

    <table class="text_table">
      <tr>
        <td>
          <img src="<?=$img_src?>/f_ico.png" alt="포레스트 로고">
          <p class="partner">포레스트 공식 파트너</p>
        </td>
        <td class="right">
          <p class="partner tree">관목</p>
          <p class="partner work">관급공사 (A급 조경수)</p>
        </td>
      </tr>
      <tr>
        <td><a href="./"><a href="./"><a href="./sub12.php"><h4 class="farm_name">삼례농원</h4></a></a></a></td>
        <td><p class="com_date">입찰 : 2020-03-23</p></td>
      </tr>
      <tr>
        <td><p class="work_name">전주시립도서관 조경보수공사</p></td>
        <td><p class="cut_date">마감까지 4일 남음</p></td>
      </tr>
    </table>


    <hr style="width:100%;margin:0 auto;">

    <ul>
      <li>산철쭉</li>
      <li>백철쭉</li>
      <li>회양목</li>
      <li>남천</li>
      <li>화살나무</li>
    </ul>
    <?
print_r($_SERVER);

    ?>
    <div>
      <img src="<?=$img_src?>/date.png" alt="납품 날짜">
      <p>납품 날짜 : 2020년 3월 27일</p>
    </div>
    <div>
      <img src="<?=$img_src?>/location.png" alt="납품 장소">
      <p>납품 장소 : 전주시 완산구 완산동 곤지산4길 12</p>
      <p class="btn_date"><a href="./" class="change">납품 날짜 및 장소 변경</a></p>
    </div>

    <hr style="width:100%;margin:0 auto;margin-top:12px;margin-bottom:12px;">
    <a href="./" class="estimate"><img src="../img/memo.png" alt="견적서 확인">견적서 확인</a>
    <a href="./" class="cancel">거래 취소</a>
  </div>

  <div class="main_bottom_box">

    <table class="text_table">
      <tr>
        <td>
          <img src="<?=$img_src?>/f_ico.png" alt="포레스트 로고">
          <p class="partner">포레스트 공식 파트너</p>
        </td>
        <td class="right">
          <p class="partner tree">관목</p>
          <p class="partner work">관급공사 (A급 조경수)</p>
        </td>
      </tr>
      <tr>
        <td><a href="./"><a href="./sub12.php"><h4 class="farm_name">삼례농원</h4></a></a></td>
        <td><p class="com_date">입찰 : 2020-03-23</p></td>
      </tr>
      <tr>
        <td><p class="work_name">전주시립도서관 조경보수공사</p></td>
        <td><p class="cut_date">마감까지 4일 남음</p></td>
      </tr>
    </table>


    <hr style="width:100%;margin:0 auto;">

    <ul>
      <li>산철쭉</li>
      <li>백철쭉</li>
      <li>회양목</li>
      <li>남천</li>
      <li>화살나무</li>
    </ul>

    <div>
      <img src="<?=$img_src?>/date.png" alt="납품 날짜">
      <p>납품 날짜 : 2020년 3월 27일</p>
    </div>
    <div>
      <img src="<?=$img_src?>/location.png" alt="납품 장소">
      <p>납품 장소 : 전주시 완산구 완산동 곤지산4길 12</p>
      <p class="btn_date"><a href="./" class="change">납품 날짜 및 장소 변경</a></p>
    </div>

    <hr style="width:100%;margin:0 auto;margin-top:12px;margin-bottom:12px;">

    <a href="./" class="estimate"><img src="<?=$img_src?>/memo.png" alt="견적서 확인">견적서 확인</a>
    <a href="./" class="cancel">거래 취소</a>

  </div>

<?php

include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>
