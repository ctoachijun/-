<?php
include_once('../../../common.php');

switch($w_type){
  case "esti_plz" :
    //  견적의뢰 테이블에 데이터 입력
    $sql = "INSERT INTO f_estimate_plz SET
    m_idx = {$m_idx}, w_name = '{$w_name}', g_work = {$w_class}, k_tree = {$t_class},
    target = '{$w_place}', d_date = '{$wr_1}', memo = '{$memo}', e_date = '{$wr_2}'
    ";
    $re1 = sql_query($sql);


    // 방금 입력한 견적의외 고유번호 취득
    $idx_sql = "SELECT idx FROM f_estimate_plz ORDER BY idx DESC";
    $box = sql_fetch_array(sql_query($idx_sql));
    $ep_idx = $box['idx'];

    // 발주수목 테이블에 데이터 입력
    for($i=0; $i<8; $i++){

        $col_name1 = "item".($i+1);
        $col_txt1 = $col_name1."= '".$item_name[$i]."'";

        $col_name2 = "osum".($i+1);
        if(!$total[$i]){
          $total[$i] = 0;
        }
        $col_txt2 = $col_name2."=".$total[$i];

        if($h_size[$i] || $w_size[$i]){
          $size_val = $h_size[$i]."|".$w_size[$i];
        }else{
          $size_val = null;
        }
        $col_name3 = "size".($i+1);
        $col_txt3 = $col_name3."= '".$size_val."'";

        $col_txt .= $col_txt1.",".$col_txt2.",".$col_txt3.",";
    }

    $sql = "INSERT INTO f_tree_order SET {$col_txt} ep_idx = {$ep_idx}";
    $re2 = sql_query($sql);


    // 방금 입력한 발주수목 고유번호 취득
    $idx_sql = "SELECT idx FROM f_tree_order WHERE ep_idx = {$ep_idx}";
    // echo $idx_sql;
    $box = sql_fetch_array(sql_query($idx_sql));
    $to_idx = $box['idx'];

    // 견적의뢰 테이블 데이터 업데이트
    $u_sql = "UPDATE f_estimate_plz SET to_idx = {$to_idx} WHERE idx = {$ep_idx}";
    $re3 = sql_query($u_sql);

    if($re1 && $re2 && $re3){
      alert("견적의뢰 등록에 성공했습니다.", G5_URL);
    }


  break;
}


function getImgName($curr_fname){
  $home_img = "home";
  $esti_img = "g_esti";
  $detail_img = "g_detail";
  $acco_img = "account";
  $myp_img = "mypage";

  if($curr_fname == "index.php"){
    $home_img .= "_h";
  }else if($curr_fname == "view_esti.php" || $curr_fname == "view_pesti.php"){
    $esti_img .= "_h";
  }else if($curr_fname == "view_deta.php" || $curr_fname == "view_pdeta.php"){
    $detail_img .= "_h";
  }else if($curr_fname == "view_acco.php"){
    $acco_img .= "_h";
  }else if($curr_fname == "view_mypage.php" || $curr_fname == "view_pmypage.php"){
    $myp_img .= "_h";
  }

  $return_string = $home_img."|".$esti_img."|".$detail_img."|".$acco_img."|".$myp_img;
  return $return_string;

}

function getMbIdx($mb_id){
  $sql = "SELECT idx FROM f_member WHERE m_id = '{$mb_id}'";
  $box = sql_fetch_array(sql_query($sql));

  return $box['idx'];
}


function getEstiPlzList(){

  $sql = "SELECT * FROM f_estimate_plz WHERE o_idx < 1";
  $re = sql_query($sql);

  while($row = sql_fetch_array($re)){
    // print_r($row);
    $mypartner = $row['c_partner'];
    $g_work = $row['g_work'];
    $k_tree = $row['k_tree'];
    $w_name = $row['w_name'];
    $to_idx = $row['to_idx'];
    $m_idx = $row['m_idx'];
    $d_date = $row['d_date'];

    $m_sql = "SELECT c_name FROM f_member WHERE idx = {$m_idx}";
    $m_re = sql_fetch_array(sql_query($m_sql));
    $c_name = $m_re['c_name'];

    $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
    $to_re = sql_fetch_array(sql_query($to_sql));

    for($i=0; $i<8; $i++){
      $col_name = "item".($i+1);
      if($to_re[$col_name]){
        $box[$col_name] = $to_re[$col_name];
      }
    }

    $dbox = explode(" ",$to_re['w_date']);
    $w_date = $dbox[0];
    if($g_work==1){
      $g_work_txt = "관급공사";
    }else if($g_work==2){
      $g_work_txt = "사급공사";
    }

    if($k_tree==1){
      $k_tree_txt = "A급 조경수";
      $k_tree_class = "";
    }else if($k_tree==2){
      $k_tree_txt = "B급 조경수";
      $k_tree_class = "green_box";
    }




    echo "<table class='text_table'>";
    echo "<tr><td>";
    echo "<img src='/theme/basic/img/f_ico.png' alt=''포레스트 로고''>";
    if($mypartner){
      echo "<p class='partner'>내 농원을 거래처로 등록한 업체</p>";
    }
    echo "</td>";
    echo "<td class='right'>";
    echo "<p class='partner tree'>{$g_work_txt}</p><p class='partner work {$k_tree_class}'>{$k_tree_txt}</p>";
    echo "</td></tr>";
    echo "<tr><td><a href=''./sub12.php'><h4 class='farm_name'>한국조경</h4></a></td>";
    echo "<td><p class='com_date'>등록 : {$w_date}</p></td></tr>";
    echo "<tr><td><p class='work_name'>전주시립도서관 조경보수공사</p></td>";
    echo "<td><p class='cut_date'>마감까지 2일 남음</p></td>";
    echo "</tr></table>";

    echo "<ul>";
    echo "<li>산철쭉</li>";
    echo "<li>백철쭉</li>";
    echo "<li>회양목</li>";
    echo "<li>남천</li>";
    echo "<li>화살나무</li>";
    echo "</ul>";
    echo "<hr style='width:100%;margin:0 auto;margin-top:8px;margin-bottom:12px;'>";
    echo "<div class='info'>";
    echo "<div><a href=''./''>그만보기</a>";
    echo "<a href='./' class='brown_box'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적의뢰서 확인</a></div>";
    echo "</div>";


  }


}









?>
