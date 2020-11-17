<?php
include_once('../../../common.php');

$return_url = $_SERVER['HTTP_REFERER'];

switch($w_type){
  case "esti_plz" :

    // 거래처 지정 견적의뢰 여부
    if($only){
      $only_txt = ", only = 'Y', p_idx = {$only}";
    }

        //  견적의뢰 테이블에 데이터 입력
    $sql = "INSERT INTO f_estimate_plz SET
    m_idx = {$m_idx}, w_name = '{$w_name}', g_work = {$w_class}, k_tree = {$t_class},
    target = '{$w_place}', d_date = '{$wr_1}', memo = '{$memo}', e_date = '{$wr_2}'
    {$only_txt}";
    $re1 = sql_query($sql);
    // print_r($_POST);

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
        $t_osum = preg_replace("/[^0-9]*/s", "", $total[$i]);

        $col_txt2 = $col_name2."=".$t_osum;

        if($h_size[$i] || $w_size[$i]){
          $size_val = $h_size[$i]."|".$w_size[$i];
        }else{
          $size_val = null;
        }
        $col_name3 = "size".($i+1);
        $col_txt3 = $col_name3."= '".$size_val."'";

        $col_txt .= $col_txt1.",".$col_txt2.",".$col_txt3.",";
        $t_osum = 0;
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

  case "ins_esti" :

    $return_url = "http://softer036.cafe24.com/theme/basic/mobile/partner/view_pesti.php";
    $tbl_name = "f_".$mb_type;
    if($mb_type=="partner"){
        $col_name = "p_id";
    }else{
      $col_name = "m_id";
    }

    $s_sql = "SELECT idx,c_name FROM {$tbl_name} WHERE {$col_name} = '{$mb_id}'";
    $box = sql_fetch_array(sql_query($s_sql));
    $mb_idx = $box['idx'];
    $c_name = $box['c_name'];



    for($i=0; $i<$num; $i++){
      $price_txt = "price".($i+1);
      $pic_txt = "pic".($i+1);

      // 파일 업로드 밑준비
      $file = $_FILES[$pic_txt];
      $f_name = $file['name'];
      if($f_name){
        $f_err = $file['error'];
        $f_size = $file['size'];
        $f_type = $file['type'];
        $f_tmp = $file['tmp_name'];
        $f_name = $file['name'];

        $utime_txt = "utime".($i+1);
        $$utime_txt = strtotime("+{$i} seconds");
        $img_src = G5_THEME_PATH."/img/forest/";

        $box1 = explode('.',$f_name);
        $f_whak = end($box1);
        $f_name = $$utime_txt.".".$f_whak;

        // 파일 업로드 관련 처리 err 4 = 파일이름 없음(파일 안올릴때)
        if($f_err != 4){
          if($f_err == 1){
            $return_txt = "업로드에 실패했습니다.";
          }else{
            if($f_name && file_exists("../img/forest/".$f_name)){
              $return_txt = "파일 이름 중복입니다.";
            }else{
              $re = move_uploaded_file($f_tmp, "../img/forest/".$f_name);
              if(!$re){
                $return_msg = "파일 업로드 실패입니다.";
              }
            }
          }
        }

      }

      if($i == ($num-1)){
        $notcom = preg_replace("/[^0-9]*/s", "", $$price_txt);
        $price_col_txt .= "{$price_txt} = {$notcom}";
        $pic_col_txt .= "{$pic_txt} = '{$f_name}'";
      }else{
        $notcom = preg_replace("/[^0-9]*/s", "", $$price_txt);
        $price_col_txt .= "{$price_txt} = {$notcom}, ";
        $pic_col_txt .= "{$pic_txt} = '{$f_name}', ";
      }

    }

    $d_price = preg_replace("/[^0-9]*/s", "", $d_price);
    $tep = preg_replace("/[^0-9]*/s", "", $tep);
    $sql = "INSERT INTO f_estimate SET
    p_idx = {$mb_idx}, ep_idx = {$ep_idx}, p_name = '{$c_name}',
    {$pic_col_txt}, {$price_col_txt},
    d_price = {$d_price}, t_price={$t_price},w_date=DEFAULT, etc='{$etc}'";
    sql_query($sql);
    // echo "$sql <br>";
    // exit;

    $sql = "SELECT idx FROM f_estimate WHERE ep_idx = {$ep_idx} ORDER BY idx DESC";
    $box = sql_fetch_array(sql_query($sql));
    $e_idx = $box['idx'];

    // $sql = "UPDATE f_estimate_plz SET e_idx = {$e_idx} WHERE idx = {$ep_idx}";
    // sql_query($sql);
    // echo "$sql <br>";


    //  견적의뢰 한건당 몇명의 파트너가 견적을 냈는지를 기록
    $sql = "SELECT p_idx,only FROM f_estimate_plz WHERE idx = {$ep_idx}";
    $box = sql_fetch_array(sql_query($sql));
    $pbox = explode("|",$box['p_idx']);
    $cnt = count($pbox);
    $only = $box['only'];

    if($only=='N'){
      for($i=0; $i<=$cnt; $i++){
        if($pbox[$i]){
          $p_idx_txt .= $pbox[$i];
          $p_idx_txt .= "|";
        }
      }
    }
    $p_idx_txt .= $mb_idx;

    $sql = "UPDATE f_estimate_plz SET p_idx = '{$p_idx_txt}' WHERE idx = {$ep_idx}";
    sql_query($sql);

    if(!$return_msg){
      $return_msg = "정상적으로 등록이 되었습니다";
    }

    alert($return_msg,$return_url);
  break;

  case "m_payment" :
    $sql = "SELECT * FROM f_estimate WHERE idx={$e_idx}";
    $re = sql_fetch_array(sql_query($sql));
    $p_idx = $re['p_idx'];
    $t_price = $re['t_price'];
    $d_price = $re['d_price'];

    $sql = "SELECT * FROM f_estimate_plz WHERE idx={$ep_idx}";
    $re = sql_fetch_array(sql_query($sql));

    $to_idx = $re['to_idx'];
    $m_idx = $re['m_idx'];

    // 주문정보 입력
    $sql = "INSERT INTO f_order SET
    p_idx={$p_idx}, m_idx={$m_idx}, e_idx={$e_idx}, to_idx={$to_idx}, o_date=DEFAULT";
    $re = sql_query($sql);


    // 견적의뢰 테이블에 주문번호 입력
    $sql = "SELECT idx FROM f_order ORDER BY idx DESC";
    $obox = sql_fetch($sql);
    $o_idx = $obox['idx'];

    $sql = "UPDATE f_estimate_plz SET o_idx={$o_idx} WHERE idx={$ep_idx}";
    sql_query($sql);


    // 고객 수수료율
    $sql = "SELECT * FROM f_fee_m";
    $box = sql_fetch($sql);
    $mtep = $box['tep'] / 100;
    $mfee = $t_price * $mtep;

    // 농원 수수료율
    $sql = "SELECT partner_ship FROM f_partner WHERE idx={$p_idx}";
    $box = sql_fetch($sql);
    $ps = $box['partner_ship'];
    $t_txt = "tep".$ps;

    $sql = "SELECT * FROM f_fee_p";
    $box = sql_fetch($sql);
    $ptep = $box[$t_txt] / 100;
    $pfee = $t_price * $ptep;

    //수수료를 더한 고객 결제금액
    $m_price = $t_price + $mfee + $d_price;

    // 수수료를 제한 농원 입금금액
    $p_price = $t_price - $pfee + $d_price;



    // 결제정보 입력
    $sql = "INSERT INTO f_deposit SET
    o_idx={$o_idx}, m_idx={$m_idx}, p_idx={$p_idx}, e_idx={$e_idx}, m_price={$m_price}, p_price={$p_price}, m_push_date=DEFAULT";
    $re = sql_query($sql);
// echo $sql;
// exit;

    $sql = "SELECT c_name FROM f_member WHERE idx={$m_idx}";
    $box = sql_fetch($sql);
    $c_name = $box['c_name'];

    // 푸시, 문자를 보낼 관리자 정보 추출
    $sql = "SELECT * FROM f_sms_admin";
    $re = sql_query($sql);
    $ids = array();
    $keys = array();
    while($row = sql_fetch_array($re)){
      if(trim($row['admin_id'])){
        $aid = $row['admin_id'];
        $sql = "SELECT token FROM f_member WHERE m_id='{$aid}'";
        $tbox = sql_fetch($sql);
        if(trim($tbox['token'])){
          array_push($keys,$tbox['token']);
        }
      }
    }

    $price = number_format($m_price);
    // 여기에 관리자 푸시 처리
    $title = "[입금확인 요청]";
    $content = "'{$c_name}' 회원님 \n'{$price}' 원의 입금요청이 있습니다.\n";
    $content .= "확인 후 관리자페이지에서 입금완료 처리를 해주세요.";
    $p_re = send_push($keys,$title,$content,$img_url='');


    // 관리자 문자 전송 처리
    $sql = "SELECT * FROM f_sms_admin";
    $re = sql_query($sql);
    while($rs = sql_fetch_array($re)){
      $admin_tel = $rs['admin_tel'];
      if($admin_tel){
        $send_tel .= $admin_tel;
        $send_tel .= ",";
      }
    }

    $box = explode(",",$send_tel);
    $cnt = count($box);

    for($i=0; $i<$cnt; $i++){
      $send_txt .= $box[$i];
      if($i<$cnt-2){
        $send_txt .= ",";
      }
    }

    $msg .= "[트리넥트]\n[입금확인요청]\n";
    $msg .= "'{$c_name}' 회원님 \n'{$price}' 원의 입금요청이 있습니다\n";
    $msg .= "확인 후 관리자페이지에서 입금완료 처리를 해주세요.";

    $rs = send_certNum($msg,$send_txt);

    $rs_code = $rs->result_code;
    if($rs_code > 0){
      alert("정상적으로 입금 확인요청이 되었습니다.","./view_esti.php");
    }else{
      alert("시스템상에 오류가 있습니다. 관리자에게 문의주세요.",$return_url);
    }
  break;

  case "add_wpic" :
    // 파일 업로드 밑준비
    $file = $_FILES['w_pic'];
    $f_name = $file['name'];
    if($f_name){
      $f_err = $file['error'];
      $f_size = $file['size'];
      $f_type = $file['type'];
      $f_tmp = $file['tmp_name'];
      $f_name = $file['name'];

      $utime_txt = "utime".($i+1);
      $$utime_txt = strtotime("+{$i} seconds");
      $img_src = G5_THEME_PATH."/img/forest/";

      $box1 = explode('.',$f_name);
      $f_whak = end($box1);
      $f_name = $$utime_txt.".".$f_whak;

      // 파일 업로드 관련 처리 err 4 = 파일이름 없음(파일 안올릴때)
      if($f_err != 4){
        if($f_err == 1){
          $return_txt = "업로드에 실패했습니다.";
        }else{
          if($f_name && file_exists($img_src.$f_name)){
            $return_txt = "파일 이름 중복입니다.";
          }else{
            $re = move_uploaded_file($f_tmp, $img_src.$f_name);
            if(!$re){
              $return_msg = "파일 업로드 실패입니다.";
            }
          }
        }
      }

    }

    if(!$return_msg){
      $sql = "UPDATE f_estimate SET w_pic='{$f_name}' WHERE idx={$e_idx}";
      $re = sql_query($sql);
      if($re){
        $return_msg = "정상적으로 등록되었습니다.";
      }
    }
    alert($return_msg,$return_url);

  break;




}


?>
