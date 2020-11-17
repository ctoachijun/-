<?php

$sub_menu = "500400";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu500'][0][1];

$curr_title = "수수료 설정";

include_once('./admin.head.php');

$cur_url = "./fee_modify.php";

?>


<div id="fee_modify">
  <div class="fee fm">
    <? modify_fee_m(); ?>
  </div>
  <div class="fee fp">
    <? modify_fee_p(); ?>
  </div>

</div>

<?php
include_once('./admin.tail.php');
?>
