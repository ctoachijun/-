<?php
include G5_PATH."/_common.php";

function getImgName($curr_fname){
  $home_img = "home";
  $esti_img = "g_esti";
  $detail_img = "g_detail";
  $acco_img = "account";
  $myp_img = "mypage";

  switch($curr_fname){
    case "index.php" :
      $home_img .= "_h";
    break;
    case "view_esti.php" :
      $esti_img .= "_h";
    break;
    case "view_detail.php" :
      $detail_img .= "_h";
    break;
    case "account.php" :
      $acco_img .= "_h";
    break;
    case "mypage.php" :
      $myp_img .= "_h";
    break;
  }

  $return_string = $home_img."|".$esti_img."|".$detail_img."|".$acco_img."|".$myp_img;
  return $return_string;



}







 ?>
