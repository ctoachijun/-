<?php
include_once('../../../common.php');

function getImgName($curr_fname){
  $home_img = "home";
  $esti_img = "g_esti";
  $detail_img = "g_detail";
  $acco_img = "account";
  $myp_img = "mypage";

  if($curr_fname == "index.php"){
    $home_img .= "_h";
  }else if($curr_fname == "view_esti.php" || $curr_fname == "view_pesti.php" || $curr_fname == "esti_comp.php" || $curr_fname == "esti_detail.php"){
    $esti_img .= "_h";
  }else if($curr_fname == "view_deta.php" || $curr_fname == "view_pdeta.php"){
    $detail_img .= "_h";
  }else if($curr_fname == "view_acco.php"){
    $acco_img .= "_h";
  }else if($curr_fname == "view_mypage.php" || $curr_fname == "view_pmypage.php" || $curr_fname == "pmypage_detail.php" || $curr_fname == "mypage_detail.php"){
    $myp_img .= "_h";
  }

  $return_string = $home_img."|".$esti_img."|".$detail_img."|".$acco_img."|".$myp_img;
  return $return_string;

}

function getPayCompList($mb_id){
  $m_idx = getMbIdx($mb_id);

  $sql = "SELECT e_idx FROM f_deposit WHERE m_idx = {$m_idx} AND m_deposit = 1";
  $re = sql_query($sql);

  while($row = sql_fetch_array($re)){
    $e_idx = $row['e_idx'];

    $sql = "SELECT * FROM f_estimate WHERE idx={$e_idx}";
    $re = sql_fetch_array(sql_query($sql));
    $ep_idx = $re['ep_idx'];
    $p_idx = $re['p_idx'];


    // 공사명, 등록일, 납품일 추출
    $sql = "SELECT * FROM f_estimate_plz WHERE idx = {$ep_idx}";
    $box = sql_fetch_array(sql_query($sql));
    $w_name = $box['w_name'];
    $wbox = explode(" ",$box['w_date']);
    $w_date = $wbox[0];
    $d_date = $box['d_date'];

    $d_box = explode("-",$d_date);
    $d_txt = $d_box[0]."년".$d_box[1]."월".$d_box[2]."일";


    // 농원명 추출
    $pbox = getPartnInfo($p_idx);
    $c_name = $pbox['c_name'];
    $p_ship = $pbox['partner_ship'];


    echo "<div class='main_bottom_box'>";
    echo "<table class='text_table'>";
    echo "<tr><td>";
    echo "<img src='/theme/basic/img/f_ico.png' alt=''포레스트 로고''>";
    if($p_ship == 3){
      $fn_class = "official";
      echo "<p class='partner'>포레스트 공식 파트너</p>";
    }else{
      $fn_class = "";
    }
    echo "</td>";
    echo "<td class='right'>";
    echo "</td></tr>";
    echo "<tr><td><h4 class='farm_name'>{$c_name}</h4></td>";
    echo "<td><p class='com_date'>등록 : {$w_date}</p></td></tr>";
    echo "<tr><td class='w_name' colspan='2'><p class='work_name'>{$w_name}</p></td>";
    echo "</tr></table>";
    echo "<hr style='width:100%;margin:0 auto;margin-top:2px;margin-bottom:6px;'>";
    echo "<div class='d_date'><p>도착일 : {$d_txt}</p></div>";
    echo "<div class='delay_deli'></div>";
    echo "</div>";



  }


}

