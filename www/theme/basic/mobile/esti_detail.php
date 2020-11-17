<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";


// 주문이 들어간 견적인지를 조회
$sql = "SELECT * FROM f_order WHERE e_idx = {$e_idx}";
$order = sql_num_rows(sql_query($sql));


// 견적 정보 추출
$esti = getEstiInfo($e_idx);

// 견적의뢰 정보 추출
$ep_idx = $esti['ep_idx'];
$esti_p = getEpInfo($ep_idx);

// 발주수목 정보 추출
$to_idx = $esti_p['to_idx'];
$treeo = getTreeInfo($to_idx);

// 발주수목 개수 추출
$tree_num = getTreeNum($to_idx);

// 파트너 정보 추출
$p_idx = $esti['p_idx'];
$partn = getPartnInfo($p_idx);


if($esti_p['g_work']==1){
  $g_work_txt = "관급공사(A급 조경수)";
  $g_work_class = "";
}else if($esti_p['g_work']==2){
  $g_work_txt = "사급공사(B급 조경수)";
  $g_work_class = "green_box";
}

if($esti_p['k_tree']==1){
  $k_tree_txt = "교목";
}else if($esti_p['k_tree']==2){
  $k_tree_txt = "관목";
}

$dbox = explode(" ",$esti_p['w_date']);
$w_date = $dbox[0];

// 마감일까지 남은일자 산출
$now = date("Y-m-d H:i:s");
$c_d = ceil( (strtotime($esti_p['e_date']) - strtotime($now)) / 86400 );
$ed_box = explode("-",$esti_p['e_date']);
$ed_txt = $ed_box[0]."년".$ed_box[1]."월".$ed_box[2]."일";

?>
<style>
/* height:82vh -> v20 기준으로 딱 맞음. 크롬에서 s5나 다른기종으로하면 짧음 */
.content{background-color:#F8F8F8;height:91vh;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>견적상세</h2>
</div>

<div class="wrap sub09">
  <table class="text_table">
    <tr>
      <td>
        <img src="<?=$img_src?>/f_ico.png" alt="포레스트 로고">
      <?if($partn['partner_ship']==3){?>
        <p class="partner">포레스트 공식 파트너</p>
      <?}?>
      </td>
      <td class="right">
        <p class="partner tree"><?=$k_tree_txt?></p>
        <p class="partner work <?=$g_work_class?>"><?=$g_work_txt?></p>
      </td>
    </tr>
    <tr>
      <td><h4 class="farm_name"><?=$partn['c_name']?></h4></td>
      <td><p class="com_date">등록 : <?=$w_date?></p></td>
    </tr>
    <tr>
      <td><p class="work_name"><?=$esti_p['w_name']?></p></td>
<?  if($c_d > 0){  ?>
      <td><p class="cut_date">마감까지 <?=$c_d?>일 남음</p></td>
<?  }  ?>
    </tr>
  </table>

  <div class="size">
    <div class="size_title"><p class="item_p">품목</p> <p class="size_p">규격</p> <p class="osum_p">수량</p> <p class="price_p">단가</p></div>
    <hr style="width:100%;margin:0 auto;border:1px solid #bbb;margin-top:5px;margin-bottom:10px;">
<?
    $sum_price = 0;
    for($i=0; $i<$tree_num; $i++){
      // 사이즈 추출
      $sbox = explode("|",$treeo['size'.($i+1)]);
      // 조경수 금액 산출
      $sum = $treeo['osum'.($i+1)] * $esti['price'.($i+1)];
      $sum_price += $sum;
?>
    <div><p class="item_p"><?=$treeo['item'.($i+1)]?></p> <p class="size_p">H<?=$sbox[0]?> x W<?=$sbox[1]?></p> <p class="osum_p"><?=$treeo['osum'.($i+1)]?></p> <p class="bold price_p"><?=$esti['price'.($i+1)]?>원</p></div>
<?
    if($i<($tree_num-1)){?>
      <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
<?
    }
  }
?>
  </div>
  <div class="none">
    <div class="view_pic">
  <?
      for($i=0; $i<$tree_num; $i++){

        if($i == 0 || $i == 3 || $i == 6){
  ?>
      <div class="pic">
  <?    } ?>
        <a href="<?=$img_src?>/forest/<?=$esti['pic'.($i+1)]?>" target="_blank"><img src="<?=$img_src?>/forest/<?=$esti['pic'.($i+1)]?>" class="pic_c" /></a>
  <?   if($i == 2 || $i == 5 || $i == 7){ ?>
      </div>
  <?
      }
    }
    // 가로 사진 3개마다 div를 닫아주고있는데 1개, 2개일경우 div가 안닫히는 문제발생
    // 안닫혔기때문에 class=none div가 전체를 덮어 화면 절반이상이 안나옴.
    // 때문에 사진개수가 3의배수 미만일경우 div를 닫아주는 조치로 해결.
    if($tree_num % 3 != 0){
?>
      </div>
<?
    }

    // 설정 된 고객 수수료를 이용해 수수료 산출
    $tsql = "SELECT * FROM f_fee";
    $tbox = sql_fetch($tsql);
    $fee = $tbox['tep'] / 100;
    $tep = $sum_price*$fee;
    $total_price = $esti['t_price'] + $tep;

  ?>

    </div>
  </div>

  <div class="date_dead">
    <div class="view_hide" onclick="none_view()">조경수 사진보기</div>
  </div>

  <div class="check">
    <div>
      <p class="bold">납품 현장</p>
      <p><?=$esti_p['target']?></p>
    </div>
    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
    <div>
      <p class="bold">납품 날짜</p>
      <p><?=$ed_txt?></p>
    </div>
    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
    <div>
      <p class="bold">요청 사항</p>
      <p><?=$esti_p['memo']?></p>
    </div>
    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
    <div>
      <p class="bold">기타 사항</p>
      <p><?=$esti['etc']?></p>
    </div>
  </div>

  <div class="payment">
    <div><p>조경수</p> <p class="bold"><?=number_format($sum_price)?><span>원</span></p></div>
    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
    <div><p>수수료</p> <p class="bold"><?=number_format($tep)?><span>원</span></p></div>
    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;">
    <div  class="blue"><p>예상 운임비</p> <p><?=number_format($esti['d_price'])?><span>원</span></p></div><br>
    <div class="red"><p class="bold">최종 결제 금액</p> <p class="bold"><?=number_format($total_price)?><span>원</span></p></div>
    <hr style="width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;border-color:#ccc;">
  </div>

  <form name="payment_form" action="./payment.php" method="post" />
    <input type="hidden" name="tep" value="<?=$tep?>" />
    <input type="hidden" name="t_price" value="<?=$total_price?>" />
    <input type="hidden" name="ep_idx" value="<?=$ep_idx?>" />
    <input type="hidden" name="e_idx" value="<?=$e_idx?>" />
  </form>

  <div class="click_box">
<?  if($c_d > 0 && $order == 0){  ?>
      <a onclick="call_back()" class="back">확인</a>
      <p onclick="submit_pay(1)" class="enter">결제하기</p>
<?  }else{  ?>
      <a onclick="call_back()" class="back_all">확인</a>
<?  }     ?>

  </div>

</div>

<?
  include_once(G5_THEME_MOBILE_PATH.'/tail2.php');
?>
