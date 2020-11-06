<?php
include_once('./_common.php');
include "./_head.php";

include_once(G5_LIB_PATH.'/register.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 리퍼러 체크
referer_check();

if (!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

if ($w == 'u' && $is_admin == 'super') {
    if (file_exists(G5_PATH.'/DEMO'))
        alert('데모 화면에서는 하실(보실) 수 없는 작업입니다.');
}

if($w == 'u')
    $mb_id = isset($_SESSION['ss_mb_id']) ? trim($_SESSION['ss_mb_id']) : '';
else if($w == '')
    $mb_id = trim($_POST['mb_id']);
else
    alert('잘못된 접근입니다', G5_URL);

  // 인증번호 체크
  $sql = "SELECT cert_num FROM f_sms_cert WHERE cert_time = '{$cert_dt}' && cert_tel='{$mb_hp}'";
  $cbox = sql_fetch_array(sql_query($sql));
  $cert_num = $cbox['cert_num'];

  if(!$cert_num){
    alert("인증번호 인증시간이 지났습니다. 새로 받아주세요.");
  }
  if($cert_num != $con_hp){
    alert("인증번호가 일치하지 않습니다");
  }



if(!$mb_id)
  alert('회원아이디 값이 없습니다. 올바른 방법으로 이용해 주십시오.','');

  $mb_password    = trim($_POST['mb_password']);
  $mb_password_re = trim($_POST['mb_password_re']);
  $mb_name        = trim($_POST['mb_name']);
  $mb_nick        = trim($_POST['mb_nick']);
  $mb_email       = trim($_POST['mb_email']);
  $mb_sex         = isset($_POST['mb_sex'])           ? trim($_POST['mb_sex'])         : "";
  $mb_birth       = isset($_POST['mb_birth'])         ? trim($_POST['mb_birth'])       : "";
  $mb_homepage    = isset($_POST['mb_homepage'])      ? trim($_POST['mb_homepage'])    : "";
  $mb_tel         = isset($_POST['mb_tel'])           ? trim($_POST['mb_tel'])         : "";
  $mb_hp          = isset($_POST['mb_hp'])            ? trim($_POST['mb_hp'])          : "";
  $mb_zip1        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 0, 3) : "";
  $mb_zip2        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 3)    : "";
  $mb_addr1       = isset($_POST['mb_addr1'])         ? trim($_POST['mb_addr1'])       : "";
  $mb_addr2       = isset($_POST['mb_addr2'])         ? trim($_POST['mb_addr2'])       : "";
  $mb_addr3       = isset($_POST['mb_addr3'])         ? trim($_POST['mb_addr3'])       : "";
  $mb_addr_jibeon = isset($_POST['mb_addr_jibeon'])   ? trim($_POST['mb_addr_jibeon']) : "";
  $mb_signature   = isset($_POST['mb_signature'])     ? trim($_POST['mb_signature'])   : "";
  $mb_profile     = isset($_POST['mb_profile'])       ? trim($_POST['mb_profile'])     : "";
  $mb_recommend   = isset($_POST['mb_recommend'])     ? trim($_POST['mb_recommend'])   : "";
  $mb_mailling    = isset($_POST['mb_mailling'])      ? trim($_POST['mb_mailling'])    : "";
  $mb_sms         = isset($_POST['mb_sms'])           ? trim($_POST['mb_sms'])         : "";
  $mb_1           = isset($_POST['mb_1'])             ? trim($_POST['mb_1'])           : "";
  $mb_2           = isset($_POST['mb_2'])             ? trim($_POST['mb_2'])           : "";
  $mb_3           = isset($_POST['mb_3'])             ? trim($_POST['mb_3'])           : "";
  $mb_4           = isset($_POST['mb_4'])             ? trim($_POST['mb_4'])           : "";
  $mb_5           = isset($_POST['mb_5'])             ? trim($_POST['mb_5'])           : "";
  $mb_6           = isset($_POST['mb_6'])             ? trim($_POST['mb_6'])           : "";
  $mb_7           = isset($_POST['mb_7'])             ? trim($_POST['mb_7'])           : "";
  $mb_8           = isset($_POST['mb_8'])             ? trim($_POST['mb_8'])           : "";
  $mb_9           = isset($_POST['mb_9'])             ? trim($_POST['mb_9'])           : "";
  $mb_10          = isset($_POST['mb_10'])            ? trim($_POST['mb_10'])          : "";

  $mb_name        = clean_xss_tags($mb_name);
  $mb_email       = get_email_address($mb_email);
  $mb_homepage    = clean_xss_tags($mb_homepage);
  $mb_tel         = clean_xss_tags($mb_tel);
  $mb_zip1        = preg_replace('/[^0-9]/', '', $mb_zip1);
  $mb_zip2        = preg_replace('/[^0-9]/', '', $mb_zip2);
  $mb_addr1       = clean_xss_tags($mb_addr1);
  $mb_addr2       = clean_xss_tags($mb_addr2);
  $mb_addr3       = clean_xss_tags($mb_addr3);
  $mb_addr_jibeon = preg_match("/^(N|R)$/", $mb_addr_jibeon) ? $mb_addr_jibeon : '';