function getEstiPlzList($s_type,$t_type,$mb_id,$mp){

  // 고객, 파트너 구분
  if($mp==1){
    // 고객 IDX추출
    $sql = "SELECT * FROM f_member WHERE m_id = '{$mb_id}'";
    $re = sql_fetch_array(sql_query($sql));
    $mb_idx = $re['idx'];
    $c_name = $re['c_name'];

    $sql = "SELECT * FROM f_estimate_plz AS e
    INNER JOIN f_tree_order AS t ON e.to_idx = t.idx
    WHERE e.m_idx = {$mb_idx} AND cancel != 'Y'";
    $re = sql_query($sql);
    $re_cnt = sql_num_rows($re);

    $cnt_pi=0;
    $in_num=1;
    while($row = sql_fetch_array($re)){
      $ep_idx = $row['idx'];
      $mypartner = $row['c_partner'];
      $g_work = $row['g_work'];
      $k_tree = $row['k_tree'];
      $w_name = $row['w_name'];
      $to_idx = $row['to_idx'];
      $m_idx = $row['m_idx'];
      $d_date = $row['d_date'];
      $target = $row['target'];
      $ep_idx = $row['ep_idx'];
      $e_date = $row['e_date'];

      // 수목 발주품목 추출
      $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
      $to_re = sql_fetch_array(sql_query($to_sql));
      for($i=0; $i<8; $i++){
        $col_name = "item".($i+1);
        if($to_re[$col_name]){
          $box[$i] = $to_re[$col_name];
        }
      }
      $dbox = explode(" ",$to_re['w_date']);
      $w_date = $dbox[0];
      if($g_work==1){
        $g_work_txt = "관급공사(A급 조경수)";
        $g_work_class = "";
      }else if($g_work==2){
        $g_work_txt = "사급공사(B급 조경수)";
        $g_work_class = "green_box";
      }


      if($k_tree==1){
        $k_tree_txt = "교목";
      }else if($k_tree==2){
        $k_tree_txt = "관목";
      }


      // 마감일까지 남은일자 산출
      $now = date("Y-m-d H:i:s");
      $c_d = ceil( (strtotime($d_date) - strtotime($now)) / 86400 );
      $ed_box = explode("-",$e_date);
      $ed_txt = $ed_box[0]."년".$ed_box[1]."월".$ed_box[2]."일";

      $t_name = "target".$ep_idx;
      $ed_name = "ed_date".$ep_idx;

      echo "<div class='main_bottom_box'>";
      echo "<input type='hidden' name='e_date' class='e_date' value='{$e_date}' />";
      echo "<table class='text_table'>";
      echo "<tr><td>";
      echo "<img src='/theme/basic/img/f_ico.png' alt=''포레스트 로고''>";
      echo "</td>";
      echo "<td class='right'>";
      echo "<p class='partner tree'>{$k_tree_txt}</p><p class='partner work {$g_work_class}'>{$g_work_txt}</p>";
      echo "</td></tr>";
      echo "<tr><td><h4 class='farm_name'>{$c_name}</h4></td>";
      echo "<td><p class='com_date'>등록 : {$w_date}</p></td></tr>";
      echo "<tr><td><p class='work_name'>{$w_name}</p></td>";
      echo "<td><p class='cut_date'>마감까지 {$c_d}일 남음</p></td>";
      echo "</tr></table>";
      echo "<hr style='width:100%;margin:0 auto;margin-top:2px;margin-bottom:6px;'>";
      echo "<ul>";
      for($a=0; $a<count($box); $a++){
        echo "<li>".$box[$a]."</li>";
      }
      echo "</ul>";
      echo "<div class='edit_input'>";
      echo "<div>";
      echo "<img src='/theme/basic/img/date.png' alt='납품 날짜'>";
      echo "</div>";
      echo "<div>";
      echo "<p>납품 날짜 : <input type='text' name='ed_date' class='{$ed_name}' value='{$ed_txt}' readonly /></p>";
      echo "</div>";
      echo "</div>";
      echo "<div class='edit_input'>";
      echo "<div>";
      echo "<img src='/theme/basic/img/location.png' alt='납품 장소'>";
      echo "</div>";
      echo "<div>";
      echo "<p>납품 장소 : <input type='text' name='target' class='{$t_name}' value='{$target}' readonly /></p>";
      echo "</div>";
      echo "</div>";
      echo "<p class='btn_date'><span onclick='editDPinfo({$ep_idx},{$re_cnt})' class='change'>납품 날짜 및 장소 변경</span></p>";
      echo "<hr style='width:100%;margin:0 auto;margin-top:12px;margin-bottom:12px;'>";
      echo "<div class='info'>";
      echo "<div><a class='estimate' href='/theme/basic/mobile/esti_comp.php?ep_idx={$ep_idx}' class='brown_box'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적서 확인</a>";
      echo "<a class='cancel' onclick='noListExe(2,{$ep_idx})'>거래 취소</a></div>";
      echo "</div>";
      echo "</div>";
      $cnt_pi++;
      $in_num++;
    }

  }else if($mp==2){
    // 파트너 IDX추출
    $sql = "SELECT idx FROM f_partner WHERE p_id = '{$mb_id}'";
    $re = sql_fetch_array(sql_query($sql));
    $mb_idx = $re['idx'];


    if($s_type=="nd"){
      $order_txt = "ORDER BY t.w_date DESC";
    }else if($s_type=="dd"){
      $order_txt = "ORDER BY e.d_date";
    }

    if($t_type){
      $ktree_txt = "&& e.k_tree = $t_type";
    }

    $sql = "SELECT *,(e.idx) FROM f_estimate_plz AS e
    INNER JOIN f_tree_order AS t ON e.to_idx = t.idx
    WHERE e.o_idx = 0 {$ktree_txt} {$order_txt}";

    $re = sql_query($sql);
    $cnt_pi=0;
    while($row = sql_fetch_array($re)){
      $ep_idx = $row['idx'];
      $mypartner = $row['c_partner'];
      $g_work = $row['g_work'];
      $k_tree = $row['k_tree'];
      $w_name = $row['w_name'];
      $to_idx = $row['to_idx'];
      $m_idx = $row['m_idx'];
      $d_date = $row['d_date'];


      // 그만보기 선택한 의뢰 및 견적을 낸 건은 제외처리
      $nv_box = explode("|",$row['no_view']);
      $nv_re = in_array($mb_idx,$nv_box);

      if(!$nv_re){

        // 업체명 추출
        $m_sql = "SELECT c_name FROM f_member WHERE idx = {$m_idx}";
        $m_re = sql_fetch_array(sql_query($m_sql));
        $c_name = $m_re['c_name'];

        // 수목 발주품목 추출
        $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
        $to_re = sql_fetch_array(sql_query($to_sql));
        for($i=0; $i<8; $i++){
          $col_name = "item".($i+1);
          if($to_re[$col_name]){
            $box[$i] = $to_re[$col_name];
          }
        }

        $dbox = explode(" ",$to_re['w_date']);
        $w_date = $dbox[0];
        if($g_work==1){
          $g_work_txt = "관급공사";
          $k_tree_txt = "A급 조경수";
          $k_tree_class = "";
        }else if($g_work==2){
          $g_work_txt = "사급공사";
          $k_tree_txt = "B급 조경수";
          $k_tree_class = "green_box";
        }

        // 마감일까지 남은일자 산출
        $now = date("Y-m-d H:i:s");
        $c_d = ceil( (strtotime($d_date) - strtotime($now)) / 86400 );

        echo "<div class='main_bottom_box'>";
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
        echo "<tr><td><a href=''./sub12.php'><h4 class='farm_name'>{$c_name}</h4></a></td>";
        echo "<td><p class='com_date'>등록 : {$w_date}</p></td></tr>";
        echo "<tr><td><p class='work_name'>{$w_name}</p></td>";
        echo "<td><p class='cut_date'>마감까지 {$c_d}일 남음</p></td>";
        echo "</tr></table>";

        echo "<ul>";
        for($a=0; $a<count($box); $a++){
          echo "<li>".$box[$a]."</li>";
        }
        echo "</ul>";
        echo "<hr style='width:100%;margin:0 auto;margin-top:8px;margin-bottom:12px;'>";
        echo "<div class='info'>";
        echo "<div><a onclick='no_viewPartner({$mb_idx},{$ep_idx})'>그만보기</a>";
        echo "<a href='./esti_plz_detail.php?idx={$ep_idx}' class='brown_box'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적의뢰서 확인</a></div>";
        echo "</div>";
        echo "</div>";
      }

      $cnt_pi++;
    }   // end of while

  } // $mp if close

}

