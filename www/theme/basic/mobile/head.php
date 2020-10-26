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

//$img_src = G5_PATH."/".G5_THEME_DIR."/basic/img";
$img_src = "../img";

// 현재 파일이름 추출
$curr_fname = end(explode("/",$_SERVER['SCRIPT_NAME']));
$box = explode("|",getImgName($curr_fname));

$home_img = $box[0];
$esti_img = $box[1];
$detail_img = $box[2];
$acco_img = $box[3];
$myp_img = $box[4];


?>

<body>
<div class="content">