//===============================================================
//  본인확인
//---------------------------------------------------------------
$mb_hp = hyphen_hp_number($mb_hp);
if($config['cf_cert_use'] && $_SESSION['ss_cert_type'] && $_SESSION['ss_cert_dupinfo']) {
    // 중복체크
    $sql = " select mb_id from {$g5['member_table']} where mb_id <> '{$member['mb_id']}' and mb_dupinfo = '{$_SESSION['ss_cert_dupinfo']}' ";
    $row = sql_fetch($sql);
    if ($row['mb_id']) {
        alert("입력하신 본인확인 정보로 가입된 내역이 존재합니다.\\n회원아이디 : ".$row['mb_id']);
    }
}
if ($w == '' || $w == 'u') {

    if ($msg = empty_mb_id($mb_id))         alert($msg, "", true, true); // alert($msg, $url, $error, $post);
    if ($msg = valid_mb_id($mb_id))         alert($msg, "", true, true);
    if ($msg = count_mb_id($mb_id))         alert($msg, "", true, true);

    // 이름, 닉네임에 utf-8 이외의 문자가 포함됐다면 오류
    // 서버환경에 따라 정상적으로 체크되지 않을 수 있음.
    $tmp_mb_name = iconv('UTF-8', 'UTF-8//IGNORE', $mb_name);
    if($tmp_mb_name != $mb_name) {
        alert('이름을 올바르게 입력해 주십시오.');
    }


    if ($w == '' && !$mb_password)
        alert('비밀번호가 넘어오지 않았습니다.');
    if($w == '' && $mb_password != $mb_password_re)
        alert('비밀번호가 일치하지 않습니다.');

    if($jt=="m"){
      if ($msg = empty_mb_name($mb_name))       alert($msg, "", true, true);
    }
    if ($msg = empty_mb_email($mb_email))   alert($msg, "", true, true);
    if ($msg = valid_mb_email($mb_email))   alert($msg, "", true, true);
    if ($msg = prohibit_mb_email($mb_email))alert($msg, "", true, true);
    if ($msg = reserve_mb_id($mb_id))       alert($msg, "", true, true);
    // 휴대폰 필수입력일 경우 휴대폰번호 유효성 체크
    if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {
        if ($msg = valid_mb_hp($mb_hp))     alert($msg, "", true, true);
    }

    if ($w=='') {
        if ($msg = exist_mb_id($mb_id))     alert($msg);

        if (get_session('ss_check_mb_id') != $mb_id || get_session('ss_check_mb_nick') != $mb_nick || get_session('ss_check_mb_email') != $mb_email) {
            set_session('ss_check_mb_id', '');
            set_session('ss_check_mb_nick', '');
            set_session('ss_check_mb_email', '');

            alert('올바른 방법으로 이용해 주십시오.');
        }

        // 본인확인 체크
        if($config['cf_cert_use'] && $config['cf_cert_req']) {
            if(trim($_POST['cert_no']) != $_SESSION['ss_cert_no'] || !$_SESSION['ss_cert_no'])
                alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
        }


    } else {
        // 자바스크립트로 정보변경이 가능한 버그 수정
        // 닉네임수정일이 지나지 않았다면
        if ($member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400)))
            $mb_nick = $member['mb_nick'];
        // 회원정보의 메일을 이전 메일로 옮기고 아래에서 비교함
        $old_email = $member['mb_email'];
    }

    run_event('register_form_update_valid', $w, $mb_id, $mb_nick, $mb_email);

    // if ($msg = exist_mb_nick($mb_nick, $mb_id))     alert($msg, "", true, true);
    if ($msg = exist_mb_email($mb_email, $mb_id))   alert($msg, "", true, true);

}

