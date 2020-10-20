<?php

$sub_menu = "400000";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
$g5['title'] = $menu['menu400'][0][1];

$curr_title = "품목 별 거래량 및 평균단가";

include_once('./admin.head.php');

$cur_url = "./statistics.php";


// 검색된 품목을 오늘기준으로 3주전까지 주문수 추출


$week_data = getWeekData($i_stx);

// 각주별로 변수에 대입
for($i=0; $i<count($week_data); $i++){
    $txt = "week".($i+1);
    $$txt = round(($week_data[$i] / 1000),3);
    echo $$txt."<br>";
}

?>

<div id="stati">

  <div class="st_head">
    <div class="i_search">
      <form name="isearch" id="isearch" action="./statistics.php" class="local_sch01 local_sch" method="post">
        <label for="i_stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="i_stx" id="i_stx" value="<?=$i_stx?>" placeholder="품목명으로 검색 해 주세요" required class="required frm_input" />
        <input type="hidden" class="w1" value="<?=$week1?>" />
        <input type="hidden" class="w2" value="<?=$week2?>" />
        <input type="hidden" class="w3" value="<?=$week3?>" />
        <input type="hidden" class="w4" value="<?=$week4?>" />
        <input type="submit" value="검색" class="btn_submit"/>
      </form>
    </div>
  </div>

  <div class="st_cont">
    <div class="l_cont" >
      <div class="sub_title">품목별 거래량</div>
      <div class="dan">단위(천주)</div>
      <div class="back_stick">
        <div class="left">
          <table>
            <tr>
              <td class="left_d">5</td>
            </tr>
            <tr>
              <td class="left_d">4.5</td>
            </tr>
            <tr>
              <td class="left_d">4</td>
            </tr>
            <tr>
              <td class="left_d">3.5</td>
            </tr>
            <tr>
              <td class="left_d">3</td>
            </tr>
            <tr>
              <td class="left_d">2.5</td>
            </tr>
            <tr>
              <td class="left_d">2</td>
            </tr>
            <tr>
              <td class="left_d">1.5</td>
            </tr>
            <tr>
              <td class="left_d">1</td>
            </tr>
            <tr>
              <td class="left_d">0.5</td>
            </tr>
            <tr>
              <td class="left_d">0</td>
            </tr>
          </table>
        </div>
        <div class="line">
          <table>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
            <tr>
              <td class="line_td"></td>
            </tr>
          </table>
        </div>
      </div>
      <div id="chart1"></div>
      <div class="g_name">
        <span class="gn g1">3주전</span><span class="gn g2">2주전</span><span class="gn g3">1주전</span><span class="gn g4">이번주</span>
      </div>

    </div>


    </div>
    <div class="r_cont">
    <?

    ?>

    </div>


  </div>

</div>

<script>
$(document).ready(function(){
  let stx = $("#i_stx").val();
  let w1 = $(".w1").val();
  let w2 = $(".w2").val();
  let w3 = $(".w3").val();
  let w4 = $(".w4").val();

  if(stx){
      btn_click(w1,w2,w3,w4);
  }

});
</script>


<?php
include_once('./admin.tail.php');
?>