function getEstiList($mb_id){

  // 고객 IDX추출
  $sql = "SELECT * FROM f_member WHERE m_id = '{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));
  $mb_idx = $re['idx'];

  $sql = "SELECT * FROM f_estimate_plz AS e
  INNER JOIN f_tree_order AS t ON e.to_idx = t.idx
  WHERE e.m_idx = {$mb_idx} AND cancel != 'Y'";
  $re = sql_query($sql);
  $re_cnt = sql_num_rows($re);

  $cnt_pi=0;
  $in_num=1;
  while($row = sql_fetch_array($re)){
    $ep_idx = $row['idx'];
    $mypartner = $row['c_partner'];
    $g_work = $row['g_work'];
    $k_tree = $row['k_tree'];
    $w_name = $row['w_name'];
    $to_idx = $row['to_idx'];
    $d_date = $row['d_date'];
    $target = $row['target'];
    $ep_idx = $row['ep_idx'];
    $e_date = $row['e_date'];
    $pbox = explode("|",$row['p_idx']);
    $p_idx = $pbox[$cnt_pi];

    // 농원명 추출
    $partn = getPartnInfo($p_idx);
    $c_name = $partn['c_name'];
    $p_ship = $partn['partner_ship'];

    // 수목 발주품목 추출
    $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
    $to_re = sql_fetch_array(sql_query($to_sql));
    for($i=0; $i<8; $i++){
      $col_name = "item".($i+1);
      if($to_re[$col_name]){
        $box[$i] = $to_re[$col_name];
      }
    }
    $dbox = explode(" ",$to_re['w_date']);
    $w_date = $dbox[0];
    if($g_work==1){
      $g_work_txt = "관급공사(A급 조경수)";
      $g_work_class = "";
    }else if($g_work==2){
      $g_work_txt = "사급공사(B급 조경수)";
      $g_work_class = "green_box";
    }


    if($k_tree==1){
      $k_tree_txt = "교목";
    }else if($k_tree==2){
      $k_tree_txt = "관목";
    }


    // 마감일까지 남은일자 산출
    $now = date("Y-m-d H:i:s");
    $c_d = ceil( (strtotime($d_date) - strtotime($now)) / 86400 );
    $ed_box = explode("-",$e_date);
    $ed_txt = $ed_box[0]."년".$ed_box[1]."월".$ed_box[2]."일";

    $t_name = "target".$ep_idx;
    $ed_name = "ed_date".$ep_idx;

    echo "<div class='main_bottom_box'>";
    echo "<input type='hidden' name='e_date' class='e_date' value='{$e_date}' />";
    echo "<table class='text_table'>";
    echo "<tr><td>";
    echo "<img src='/theme/basic/img/f_ico.png' alt=''포레스트 로고''>";
    if($p_ship == 3){
      $fn_class = "official";
      echo "<p class='partner'>포레스트 공식 파트너</p>";
    }else{
      $fn_class = "";
    }
    echo "</td>";
    echo "<td class='right'>";
    echo "<p class='partner tree'>{$k_tree_txt}</p><p class='partner work {$g_work_class}'>{$g_work_txt}</p>";
    echo "</td></tr>";
    echo "<tr><td><h4 class='farm_name {$fn_class}'>{$c_name}</h4></td>";
    echo "<td><p class='com_date'>등록 : {$w_date}</p></td></tr>";
    echo "<tr><td><p class='work_name'>{$w_name}</p></td>";
    echo "<td><p class='cut_date'>마감까지 {$c_d}일 남음</p></td>";
    echo "</tr></table>";
    echo "<hr style='width:100%;margin:0 auto;margin-top:2px;margin-bottom:6px;'>";
    echo "<ul>";
    for($a=0; $a<count($box); $a++){
      echo "<li>".$box[$a]."</li>";
    }
    echo "</ul>";
    echo "<div class='edit_input'>";
    echo "<div>";
    echo "<img src='/theme/basic/img/date.png' alt='납품 날짜'>";
    echo "</div>";
    echo "<div>";
    echo "<p>납품 날짜 : <input type='text' name='ed_date' class='{$ed_name}' value='{$ed_txt}' readonly /></p>";
    echo "</div>";
    echo "</div>";
    echo "<div class='edit_input'>";
    echo "<div>";
    echo "<img src='/theme/basic/img/location.png' alt='납품 장소'>";
    echo "</div>";
    echo "<div>";
    echo "<p>납품 장소 : <input type='text' name='target' class='{$t_name}' value='{$target}' readonly /></p>";
    echo "</div>";
    echo "</div>";
    echo "<p class='btn_date'><span onclick='editDPinfo({$ep_idx},{$re_cnt})' class='change'>납품 날짜 및 장소 변경</span></p>";
    echo "<hr style='width:100%;margin:0 auto;margin-top:12px;margin-bottom:12px;'>";
    echo "<div class='info'>";
    echo "<div><a class='estimate' href='/theme/basic/mobile/esti_comp.php?ep_idx={$ep_idx}' class='brown_box'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적서 확인</a>";
    echo "<a class='cancel' onclick='noListExe(2,{$ep_idx})'>거래 취소</a></div>";
    echo "</div>";
    echo "</div>";
    $cnt_pi++;
    $in_num++;
  }
}