// echo $w."<br>";
// echo $mb_id."<br>";
// echo $mb_password."<br>";
// echo $mb_hp."<br>";
// echo $mb_name."<br>";
// echo $mb_email."<br>";
//
// echo "<br>";
// print_r($_POST);
// echo "<br>";
// echo "<br>";
// print_r($_SESSION);
// echo "<br>";
// echo "<br>";
$register_action_url = "./register_form_update.php";

if($jt=="m"){
  $t_name1 = "기업명";
  $t_name2 = "대표자";
}else{
  $t_name1 = "농원명";
  $t_name2 = "농원주";
}



$sql = "SELECT * FROM f_agree";
$re = sql_fetch_array(sql_query($sql));
$content = $re['content'];


?>
<style>
.content{height:100%;}
.wrap{margin-top:8vh;padding:10px 20px;}
</style>

<div class="header">
  <h2>회원가입</h2>
</div>

<div class="wrap sign">
  <form name="fregisterform" id="fregisterform" action="<?=$register_action_url?>" onsubmit="return chk_agree(this);" method="post" enctype="multipart/form-data" autocomplete="off">
  <!-- <form name="fregisterform" id="fregisterform" action="./register_form_biz.php" onsubmit="return chk_agree(this);" method="post" enctype="multipart/form-data" autocomplete="off"> -->
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="jt" value="<?php echo $jt ?>">
    <input type="hidden" name="mb_id" value="<?php echo $mb_id ?>">
    <input type="hidden" name="position" value="<?php echo $position ?>">
    <input type="hidden" name="mb_password" value="<?php echo $mb_password ?>">
    <input type="hidden" name="mb_password_re" value="<?php echo $mb_password_re ?>">
    <input type="hidden" name="mb_hp" value="<?php echo $mb_hp ?>">
    <input type="hidden" name="mb_name" value="<?php echo $mb_name ?>">
    <input type="hidden" name="mb_email" value="<?php echo $mb_email ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php } ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면 ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="닉<?=date("Ymd_his")?>">
    <?php } ?>

    <h4>사업자 등록</h4>
    <label>사업자 등록번호</label>
    <input type="text" name="c_num" placeholder="번호 입력" numberOnly>
    <label><?=$t_name1?> (상호)</label>
    <input type="text" name="c_name" placeholder="기업명 입력">
    <label><?=$t_name2?> 성명</label>
    <input type="text" name="c_boss" placeholder="성명 입력">
    <label>사업장 주소</label>
    <input type="text" name="addr1" placeholder="동,길이름까지">
    <input type="text" name="addr2" placeholder="상세주소">
    <label>계좌번호 <span>(기업명과 예금주가 동일해야 함)</span></label><br>
    <select name="bank_name">
      <option value="부산">부산</option>
      <option value="국민">국민</option>
      <option value="신한">신한</option>
      <option value="우리">우리</option>
      <option value="하나">하나</option>
      <option value="씨티">씨티</option>
      <option value="SC제일">SC제일</option>
      <option value="기업">기업</option>
      <option value="농협">농협</option>
      <option value="산업">산업</option>
      <option value="경남">경남</option>
      <option value="대구">대구</option>
      <option value="수협">수협</option>
      <option value="광주">광주</option>
      <option value="전북">전북</option>
      <option value="제주">제주</option>
      <option value="새마을금고">새마을금고</option>
      <option value="신협">신협</option>
      <option value="우체국">우체국</option>
      <option value="카카오뱅크">카카오뱅크</option>
      <option value="케이뱅크">케이뱅크</option>
    </select>
    <input type="text" name="bank_num" placeholder="계좌번호 입력" class="bank">

    <div class="photo">
      <div class="photo_box">
        <div class="photo_label">
          <label>사업자 등록증 사진</label>
        </div>
        <div class="file_custom1">
          <label for="pic1">+사진 추가하기</label>
          <input type="file" id="pic1" name="pic1" value="사진 추가하기" />
        </div>
      </div>
      <div class="photo_box">
        <div class="photo_label">
          <label for="pic1">통장 사본 사진</label>
        </div>
        <div class="file_custom2">
          <label for="pic2">+사진 추가하기</label>
          <input type="file" id="pic2" name="pic2" value="사진 추가하기" />
        </div>
      </div>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="agree" name="agree" value="#3F60BF" checked>
      <p>이용약관 동의</p>
    </div>
    <div class="sign_notice">
      <p><?=$content?></p>
    </div>

    <input type="submit" class="sign_ok" value="가입완료"/>
  </form>
