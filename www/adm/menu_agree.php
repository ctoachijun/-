<?php

$sub_menu = "500100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu500'][0][1];

$curr_title = "메뉴 및 약관";

include_once('./admin.head.php');

$cur_url = "./menu_agree.php";

?>


<div id="menu_agree">
  <div class="menu1">
    <? print_menu("ld"); ?>
  </div>
  <div class="menu2">
    <? print_menu("cb"); ?>
  </div>
  <div class="agree">
    <? print_agree(); ?>
  </div>
</div>

<?php
include_once('./admin.tail.php');
?>
