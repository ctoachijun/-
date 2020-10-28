<?
include "../../../../common.php";
include_once(G5_THEME_MOBILE_PATH.'/head.php');

$p_info = getInfo($mb_id,$mb_type);
$p_idx = $p_info['idx'];

?>

<style>
.content{background-color:#F8F8F8}
.wrap{margin-top:0vh;}
</style>

<div class="header header_gray">
  <h2>마이페이지</h2>
</div>

<div class="wrap">

<div class="my_work">
<h2 class="sub05_title">기업</h2>
<div class="sub05_box">

  <h4><?=$p_info['c_name']?></h4>

  <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">

  <table class="text_table">
    <tr>
      <td><p>사업자등록번호</p></td> <td class="right"><p><?=$p_info['c_num']?></p></td>
    </tr>
    <tr>
      <td><p>기업명(상호)</p></td> <td class="right"><p><?=$p_info['c_name']?></p></td>
    </tr>
    <tr>
      <td><p>대표자</p></td> <td class="right"><p><?=$p_info['c_boss']?></p></td>
    </tr>
    <tr>
      <td><p>사업장 주소</p></td> <td class="right"><p><?=$p_info['addr1']?> <?=$p_info['addr2']?></p></td>
    </tr>
    <tr>
      <td><p class="non_mar">계좌번호</p></td> <td class="right"><p><?=$p_info['bank_num']?></p></td>
    </tr>
  </table>
</div>
</div>

<div class="my_admin">
<h2 class="sub05_title admin_t">담당자</h2>
<div class="sub05_box">

  <input class="head_txt" type="text" name="m_name" value="<?=$p_info['m_name']?>" disabled /><img class="head_img" src="<?=$img_src?>/write.png" alt="정보 수정" onclick="inputHview('<?=$mb_type?>',<?=$p_idx?>)">

  <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">

  <table class="text_table">
    <tr>
      <td><p>담당자 직책</p></td> <td class="right"><input type="text" name="position" value="<?=$p_info['position']?>" disabled /></td>
    </tr>
    <tr>
      <td><p>담당자 연락처</p></td> <td class="right"><input type="text" name="m_tel" value="<?=$p_info['m_tel']?>" disabled /></td>
    </tr>
    <tr>
      <td><p class="non_mar">담당자 이메일</p></td> <td class="right"><input type="text" name="email" value="<?=$p_info['email']?>" disabled /></td>
    </tr>
  </table>
</div>
</div>



</div>
<?include "./p_tail.php"?>
