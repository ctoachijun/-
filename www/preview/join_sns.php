<?php
session_start();

include "./head.php";

$uid = $_SESSION['uid'];
$token = $_SESSION['token'];
$provide = $_SESSION['provide'];



 ?>

 <style>
 .content{height:100vh;}
 .wrap{margin-top:8vh;padding:10px 20px;}
 </style>

 <div class="header">
   <h2>SNS 회원가입</h2>
 </div>

 <div class="wrap sign">
   <form action="./proc.php" method="POST" name="sns_join" />
    <input type="hidden" name="uid" value="<?=$uid?>" />
    <input type="hidden" name="token" value="<?=$token?>" />
    <input type="hidden" name="provide" value="<?=$provide?>" />
    <input type="hidden" name="work" value="sns_join" />
    <h4>회원정보</h4>
    <label>메일주소</label>
    <input type="text" name="email" placeholder="메일주소">
    <div onclick="submit_snsjoin()"class="next">다음</div>
  </form>
 </div>
