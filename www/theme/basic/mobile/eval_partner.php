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



?>


<style>
.content{background-color:#F8F8F8;}
.wrap{margin-top:7vh;}
</style>

<div class="header">
  <img onclick="call_back()" src="<?=$img_src?>/left.png" alt="뒤로가기">
  <h2><?=$c_name?></h2>
</div>

<div class="wrap sub12 sub13">
  <div class="address">
    <table>
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
        <td><?=$w_name?></td>
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
        <td>평점</td>
        <td>
          <select id="star_point" name="star_point">
            <option value="0">---선택---</option>
            <option value="1">1점</option>
            <option value="1.5">1.5점</option>
            <option value="2">2점</option>
            <option value="2.5">2.5점</option>
            <option value="3">3점</option>
            <option value="3.5">3.5점</option>
            <option value="4">4점</option>
            <option value="4.5">4.5점</option>
            <option value="5">5점</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="liner">후기</td>
        <td class="liner"><textarea id="comment"></textarea></td>
      </tr>
      <tr>
        <td colspan="2" class="point_btn"><button type="submit">등록</button></td>
      </tr>
    </table>
  </div>

<?include "./tail2.php"?>