function getAccoList($mb_id){
  $sql = "SELECT idx,c_partner FROM f_member WHERE m_id='{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));
  $cbox = explode("|",$re['c_partner']);
  $m_idx = $re['idx'];
  sort($cbox);
  $cnt = count($cbox);

  for($i=0; $i<$cnt; $i++){
    $partn = getPartnInfo($cbox[$i]);
    $c_name = $partn['c_name'];
    $p_idx = $partn['idx'];
    $p_ship = $partn['partner_ship'];

    $npbox = getPointInfo($p_idx);
    $d_num = $npbox[0];
    $t_point = $npbox[1];

    $o_num = getOrderNum($p_idx);

    echo "<div class='sub03_box'>";
    echo "<table class='text_table'><tr><td>";
    echo "<img src='/theme/basic/img/f_ico.png' alt='포레스트 로고'>";
    if($p_ship == 3){
      $fn_class = "official";
      echo "<p class='partner'>포레스트 공식 파트너</p>";
    }else{
      $fn_class = "";
    }
    echo "</td><td><a onclick='delPartner({$p_idx},{$m_idx},2)' class='delete_farm'>거래처 삭제</a></td></tr></table>";
    echo "<table class='text_table'><tr><td>";
    echo "<a href='./sub12.php'><h4 class='farm_name {$fn_class}'>{$c_name}</h4></a>";
    echo "</td><td>";
    echo "<div class='score_box'><div><h4 class='score'>{$t_point}</h4><p>평점</p></div>";
    echo "<div><h4>{$o_num}</h4><p>납품횟수</p></div>";
    echo "<div><h4>{$d_num}</h4><p>후기</p></div></div>";
    echo "</td></tr></table>";
    echo "<hr style='width:100%;margin:0 auto;margin-top:8px;margin-bottom:8px;'>";
    echo "<div class='ask'><a href='./estimate_plz.php?p_idx={$p_idx}'>견적 신청 &nbsp; &gt;</a></div>";
    echo "</div>";

  }


}


