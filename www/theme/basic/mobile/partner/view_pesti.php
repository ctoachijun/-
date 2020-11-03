<?
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

if($t_type == 1){
  $t_class = "under_line1";
}else if($t_type == 2){
  $t_class = "under_line2";
}
?>
<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:7.5vh;}
</style>

<div class="header">
  <h2>견적의뢰서</h2>
</div>
<form method="POST" action="<?=$PHP_SELF?>" id="scol" name="search_col" />
  <input type="hidden" name="t_type" value="<?=$t_type?>" />
  <input type="hidden" name="sort_type" value="<?=$sort_type?>"/>
</form>
<div class="wrap p_sub01">
  <div class="gradation_box">
    <div onclick="selTree(1)"><img src="<?=$img_src?>/tree02.png" alt=""><p>교목</p><hr class="<?=$t_class?>" /></div>
    <p class="border"></p>
    <div onclick="selTree(2)"><img src="<?=$img_src?>/tree01.png" alt=""><p>관목</p><hr class="<?=$t_class?>" /></div>
  </div>
  <div class="all_gray_box">
    <p onclick="sortList(1)">최근등록순</p>
    <p onclick="sortList(2)">마감일순</p>
  </div>

  <div class="p_sub02">
  <? getEstiPlzList($sort_type,$t_type,$mb_id,2) ?>
  </div>
</div>

<?include "./p_tail2.php"?>
