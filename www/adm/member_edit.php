<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu200'][$s_key][1];
$curr_title = "회원정보 수정";
include_once('./admin.head.php');

$sql = "SELECT * FROM f_partner WHERE idx = {$idx}";
$box = sql_fetch_array(sql_query($sql));

?>

<div id="member_edit">
  <div class="m_edit">
    <div class="e_content">
      <table>
        <tr class="tr_line">
          <th colspan="2">
            <div class="s_score">
              <span class="c_name"><?=$c_name?></span>
            </div>
          </th>
        </tr>
        <tr class="test">
          <td class="column">이름</td>
          <td><input type="text" name="name" value='<?=$box['name']?>' /></td>
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
          <td><input type="text" name="h_tel" value='<?=$box['h_tel']?>' /></td>
        </tr>
        <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
        <tr>
          <td class="column">사업장전화번호</td>
          <td><input type="text" name="c_tel" value='<?=$box['c_tel']?>' /></td>
        </tr>
        <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
        <tr>
          <td class="column">계좌은행</td>
          <td><input type="text" name="bank_name" value='<?=$box['bank_name']?>'/></td>
        </tr>
        <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
        <tr>
          <td class="column">계좌번호</td>
          <td><input type="text" name="bank_num" value='<?=$box['bank_num']?>' /></td>
        </tr>
        <tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>
      </table>
    </div>
    <div class="t_btn_box">
      <button class="t_btn" onclick="editp()">수정하기</button>
      <button class="t_btn" onclick="delp()">삭제하기</button>
    </div>

  </div>
</div>


<?php
include_once ('./admin.tail.php');
?>
