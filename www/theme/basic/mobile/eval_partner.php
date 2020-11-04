<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

$m_idx = getMbIdx($mb_id);

// 견적 정보 추출
$ebox = getEstiInfo($e_idx);
$p_idx = $ebox['p_idx'];
$ep_idx = $ebox['ep_idx'];
$t_price = $ebox['t_price'];

// 주문(납품) 횟수 추출
$o_num = getOrderNum($p_idx);

// 농원 평가 정보 - 코멘트가 공백이 아닌것
$sql = "SELECT * FROM f_partner_ship WHERE p_idx = {$p_idx}";
$re = sql_query($sql);
$pscore_num = sql_num_rows($re);
if(!$pscore_num){
  $pscore_num = 0;
}

// 평균 평점계산
$t_point = 0;
while($row = sql_fetch_array($re)){
  $t_point += $row['point'];
}
$t_point /= $pscore_num;
$t_point = round($t_point, 1);

if($pscore_num == 0){
    $t_point = "-";
}



// 파트너 정보 추출
$pbox = getPartnInfo($p_idx);
$c_name = $pbox['c_name'];
$addr = $pbox['addr1'].$pbox['addr2'];
$c_boss = $pbox['c_boss'];

// 견적의뢰 정보 추출
$epbox = getEpInfo($ep_idx);
$w_name = $epbox['w_name'];
$o_idx = $epbox['o_idx'];


// 후기정보 추출
$psbox = getPartShipInfo($o_idx);
$comment = $psbox['comment'];
$point = $psbox['point'];
if($point > 0){
  $eval = 1;
  $btn_txt = "수정";
}else{
  $eval = 0;
  $btn_txt = "등록";
}


?>


<style>
.content{background-color:#F8F8F8;}
.wrap{margin-top:7vh;}
</style>

<div class="header">
  <h2>후기 <?=$btn_txt?></h2>
</div>

<input type="hidden" name="eval" value="<?=$eval?>" />
<div class="wrap sub12 sub13">
  <div class="address">
    <table>
      <tr>
        <td>업체명 :</td>
        <td class="bold"><?=$c_name?></td>
      </tr>
      <tr>
        <td>주소 :</td>
        <td><?=$addr?></td>
      </tr>
      <tr>
        <td>대표 :</td>
        <td><?=$c_boss?></td>
      </tr>
      <tr>
        <td>공사명 :</td>
        <td class="bold"><?=$w_name?></td>
      </tr>
      <tr>
        <td>가격 : </td>
        <td><?=number_format($t_price)?> 원</td>
      </tr>
    </table>
  </div>

  <div class="big_score">
    <div class="score_box">
      <div>
        <div>
          <h4 class="score"><?=$t_point?></h4>
          <p>평점</p>
        </div>
        <div>
          <h4><?=$o_num?></h4>
          <p>납품횟수</p>
        </div>
        <div>
          <h4><?=$pscore_num?></h4>
          <p>후기</p>
        </div>
      </div>
    </div>
  </div>

  <div class="review">
    <table>
      <tr>
        <td class="td_head">평점</td>
        <td>
          <select id="star_point" name="star_point">
            <option value="0">---선택---</option>
        <?  for($i=1,$val=5; $i<10; $i++){
              if(round($val,2) == $point){
                  echo "<option value='{$val}' selected>{$val}점</option>";
              }else{
                  echo "<option value='{$val}'>{$val}점</option>";
              }
              $val = $val - 0.5;
            }
        ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="liner td_head">후기</td>
        <td class="liner"><textarea id="comment"><?=$comment?></textarea></td>
      </tr>
    </table>
    <div class="point_btn"><button type="submit" onclick="add_eval(<?=$e_idx?>,<?=$m_idx?>,<?=$p_idx?>)"><?=$btn_txt?></button></div>
  </div>

<?include "./tail2.php"?>