</div>

<script>

let sel_file;
$(document).ready(function(){
  $("#pic1").on("change", view_pic1);
  $("#pic2").on("change", view_pic2);
});

function view_pic1(e){
  let files = e.target.files;
  let filesArr = Array.prototype.slice.call(files);

  filesArr.forEach(function(f){
    if(!f.type.match("image.*")){
      alert("이미지파일을 선택 해 주세요.");
      return;
    }

    sel_file = f;
    let reader = new FileReader();
    reader.onload = function(e){
      $(".file_custom1").css({"background": "url("+e.target.result+")"});
      $(".file_custom1").css({"background-repeat": "no-repeat"});
      $(".file_custom1").css({"background-size": "contain"});
    }
    reader.readAsDataURL(f);

  });
}
function view_pic2(e){
  let files = e.target.files;
  let filesArr = Array.prototype.slice.call(files);

  filesArr.forEach(function(f){
    if(!f.type.match("image.*")){
      alert("이미지파일을 선택 해 주세요.");
      return;
    }

    sel_file = f;
    let reader = new FileReader();
    reader.onload = function(e){
      $(".file_custom2").css({"background": "url("+e.target.result+")"});
      $(".file_custom2").css({"background-repeat": "no-repeat"});
      $(".file_custom2").css({"background-size": "contain"});
    }
    reader.readAsDataURL(f);
  });
}

function chk_agree(f){

  // 사업자등록번호 검사
  if (f.w.value=='') {
      if (f.c_num.value.length < 1) {
          alert('사업자등록번호를 입력하십시오.');
          f.c_num.focus();
          return false;
      }
  }
  // 상호 검사
  if (f.w.value=='') {
      if (f.c_name.value.length < 1) {
          alert('기업명(상호)를 입력하십시오.');
          f.c_name.focus();
          return false;
      }
  }
  // 대표자 검사
  if (f.w.value=='') {
      if (f.c_boss.value.length < 1) {
          alert('대표자 성명을 입력하십시오.');
          f.c_boss.focus();
          return false;
      }
  }
  // 주소 검사
  if (f.w.value=='') {
      if (f.addr1.value.length < 1) {
          alert('사업장 주소를 입력하십시오.');
          f.addr1.focus();
          return false;
      }
  }
  // 계좌번호 검사
  if (f.w.value=='') {
      if (f.bank_num.value.length < 1) {
          alert('계좌번호를 입력하십시오.');
          f.bank_num.focus();
          return false;
      }
  }
  // 사업자등록번호 사진 검사
  if (f.w.value=='') {
      if (f.pic1.value.length < 1) {
          alert('사업자등록번호 사진을 입력하십시오.');
          f.pic1.focus();
          return false;
      }
  }
  // 통장 사진 검사
  if (f.w.value=='') {
      if (f.pic2.value.length < 1) {
          alert('통장사본 사진을 입력하십시오.');
          f.pic2.focus();
          return false;
      }
  }

  if($("input:checkbox[name=agree]").is(":checked") == false){
    alert("약관 동의를 해주세요.");
    return false;
  }

  return true;
}




</script>
