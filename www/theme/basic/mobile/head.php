<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}



include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_THEME_PATH.'/mobile/proc.php');
include_once(G5_THEME_PATH.'/mobile/proc.lib.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');



$img_src = G5_THEME_URL."/img";
$file_src = G5_THEME_URL."/mobile/";
// $img_src = "../img";

// 현재 파일이름 추출
$curr_fname = end(explode("/",$_SERVER['SCRIPT_NAME']));
$box = explode("|",getImgName($curr_fname));

if($curr_fname == "index.php"){
  $h_class = "class='curr'";
}else if($curr_fname == "view_esti.php" || $curr_fname == "view_pesti.php" || $curr_fname == "esti_comp.php"){
  $e_class = "class='curr'";
}else if($curr_fname == "view_deta.php" || $curr_fname == "view_pdeta.php"){
  $d_class = "class='curr'";
}else if($curr_fname == "view_acco.php"){
  $a_class = "class='curr'";
}else if($curr_fname == "view_mypage.php" || $curr_fname == "view_pmypage.php" || $curr_fname == "pmypage_detail.php" || $curr_fname == "mypage_detail.php"){
  $m_class = "class='curr'";
}

$home_img = $box[0];
$esti_img = $box[1];
$detail_img = $box[2];
$acco_img = $box[3];
$myp_img = $box[4];


?>

<div class="content">