function getEpDetail($epidx,$mb_id){

  $sql = "SELECT *,(e.idx) FROM f_estimate_plz AS e
  INNER JOIN f_tree_order AS t ON e.to_idx = t.idx
  WHERE e.idx = {$epidx}";
  $row = sql_fetch_array(sql_query($sql));

  $ep_idx = $row['idx'];
  $mypartner = $row['c_partner'];
  $g_work = $row['g_work'];
  $k_tree = $row['k_tree'];
  $w_name = $row['w_name'];
  $to_idx = $row['to_idx'];
  $m_idx = $row['m_idx'];
  $d_date = $row['d_date'];

  // 파트너 IDX추출
  $sql = "SELECT idx FROM f_partner WHERE p_id = '{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));
  $p_idx = $re['idx'];

  // 업체명 추출
  $m_sql = "SELECT c_name FROM f_member WHERE idx = {$m_idx}";
  $m_re = sql_fetch_array(sql_query($m_sql));
  $c_name = $m_re['c_name'];

  // 수목 발주품목 추출
  $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
  $to_re = sql_fetch_array(sql_query($to_sql));
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

  // 마감일까지 남은일자 산출
  $now = date("Y-m-d H:i:s");
  $c_d = ceil( (strtotime($d_date) - strtotime($now)) / 86400 );

  echo "<div class='main_bottom_box'>";
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
  echo "<tr><td><a href=''./sub12.php'><h4 class='farm_name'>{$c_name}</h4></a></td>";
  echo "<td><p class='com_date'>등록 : {$w_date}</p></td></tr>";
  echo "<tr><td><p class='work_name'>{$w_name}</p></td>";
  echo "<td><p class='cut_date'>마감까지 {$c_d}일 남음</p></td>";
  echo "</tr></table>";
  echo "</div>";

}

function viewTreeInput($epidx){
  // 수목 발주 고유번호추출
  $sql = "SELECT to_idx FROM f_estimate_plz WHERE idx = '{$epidx}'";
  $re = sql_fetch_array(sql_query($sql));
  $to_idx = $re['to_idx'];

  // 수목 발주품목 추출
  $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
  $to_re = sql_fetch_array(sql_query($to_sql));
  for($i=0; $i<8; $i++){
    $col_name1 = "item".($i+1);
    $col_name2 = "osum".($i+1);
    $col_name3 = "size".($i+1);
    if($to_re[$col_name1]){
      $box1[$i] = $to_re[$col_name1];
      $box2[$i] = $to_re[$col_name2];
      $box3[$i] = $to_re[$col_name3];
    }
  }

  echo '<div class="size">';
  echo '<div class="size_title"><p>품목</p> <p>규격</p> <p>수량</p> <p>납품 단가</p></div>';
  echo '<hr style="width:100%;margin:0 auto;border:1px solid #bbb;margin-top:0px;margin-bottom:4px;">';
  $cnt_sum = count($box1);
  for($a=0; $a<$cnt_sum; $a++){
    $osum_txt = "osum".($a+1);
    $price_txt = "price".($a+1);
    $sbox = explode("|",$box3[$a]);
    $s_h = $sbox[0];
    $s_w = $sbox[1];
    echo "<div><p>{$box1[$a]}</p> <p>H{$s_h}x W{$s_w}</p> <p>{$box2[$a]}</p>";
    echo "<input type='text' name='{$price_txt}' class='gray_box' placeholder='입력' onchange='sum_price({$cnt_sum})'/></div>";
    echo '<input type="hidden" name="'.$osum_txt.'" value="'.$box2[$a].'" />';
    if($a < count($box1)-1){
      echo '<hr style="width:100%;margin:0 auto;margin-top:0px;margin-bottom:4px;">';
    }
  }
  echo '</div>';

}


function attachPic($epidx){
  // 수목 발주 고유번호추출
  $sql = "SELECT to_idx FROM f_estimate_plz WHERE idx = '{$epidx}'";
  $re = sql_fetch_array(sql_query($sql));
  $to_idx = $re['to_idx'];

  // 수목 발주품목 추출
  $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
  $to_re = sql_fetch_array(sql_query($to_sql));
  for($i=0; $i<8; $i++){
    $col_name = "item".($i+1);
    if($to_re[$col_name]){
      $box[$i] = $to_re[$col_name];
    }
  }

  $cnt = count($box);
  $classname = "back_img";
  $input_id = "pic";

  for($i=0; $i<$cnt; $i++){
    if($i == 0 || $i == 3 || $i == 6){
      echo "<div class='pic_cont'>";
    }
    $class_txt = $classname.($i+1);
    $input_txt = $input_id.($i+1);
    echo "<div class='file_custom {$class_txt}'>";
    echo "<label for='{$input_txt}'>+사진 추가하기</label>";
    echo "<input type='file' id='{$input_txt}' name='{$input_txt}' value='사진 추가하기' />";
    echo "</div>";

    if($i == 2 || $i == 5 || $i == 7){
      echo "</div>";
    }
  }

}

