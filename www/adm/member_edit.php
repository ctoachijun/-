<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu200'][$s_key][1];
$curr_title = "회원정보 수정";
include_once('./admin.head.php');

if($type==2){
  $t_name = "f_member";
  $col_name = "m_";
}else{
  $t_name = "f_partner";
  $col_name = "c_";
}


$sql = "SELECT * FROM {$t_name} WHERE idx = {$idx}";
$box = sql_fetch($sql);

$b_name = $box['bank_name'];

$img_src = G5_THEME_URL."/img/forest/";
$pic1_src = $img_src.$box['pic1'];
$pic2_src = $img_src.$box['pic2'];
if($box['pic1']){
  $pic1_src = "<a href='{$pic1_src}' target='_blank'><img src='{$pic1_src}' /></a>";
}else{
  $pic1_src = "";
}
if($box['pic2']){
  $pic2_src = "<a href='{$pic2_src}' target='_blank'><img src='{$pic2_src}' /></a>";
}else{
  $pic2_src = "";
}

?>

<div id="member_edit">
  <div class="m_edit">

    <div class="e_head">
    </div>

    <div class="e_head_sub">
      <div class="b_btn_box">
        <button class="t_btn" onclick="move_back()">뒤로</button>
      </div>
      <div class="t_btn_box">
        <button class="t_btn" onclick="editp_exc(<?=$type?>)">수정하기</button>
      </div>
    </div>

    <div class="garo">
    <div class="e_content">
      <form method="POST" action="" name="exact" id="edit_post">
        <input type="hidden" name="idx" value="<?=$idx?>" />
        <input type="hidden" name="page_type" value="<?=$type?>" />
        <input type="hidden" name="w_type" />

        <table>
          <tr class="tr_line">
            <th colspan="2">
              <div class="s_score">
                <span class="c_name">정보 수정</span>
              </div>
            </th>
          </tr>
          <tr class="test">
            <td class="column">이름</td>
            <td><input type="text" name="m_name" value='<?=$box['m_name']?>' /></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td class="column">직급</td>
            <td><input type="text" name="position" value='<?=$box['position']?>' /></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td class="column">업체명</td>
            <td><input type="text" name="c_name" value='<?=$box['c_name']?>' /></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td rowspan="2" class="column">주소</td>
            <td><input type="text" name="addr1" value='<?=$box['addr1']?>'/></td>
          <tr>
            <td><input type="text" name="addr2" value='<?=$box['addr2']?> '/></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td class="column">휴대전화번호</td>
            <td><input type="text" name="m_tel" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="11" value='<?=$box['m_tel']?>' /></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td class="column">사업장전화번호</td>
            <td><input type="text" name="c_tel" value='<?=$box['c_tel']?>' /></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td class="column">계좌은행</td>
            <td>
              <select name="bank_name">
                <option value="부산" <? echo $b_name == "하나" ? "selected" : ""; ?> >부산</option>
                <option value="국민" <? echo $b_name == "국민" ? "selected" : ""; ?> >국민</option>
                <option value="신한" <? echo $b_name == "신한" ? "selected" : ""; ?> >신한</option>
                <option value="우리" <? echo $b_name == "우리" ? "selected" : ""; ?> >우리</option>
                <option value="하나" <? echo $b_name == "하나" ? "selected" : ""; ?> >하나</option>
                <option value="씨티" <? echo $b_name == "씨티" ? "selected" : ""; ?> >씨티</option>
                <option value="SC제일" <? echo $b_name == "SC제일" ? "selected" : ""; ?> >SC제일</option>
                <option value="기업" <? echo $b_name == "기업" ? "selected" : ""; ?> >기업</option>
                <option value="농협" <? echo $b_name == "농협" ? "selected" : ""; ?> >농협</option>
                <option value="산업" <? echo $b_name == "산업" ? "selected" : ""; ?> >산업</option>
                <option value="경남" <? echo $b_name == "경남" ? "selected" : ""; ?> >경남</option>
                <option value="대구" <? echo $b_name == "대구" ? "selected" : ""; ?> >대구</option>
                <option value="수협" <? echo $b_name == "수협" ? "selected" : ""; ?> >수협</option>
                <option value="광주" <? echo $b_name == "광주" ? "selected" : ""; ?> >광주</option>
                <option value="전북" <? echo $b_name == "전북" ? "selected" : ""; ?> >전북</option>
                <option value="제주" <? echo $b_name == "제주" ? "selected" : ""; ?> >제주</option>
                <option value="새마을금고" <? echo $b_name == "새마을금고" ? "selected" : ""; ?> >새마을금고</option>
                <option value="신협" <? echo $b_name == "신협" ? "selected" : ""; ?> >신협</option>
                <option value="우체국" <? echo $b_name == "우체국" ? "selected" : ""; ?> >우체국</option>
                <option value="카카오뱅크" <? echo $b_name == "카카오뱅크" ? "selected" : ""; ?> >카카오뱅크</option>
                <option value="케이뱅크" <? echo $b_name == "케이뱅크" ? "selected" : ""; ?> >케이뱅크</option>
              </select>
            </td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
          <tr>
            <td class="column">계좌번호</td>
            <td><input type="text" name="bank_num" value='<?=$box['bank_num']?>' /></td>
          </tr>
          <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
        </table>
      </form>
    </div>
    <div class="pic_up">
      <form method="POST" action="./adm_proc.php" onsubmit="return chkPic()" name="add_pics" enctype="multipart/form-data">
        <input type="hidden" name="idx" value="<?=$idx?>" />
        <input type="hidden" name="pic_1" value="<?=$box['pic1']?>" />
        <input type="hidden" name="pic_2" value="<?=$box['pic2']?>" />
        <input type="hidden" name="page_type" value="<?=$type?>" />
        <input type="hidden" name="type" value="add_pic" />
        <div class="photo">
          <div class="photo_box">
            <div class="photo_label">
              <label>사업자 등록증 사진</label>
            </div>
            <div class="file_custom1">
              <label for="pic1">+사진 추가하기</label>
              <input type="file" id="pic1" name="pic1" value="<?=$box['pic1']?>" />
            </div>
          </div>
          <div class="photo_box">
            <div class="photo_label">
              <label for="pic1">통장 사본 사진</label>
            </div>
            <div class="file_custom2">
              <label for="pic2">+사진 추가하기</label>
              <input type="file" id="pic2" name="pic2"  />
            </div>
          </div>
        </div>
        <div class="pic_sub">
          <input type="submit" name="up_pic" value="사진등록"/>
        </div>
      </form>
      <div class="view_pic">
        <div class="pic1"><?=$pic1_src?></div>
        <div class="pic2"><?=$pic2_src?></div>
      </div>
    </div>
    </div>

  </div>
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

function chkPic(){
  if(confirm("사진을 등록하시겠습니까?")){
    return true;
  }
  return false;
}


</script>

<?php
include_once ('./admin.tail.php');
?>
