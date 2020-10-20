<?php

$sub_menu = "400000";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu400'][0][1];

$curr_title = "품목 별 거래량 및 평균단가";

include_once('./admin.head.php');

$cur_url = "./statistics.php";

?>

<div id="stati">

  <div class="st_head">
    <div class="i_search">
      <form name="isearch" id="isearch" action="./" class="local_sch01 local_sch" method="post">
        <label for="i_stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="i_stx" id="i_stx" value="<?=$i_stx?>" placeholder="품목명으로 검색 해 주세요" required class="required frm_input" />
        <input type="submit" value="검색" class="btn_submit" />
      </form>
    </div>
  </div>

  <div class="st_cont">
    <div class="l_cont">
    </div>
    <div class="r_cont">
    </div>

safdsfdsf

  </div>








</div>


<?php
include_once('./admin.tail.php');
?>