function setPic($epidx){
  // 수목 발주 고유번호추출
  $sql = "SELECT to_idx FROM f_estimate_plz WHERE idx = '{$epidx}'";
  $re = sql_fetch_array(sql_query($sql));
  $to_idx = $re['to_idx'];

  // 수목 발주품목 추출
  $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
  $to_re = sql_fetch_array(sql_query($to_sql));
  for($i=0; $i<8; $i++){
    $col_name = "item".($i+1);
    if($to_re[$col_name]){
      $box[$i] = $to_re[$col_name];
    }
  }


  $cnt = count($box);

  echo "

  let sel_file;
  $(document).ready(function(){
  ";






  for($i=0; $i<$cnt; $i++){
    $funcName = "view_pic".($i+1);
    $className = "back_img".($i+1);
    $idName = "pic".($i+1);

    echo "

    $('#{$idName}').on('change', {$funcName});
    function {$funcName}(e){
      let files = e.target.files;
      let filesArr = Array.prototype.slice.call(files);

      filesArr.forEach(function(f){
        if(!f.type.match('image.*')){
          alert('이미지파일을 선택 해 주세요.');
          return;
        }

        sel_file = f;
        let reader = new FileReader();
        reader.onload = function(e){
          $('.{$className}').css({'background': 'url('+e.target.result+')'});
          $('.{$className}').css({'background-repeat': 'no-repeat'});
          $('.{$className}').css({'background-size': 'contain'});
        }
        reader.readAsDataURL(f);

      });
    }
      ";
  }

  echo "});"; // document ready cloase

}

function getWorkInfo($epidx){
  $sql = "SELECT * FROM f_estimate_plz WHERE idx = {$epidx}";
  $box = sql_fetch_array(sql_query($sql));

  $return_data = $box['target']."|".$box['d_date']."|".$box['memo'];
  return $return_data;
}

function getDdate($epidx){
  $sql = "SELECT * FROM f_estimate_plz WHERE idx = {$epidx}";
  $box = sql_fetch_array(sql_query($sql));

  $e_date = $box['e_date'];

  $now = date("Y-m-d H:i:s");
  $c_d = ceil( (strtotime($e_date) - strtotime($now)) / 86400 );

  return $c_d;

}

function getNum($epidx){
  // 수목 발주 고유번호추출
  $sql = "SELECT to_idx FROM f_estimate_plz WHERE idx = '{$epidx}'";
  $re = sql_fetch_array(sql_query($sql));
  $to_idx = $re['to_idx'];

  // 수목 발주품목 추출
  $to_sql = "SELECT * FROM f_tree_order WHERE idx = {$to_idx}";
  $to_re = sql_fetch_array(sql_query($to_sql));
  for($i=0; $i<8; $i++){
    $col_name = "item".($i+1);
    if($to_re[$col_name]){
      $box[$i] = $to_re[$col_name];
    }
  }

  $cnt = count($box);
  return $cnt;

}

function getEsti($mb_id,$ep_idx){
  $sql = "SELECT idx FROM f_partner WHERE p_id = '{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));
  $p_idx = $re['idx'];

  $sql = "SELECT p_idx FROM f_estimate_plz WHERE idx ={$ep_idx}";
  $re = sql_fetch_array(sql_query($sql));
  $box = explode("|",$re['p_idx']);
  $jud = in_array($p_idx,$box);

  return $jud;

}

function getInfo($mb_id,$mb_type){
  $tbl_name = "f_".$mb_type;
  if($mb_type == "partner"){
    $col_name = "p_id";
  }else{
    $col_name = "m_id";
  }

  $sql = "SELECT * FROM {$tbl_name} WHERE {$col_name} = '{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
}

function myEstiList($mb_id){
  // 고객 IDX추출
  $sql = "SELECT idx FROM f_member WHERE m_id = '{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));
  $m_idx = $re['idx'];

  // 견적의뢰 테이블에서 해당 고객이 의뢰한 견적의뢰 고유번호 추출
  $sql = "SELECT * FROM f_estimate_plz as ep INNER JOIN f_tree_order as t ON ep.to_idx = t.idx
  WHERE ep.m_idx = {$m_idx} and ep.no_list != 'Y' and ep.cancel != 'Y'";
  $re = sql_query($sql);


  while($row = sql_fetch_array($re)){
      $o_comp = $row['o_idx'];
      $ep_idx = $row['ep_idx'];
      if($o_comp == 0){
        $oc_name = "ing";
        $oc_txt = "거래중";
        $cancel_btn = "견적의뢰 취소";
        $list_type=2;
      }else{
        $oc_name = "end";
        $oc_txt = "거래완료";
        $cancel_btn = "내역 삭제";
        $list_type=1;
      }

      // 마감일까지 남은일자 산출
      $now = date("Y-m-d H:i:s");
      $c_d = ceil( (strtotime($row['e_date']) - strtotime($now)) / 86400 );

      $w_name = $row['w_name'];
      $e_date = $row['e_date'];

      $cnt = getNum($row['ep_idx']);
      // 발주 수목 품명 추출
      for($i=0; $i<$cnt; $i++){
        $col_name = "item".($i+1);
        $box[$i] = $row[$col_name];
      }
      $ed_box = explode("-",$e_date);
      $target = $row['target'];

      echo "<div class='sub01_box'>\n";
      echo "<table class='text_table'>\n";
      echo "<tr><td><p class='{$oc_name}'>{$oc_txt}</p></td>\n";
      echo "<td><p class='com_date'>입찰 마감 : {$e_date}</p></td></tr>\n";
      echo "</table>\n";
      echo "<p class='cut_date'>입찰 마감까지 {$c_d}일 남음</p>\n";
      echo "<h4 class='work_name'>{$w_name}</h4>\n";
      echo "<hr style='width:100%;margin:0 auto;margin-top:10px;margin-bottom:10px;'>\n";
      echo "<ul>";
      for($a=0; $a<count($box); $a++){
        echo "<li>".$box[$a]."</li>";
      }
      echo "</ul>";
      echo "<div><img src='/theme/basic/img/date.png' alt='납품 날짜'><p>납품 날짜 : ".$ed_box[0]."년 ".$ed_box[1]."월 ".$ed_box[2]."일</p></div>\n";
      echo "<div><img src='/theme/basic/img/location.png' alt='납품 장소'><p>납품 장소 : {$target}</p></div>\n";
      echo "<hr style='width:100%;margin:0 auto;margin-top:12px;margin-bottom:12px;'>\n";
      echo "<div class='sub01_btn'>\n";
      echo "<p class='cancel' onclick='noListExe({$list_type},{$ep_idx})'>{$cancel_btn}</p>\n";
      echo "<a href='./esti_comp.php?ep_idx={$ep_idx}'><p class='estimate'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적서 확인</p></a>\n";
      echo "</div>\n";
      echo "</div>\n";
  }

}


function getEstiPartner($pidx,$w_name,$ep_idx){
  $p_box = explode("|",$pidx);
  $cnt = count($p_box);

  for($i=0; $i<$cnt; $i++){
    $p_idx = $p_box[$i];

    // 견적 정보
    $sql = "SELECT idx,t_price,nopt FROM f_estimate WHERE p_idx = {$p_idx}";
    $box = sql_fetch_array(sql_query($sql));
    $t_price = number_format($box['t_price']);
    $esti_idx = $box['idx'];
    $nopt = $box['nopt'];

    if($nopt=="Y"){

    }else{
      // 파트너 정보
      $sql = "SELECT * FROM f_partner WHERE idx={$p_idx}";
      $box = sql_fetch_array(sql_query($sql));
      $p_ship = $box['partner_ship'];
      $c_name = $box['c_name'];

      $npbox = getPointInfo($p_idx);
      $pscore_num = $npbox[0];
      $t_point = $npbox[1];


      // 주문 횟수 산출
      $o_num = getOrderNum($p_idx);

      echo "<div class='big_box'>";
      echo "<table class='text_table'>";
      echo "<tr><td>";
      echo "<img src='/theme/basic/img/f_ico.png' alt='포레스트 로고'>";
      if($p_ship == 3){
        $fn_class = "official";
        echo "<p class='partner'>포레스트 공식 파트너</p>";
      }else{
        $fn_class = "";
      }
      echo "</td></tr>";
      echo "</table>";
      echo "<div class='sub08_score'>";
      echo "<a href='./partner_info.php?idx={$p_idx}'><h4 class='farm_name {$fn_class}'>{$c_name}</h4></a>";
      echo "<div class='score_box'>";
      echo "<div><h4 class='score'>{$t_point}</h4><p>평점</p></div>";
      echo "<div><h4 class='score'>{$o_num}</h4><p>납품횟수</p></div>";
      echo "<div><h4 class='score'>{$pscore_num}</h4><p>후기</p></div>";
      echo "</div>";
      echo "</div>";
      echo "<div class='price'>";
      echo "<p class='margin'>{$w_name}</p><p><span>{$t_price}</span>원</p>";
      echo "</div>";
      echo "<hr style='width:100%;margin:0 auto;margin-top:8px;margin-bottom:8px;'>";
      echo "<div class='sub08_btn'>";
      echo "<p class='cancel' onclick='noptEsti({$esti_idx})'>견적거절</p>";
      echo "<a href='./esti_detail.php?e_idx={$esti_idx}' class='estimate'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적서 및 사진 확인</a>";
      echo "</div>";
      echo "</div>";
    }   // nopt if close
  }
}

function getReply($p_idx){
  $sql = "SELECT * FROM f_partner_ship WHERE p_idx={$p_idx}";
  $re = sql_query($sql);
  $num = sql_num_rows($re);

  while($row = sql_fetch_array($re)){
    $obox .= ($row['o_idx']."|");
    $cbox .= ($row['comment']."|");
    $wbox .= ($row['w_date']."|");
  }
  $bbox = explode("|",$obox);
  $bbox2 = explode("|",$cbox);
  $bbox3 = explode("|",$wbox);

  for($i=0; $i<$num; $i++){
    // 견적 고유번호 추출
    $sql = "SELECT e_idx FROM f_order WHERE idx =".$bbox[$i];
    $ebox = sql_fetch_array(sql_query($sql));
    $eidx = $ebox['e_idx'];

    // 견적의뢰 고유번호 추출
    $sql = "SELECT ep_idx FROM f_estimate WHERE idx = {$eidx}";
    $epbox = sql_fetch_array(sql_query($sql));
    $epidx = $epbox['ep_idx'];

    // 공사명 추출
    $sql = "SELECT w_name,m_idx FROM f_estimate_plz WHERE idx = {$epidx}";
    $box = sql_fetch_array(sql_query($sql));
    $w_name = $box['w_name'];
    $m_idx = $box['m_idx'];

    // 고객사명 추출
    $sql = "SELECT c_name FROM f_member WHERE idx = {$m_idx}";
    $box = sql_fetch_array(sql_query($sql));
    $c_name = $box['c_name'];

    $comment = $bbox2[$i];
    $dbox = explode(" ",$bbox3[$i]);
    $w_date = $dbox[0];


    echo "<div class='re_con'>";
    echo "<div class='re_big_tit'>";
    echo "<div class='work_img'><img src='/theme/basic/img/work_name.png' alt=''></div>";
    echo "<div class='re_tit'>";
    echo "<div><p class='bold'>{$w_name}</p></div>";
    echo "<p>{$c_name}</p>";
    echo "</div>";
    echo "<div><p>{$w_date}</p></div>";
    echo "</div>";
    echo "<div><p class='text'>{$comment}</p></div>";
    echo "</div>";
    echo "<hr style='width:100%;margin:0 auto;margin-top:15px;margin-bottom:15px;'>";
  }
}

function getOrderComp($p_idx){
  $sql = "SELECT * FROM f_partner_ship WHERE p_idx = {$p_idx}";
  $re = sql_query($sql);
  $cnt = sql_num_rows($re);


  $wcnt = 1;
  while($row = sql_fetch_array($re)){
    $o_idx = $row['o_idx'];

    $sql = "SELECT idx,w_name FROM f_estimate_plz WHERE o_idx={$o_idx}";
    $box = sql_fetch_array(sql_query($sql));
    $w_name = $box['w_name'];
    $ep_idx = $box['idx'];

    $sql = "SELECT t_price FROM f_estimate WHERE ep_idx={$ep_idx} AND p_idx={$p_idx}";
    $box = sql_fetch_array(sql_query($sql));
    $t_price = number_format($box['t_price']);

    echo "<div class='delivery_con'>";
    echo "<div class='de_img'><img src='/theme/basic/img/noimage.png' alt='{$w_name}'></div>";
    echo "<div class='de_txt'>";
    echo "<h4 class='bold'>{$w_name}</h4>";
    echo "<p>&#92;{$t_price}</p>";
    echo "</div>";
    echo "</div>";
    if($wcnt < $cnt){
      echo "<hr style='width:100%;margin:0 auto;margin-top:15px;margin-bottom:15px;'>";
    }

    $wcnt++;
  }



}

function getEpData($ep_idx){
  // 해당 견적의뢰 고유번호와 연결된 발주수목 데이터를 같이 추출
  $sql = "SELECT * FROM f_estimate_plz as ep INNER JOIN f_tree_order as t ON ep.to_idx = t.idx
  WHERE ep.idx = {$ep_idx}";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
}

function getPartnerGrade($p_idx){
  $sql = "SELECT f_partner_ship FROM f_partner WHERE idx={$p_idx}";
  $box = sql_fetch_array(sql_query($sql));

  return $box['partner_ship'];
}

function getEstiInfo($e_idx){
  $sql = "SELECT * FROM f_estimate WHERE idx={$e_idx}";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
}

function getEpInfo($ep_idx){
  $sql = "SELECT * FROM f_estimate_plz WHERE idx={$ep_idx}";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
}

function getTreeInfo($to_idx){
  $sql = "SELECT * FROM f_tree_order WHERE idx={$to_idx}";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
}

function getPartnInfo($p_idx){
  $sql = "SELECT * FROM f_partner WHERE idx={$p_idx}";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
}

function getTreeNum($to_idx){
  $sql = "SELECT * FROM f_tree_order WHERE idx={$to_idx}";
  $re = sql_fetch_array(sql_query($sql));
  $cnt = 0;
  for($i=0; $i<8; $i++){
    $col_name = "item".($i+1);
    if($re[$col_name]){
      $cnt++;
    }
  }

  return $cnt;
}

function getOrderNum($p_idx){
  // 주문 횟수(납품 횟수)
  $sql = "SELECT idx FROM f_estimate WHERE p_idx = {$p_idx}";
  $re = sql_query($sql);
  $o_num = 0;
  while($row = sql_fetch_array($re)){
    $e_idx = $row['idx'];
    $cnt_sql = "SELECT * FROM f_order WHERE e_idx = {$e_idx}";
    $jud = sql_num_rows(sql_query($cnt_sql));
    $o_num += $jud;
  }

  return $o_num;
}

function getPointInfo($p_idx){
  // 농원 평가 정보 - 코멘트가 공백이 아닌것
  $sql = "SELECT * FROM f_partner_ship WHERE p_idx = {$p_idx}";
  $re = sql_query($sql);

  // 납품건수
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

  $return_box[0] = $pscore_num;
  $return_box[1] = $t_point;


  return $return_box;
}

function getMbInfo($mb_id){
  $sql = "SELECT * FROM f_member WHERE m_id='{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));

  return $re;

}

function getMbIdx($mb_id){
  $sql = "SELECT idx FROM f_member WHERE m_id = '{$mb_id}'";
  $box = sql_fetch_array(sql_query($sql));

  return $box['idx'];
}

?>
