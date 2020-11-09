<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');


// 각 표시되거나 대입되는 항목들 설정
if($page_type==1){
  $type_name = "농원";
  $idx_name = "p_idx";
  $ct_name = "농원";
  $dt_name = "납품일";
  $pt_name = "입금현황";
  $tail_txt = " 납품내역";
}else if($page_type==2){
  $type_name = "고객";
  $idx_name = "m_idx";
  $ct_name = "고객사";
  $dt_name = "구매일";
  $pt_name = "결제현황";
  $tail_txt = " 거래내역";
}


$g5['title'] = $menu['menu200'][$s_key][1];
$curr_title = "상세보기 및 거래내역 조회 > {$type_name}";
include_once('./admin.head.php');


// 거래 총 횟수
$t_sql = "SELECT * FROM f_deposit WHERE {$idx_name} = {$idx}";
$total_cnt = sql_num_rows(sql_query($t_sql));
if(!$total_cnt){
  $total_cnt=0;
}

$star = star_score($idx);
$c_name = get_Partnername($idx,$page_type);
if($star > 0){
  $score_txt = $star."점";
}else{
  $score_txt = "아직 평점이 없습니다.";
}

if($page_type==2){
  $head_title = "고객 정보";
}else{
  $head_title = $c_name;
}



?>

<div id="member_detail">
  <form method="POST" action="./adm_proc.php" name="exact" id="del_post"/>
    <input type="hidden" name="idx" value="<?=$idx?>" />
    <input type="hidden" name="type" value="p_delete" />
  </form>
  <div class="p_detail">
    <div class="p_head">
    </div>
    <div class="p_head_sub">
      <div class="l_btn">
        <a href="./member_list.php?s_key=1"><button class="t_btn">목록</button></a>
      </div>
      <div class="r_btn">
        <button class="t_btn" onclick="editp(<?=$page_type?>)">수정하기</button>
        <button class="t_btn" onclick="delp(<?=$page_type?>)">삭제하기</button>
      </div>
    </div>
    <div class="p_content">
      <table>
        <tr class="tr_line">
          <th colspan="2">
            <div class="s_score">
              <span class="c_name"><?=$head_title?></span>

              <?if($page_type==1){?>
              <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star?>.png" alt="" class="star_img">
              <span class="score_txt"><?=$score_txt?></span>
              <?}?>

            </div>
          </th>
        </tr>
        <?=partner_detail($idx,$page_type)?>
      </table>

      <?if($page_type==1){?>
      <div class="p_buttons">
        <input type="button" class="t_btn t1" value="일반농원 지정" onclick="partner_ship(1)" />
        <input type="button" class="t_btn t2" value="베스트농원 지정" onclick="partner_ship(2)"/>
        <input type="button" class="t_btn t4" value="공식파트너 농원 지정" onclick="partner_ship(3)"/>
      </div>
      <?}?>

    </div>
  </div>


  <div class="m_detail">
    <div class="m_head">
      <span class="m_head_title"><?=$c_name?><?=$tail_txt?></span>
    </div>
    <div class="m_head_sub">
      <span class="t_cnt">총 : <?=$total_cnt?>건</span>
    </div>
    <div class="m_content">
      <table>
        <tr class="tr_line">
          <th class="th_txt">NO.</th>
          <th class="th_txt"><?=$ct_name?></th>
          <th class="th_txt">공사명</th>
          <th class="th_txt">입금금액</th>
          <th class="th_txt"><?=$dt_name?></th>
          <th class="th_txt"><?=$pt_name?></th>
        </tr>
        <?=view_depo($idx,$page_type,$c_name)?>
      </table>
    </div>
  </div>




</div>

<?php
include_once ('./admin.tail.php');
?>
