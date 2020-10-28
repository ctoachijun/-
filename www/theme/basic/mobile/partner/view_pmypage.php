<?
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

$p_info = getInfo($mb_id,$mb_type);
$p_idx = $p_info['idx'];
$alarm = $p_info['alarm'];
if($alarm=="Y"){
  $img_name = "on.jpg";
}else{
  $img_name = "off.jpg";
}

?>
<style>
.content{background-color:#F8F8F8}
</style>
<div class="header2">
  <h2>마이페이지</h2>
</div>
<div class="header_back"></div>

<div class="sub04">
  <input type="hidden" class="onoff" name="onoff" value="<?=$alarm?>" />
  <div class="main_top">
    <div>
      <ul class="sub04_top_my">
        <li class="write"><h4><?=$p_info['c_name']?></h4></li>
        <li><img src="<?=$img_src?>/admin.png" alt="admin"><p><?=$p_info['m_name']?></p></li>
        <li><img src="<?=$img_src?>/call.png" alt="연락처"><p><?=$p_info['m_tel']?></p></li>
        <li><img src="<?=$img_src?>/mail.png" alt="이메일"><p><?=$p_info['email']?></p></li>
      </ul>

      <div class="main_top_btn">
        <a href="./pmypage_detail.php">더 보기 &nbsp; &gt;</a>
      </div>
    </div>
  </div> <!--main_top 끝-->


  <div class="main_bottom">
    <h2>설정</h2>

    <div class="bottom_box">
      <p>알림</p>
      <div class="notice_btn right" onclick="alarmOnoff('<?=$mb_type?>',<?=$p_idx?>)">
        <img class="onoffBtn" src="<?=$img_src?>/<?=$img_name?>" />
      </div>
    </div>
    <!-- <div class="bottom_box">
      <p>고객센터</p>
      <p class="right">&gt;</p>
    </div> -->

  </div><!--main_bottom 끝-->



</div>
<?include "./p_tail.php"?>
