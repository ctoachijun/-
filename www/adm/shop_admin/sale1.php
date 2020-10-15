<?php
$sub_menu = '100100';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

if(!$s_key){
  $s_key=1;
}

// $g5['title'] = '매출현황';
$g5['title'] = $menu['menu100'][$s_key][1];
$curr_title = "구매자 입금 현황 및 판매자 이체 관리";


include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
}

$d_sql = "SELECT * FROM f_deposit WHERE 1";
$l_cnt = sql_num_rows(sql_query($d_sql));
$list = 30;

?>


<div id="list_table">
  <div class="total_cnt">
    <p class="ment">전체 <span class="t_cnt"><?=$l_cnt?></span> 건</p>
  </div>

  <div class="content_table">
    <table>
      <tr class="th_line">
        <th class="depo_th_s">주문상태<br><span class="th_target">고객</span></th>
        <th class="depo_th_s">주문상태<br><span class="th_target">파트너</span></th>
        <th class="depo_th">공사명</th>
        <th class="depo_th_s">판매자</th>
        <th class="depo_th_s">구매자</th>
        <th class="depo_th">판매자연락처</th>
        <th class="depo_th">구매자연락처</th>
        <th class="depo_th">요청일시</th>
        <th class="depo_th">요청대기 일시</th>
        <th class="depo_th_p">구매자 총 결제금액</th>
        <th class="depo_th_p">판매자 입금금액</th>
      </tr>
      <?=list_depo($page,$list,$l_cnt)?>
    </table>
  </div>
  <div id="page_num">
    <ul>
      <?=paging($page,$list,$l_cnt);?>
    </ul>
  </div>


</div>


<!--
<div class="local_sch03 local_sch">

    <div>
        <form name="frm_sale_today" action="./sale1today.php" method="get">
        <strong>일일 매출</strong>
        <input type="text" name="date" value="<?php echo date("Ymd", G5_SERVER_TIME); ?>" id="date" required class="required frm_input" size="8" maxlength="8">
        <label for="date">일 하루</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

    <div>
        <form name="frm_sale_date" action="./sale1date.php" method="get">
        <strong>일간 매출</strong>
        <input type="text" name="fr_date" value="<?php echo date("Ym01", G5_SERVER_TIME); ?>" id="fr_date" required class="required frm_input" size="8" maxlength="8">
        <label for="fr_date">일 ~</label>
        <input type="text" name="to_date" value="<?php echo date("Ymd", G5_SERVER_TIME); ?>" id="to_date" required class="required frm_input" size="8" maxlength="8">
        <label for="to_date">일</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

    <div>
        <form name="frm_sale_month" action="./sale1month.php" method="get">
        <strong>월간 매출</strong>
        <input type="text" name="fr_month" value="<?php echo date("Y01", G5_SERVER_TIME); ?>" id="fr_month" required class="required frm_input" size="6" maxlength="6">
        <label for="fr_month">월 ~</label>
        <input type="text" name="to_month" value="<?php echo date("Ym", G5_SERVER_TIME); ?>" id="to_month" required class="required frm_input" size="6" maxlength="6">
        <label for="to_month">월</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

    <div class="sch_last">
        <form name="frm_sale_year" action="./sale1year.php" method="get">
        <strong>연간 매출</strong>
        <input type="text" name="fr_year" value="<?php echo date("Y", G5_SERVER_TIME)-1; ?>" id="fr_year" required class="required frm_input" size="4" maxlength="4">
        <label for="fr_year">년 ~</label>
        <input type="text" name="to_year" value="<?php echo date("Y", G5_SERVER_TIME); ?>" id="to_year" required class="required frm_input" size="4" maxlength="4">
        <label for="to_year">년</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

</div> -->

<script>
$(function() {
    $("#date, #fr_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yymmdd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        maxDate: "+0d"
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
