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
  }else if($curr_fname == "view_esti.php" || $curr_fname == "view_pesti.php" || $curr_fname == "esti_comp.php"){
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

function getMbIdx($mb_id){
  $sql = "SELECT idx FROM f_member WHERE m_id = '{$mb_id}'";
  $box = sql_fetch_array(sql_query($sql));

  return $box['idx'];
}


function getEstiPlzList($s_type,$t_type,$mb_id){

  // 파트너 IDX추출
  $sql = "SELECT idx FROM f_partner WHERE p_id = '{$mb_id}'";
  $re = sql_fetch_array(sql_query($sql));
  $p_idx = $re['idx'];

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
    $nv_re = in_array($p_idx,$nv_box);

    if(!$nv_re){

      // 공사명 추출
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

      echo "<ul>";
      for($a=0; $a<count($box); $a++){
        echo "<li>".$box[$a]."</li>";
      }
      echo "</ul>";
      echo "<hr style='width:100%;margin:0 auto;margin-top:8px;margin-bottom:12px;'>";
      echo "<div class='info'>";
      echo "<div><a onclick='no_viewPartner({$p_idx},{$ep_idx})'>그만보기</a>";
      echo "<a href='./esti_plz_detail.php?idx={$ep_idx}' class='brown_box'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적의뢰서 확인</a></div>";
      echo "</div>";
      echo "</div>";
    }

    $cnt_pi++;
  }   // end of while
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

  // 공사명 추출
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


function getEpData($ep_idx){
  // 해당 견적의뢰 고유번호와 연결된 발주수목 데이터를 같이 추출
  $sql = "SELECT * FROM f_estimate_plz as ep INNER JOIN f_tree_order as t ON ep.to_idx = t.idx
  WHERE ep.idx = {$ep_idx}";
  $re = sql_fetch_array(sql_query($sql));

  return $re;
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

      // 농원 평가 정보 - 코멘트가 공백이 아닌것
      $sql = "SELECT * FROM f_partner_ship WHERE p_idx = {$p_idx}";
      $re = sql_query($sql);
      $pscore_num = sql_num_rows($re);

      // 평균 평점계산
      $t_point = 0;
      while($row = sql_fetch_array($re)){
        $t_point += $row['point'];
      }
      $t_point /= $pscore_num;

      // 주문 횟수 산출
      $sql = "SELECT idx FROM f_estimate WHERE p_idx = {$p_idx}";
      $re = sql_query($sql);
      $o_num = 0;
      while($row = sql_fetch_array($re)){
        $e_idx = $row['idx'];
        $cnt_sql = "SELECT * FROM f_order WHERE e_idx = {$e_idx}";
        $jud = sql_num_rows(sql_query($cnt_sql));
        $o_num += $jud;
      }

      echo "<div class='big_box'>";
      echo "<table class='text_table'>";
      echo "<tr><td>";
      echo "<img src='/theme/basic/img/f_ico.png' alt='포레스트 로고'>";
      if($p_ship == 3){
        echo "<p class='partner'>포레스트 공식 파트너</p>";
      }
      echo "</td></tr>";
      echo "</table>";
      echo "<div class='sub08_score'>";
      echo "<a href='./sub12.php'><h4 class='farm_name'>{$c_name}</h4></a>";
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
      echo "<a href='./sub09.php' class='estimate'><img src='/theme/basic/img/memo.png' alt='견적서 확인'>견적서 및 사진 확인</a>";
      echo "</div>";
      echo "</div>";
    }   // nopt if close
  }
}

function getPartnerGrade($p_idx){
  $sql = "SELECT partner_ship FROM f_partner WHERE idx={$p_idx}";
  $box = sql_fetch_array(sql_query($sql));

  return $box['partner_ship'];

}




?>
