<?php

$sub_menu = "500120";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu500'][0][1];

$curr_title = "관리자 등록";

include_once('./admin.head.php');

$cur_url = "./add_admin.php";


$a_tel = hyphen_hp_number($admin_tel);
$adbox = getAdminInfo();

while($row = sql_fetch_array($adbox)){
  $idx = $row['idx'];
  $admin_id[$idx] = $row['admin_id'];
  $admin_name[$idx] = $row['admin_name'];
  $admin_tel[$idx] = $row['admin_tel'];
}


?>


<div id="add_admin">
  <div class="aad_content">
    <form method="post" name="add_admin_form" action="adm_proc.php" />
      <input type="hidden" name="type" value="add_admin" />
      <table class="aad_table">
        <tr>
          <td class="aad_head">No.</td>
          <td class="aad_head">ID</td>
          <td class="aad_head">관리자 이름</td>
          <td class="aad_head">휴대전화 번호</td>
        </tr>
  <?
      for($i=1; $i<7; $i++){
  ?>
        <tr>
          <td class="aad_cont num"><?=$i?></td>
          <td class="aad_cont id"><input type="text" name="admin_id<?=$i?>" value="<?=$admin_id[$i]?>" /></td>
          <td class="aad_cont name"><input type="text" name="admin_name<?=$i?>" value="<?=$admin_name[$i]?>" /></td>
          <td class="aad_cont tel"><input type="text" name="admin_tel<?=$i?>" maxlength="11" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$admin_tel[$i]?>" /></td>
        </tr>
  <?  } ?>
        <tr>
          <td class="aad_btn" colspan="4"><input type="submit" value="등록" /></td>
        </tr>
      </table>
    </form>

  </div>
</div>




<?php
include_once('./admin.tail.php');
?>
