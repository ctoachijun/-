<?php
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

if($mb_type=="member" || !$mb_type){
  // $url = G5_URL."/bbs/login.php?jt=p&back=y";
  $url = G5_URL."/bbs/logout.php?jt=p";
  alert("파트너 계정으로 로그인 해 주세요.",$url);
}

$pbox = getPartnInfo_id($mb_id);
$approval = $pbox['approval'];
if($approval == "N"){
  goto_url("./no_approval.php");
}

?>
<style>
.content{background-color:#F8F8F8;height:92vh;}
</style>
<input type="hidden" name="mb_id" value="<?=$mb_id?>" />
<input type="hidden" name="mb_type" value="<?=$mb_type?>" />
<input type="hidden" name="token" id="_token" />

<div class="header2">
  <img src="<?=$img_src?>/top_logo.png" alt="포레스트 로고">
</div>
<div class="header_back_p">
</div>

<div class="p_main">
<p class="w_text">받은 견적 의뢰서를 확인해보세요.</p>
<div class="main_bottom_box p_sub02">

  <? getNewEpInfo($mb_id,$no_deal) ?>

</div>
<a href="<?=$file_src?>partner/view_pesti.php"><p class="w_more">더 많은 견적의뢰서 확인하기 &#187;</p></a>
</div>
<!-- main top 끝 -->

<div>
<div class="main_bottom p_sub02">
  <h2>작업&#38;납품일지</h2>

  <? getDealList($mb_id) ?>
</div>
</div><!--main_bottom 끝-->

<script>

$(document).ready(function(){
  let mb_id = $("input[name=mb_id]").val();
  let mb_type = $("input[name=mb_type]").val();
  let gtoken = window.treenectp.postPushToken(mb_id);
  let token = gtoken;
  let box = {"exe_type":"get_token","mb_id":mb_id,"token":token,"mb_type":mb_type};

  $.ajax({
          url: "../ajax.proc.php",
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



<?include "./p_tail.php"?>
