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

if($auto_login=="on"){
  set_cookie('ck_mb_id', $mb['mb_id'], 86400 * 31);
  $_COOKIE['ck_mb_id'] = $mb_id;
}
// print_r($_COOKIE);
// echo "<br>====================<br>";


if($mb_type=="partner"){
  $url = G5_URL."/bbs/logout.php?jt=m";
  alert("고객 계정으로 로그인 해 주세요.",$url);
}

$jud = getNewEsti($mb_id);

if($jud > 0){
  $bell_img = "bell_n.png";
}else{
  $bell_img = "bell.png";
}

?>


<style>
.content{background-color:#F8F8F8; height:92vh;}
</style>

<input type="hidden" name="mb_id" value="<?=$mb_id?>" />
<input type="hidden" name="mb_type" value="<?=$mb_type?>" />
<input type="hidden" name="token" id="_token" />

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
      <a href="<?=$file_src?>estimate_plz.php">견적 의뢰서 신청하기 &nbsp; &gt;</a>
    </div>
  </div>

  <div>
    <div class="main_top_p">
      <p>도착한 <span>견적서</span>를</p>
      <p>확인해보세요.</p>
      <img src="<?=$img_src?>/<?=$bell_img?>" alt="견적서 메세지함">
    </div>

    <div class="main_top_btn main_top_btn2" >
      <a href="<?=$file_src?>view_esti.php">받은 견적서 확인하기 &nbsp; &gt;</a>
    </div>
  </div>
</div> <!--main_top 끝-->


<div class="main_bottom">
  <h2>내 거래 현황</h2>

<? getEstiList($mb_id)?>


</div>

<script>

$(document).ready(function(){
  let mb_id = $("input[name=mb_id]").val();
  let mb_type = $("input[name=mb_type]").val();
  let gtoken = window.treenectc.postPushToken(mb_id);
  let token = gtoken;

  let box = {"exe_type":"get_token","mb_id":mb_id,"token":token,"mb_type":mb_type};
  $.ajax({
          url: "theme/basic/mobile/ajax.proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    if(json.state=="Y"){
      // alert("등록했습니다.");
    }else{
      // alert("등록에 실패했습니다.");
    }
  });


});

</script>



<?
  include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>
