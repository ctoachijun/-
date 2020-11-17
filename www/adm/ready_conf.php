<?php

$sub_menu = "500300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu500'][0][1];

$curr_title = "서비스 준비 설정";

include_once('./admin.head.php');

$cur_url = "./ready_conf.php";

?>


<div id="ready_conf">

  <? conf_ready(); ?>

</div>

<?php
include_once('./admin.tail.php');
?>
