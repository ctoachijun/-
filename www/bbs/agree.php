<?
include_once("./_common.php");

$sql = "SELECT * FROM f_agree";
$re = sql_fetch($sql);

$content = $re['content'];

?>

<style>
#agree{width:100%;text-align:center;}
#agree .agree_cont{width:50%; border:1px solid #ccc;padding:10px; border-radius:10px;margin:0 auto;}
</style>

<div id="agree">

  <div class="agree_cont">
    <h2>개인정보처리방침</h2>
    <p><?=$content?></p>
  </div>

</div>
