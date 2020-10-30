<?php
include_once('./_common.php');

switch($exe_type){
  case "no_view" :
    $sql = "SELECT no_view FROM f_estimate_plz WHERE idx = {$idx}";
    $box = sql_fetch_array(sql_query($sql));
    $nv_re = $box['no_view'];

    if($nv_re){
      $nv_txt = $nv_re."|".$pidx;
    }else{
      $nv_txt = $pidx;
    }

    $sql = "UPDATE f_estimate_plz SET no_view = '{$nv_txt}' WHERE idx = {$idx}";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "myp_edit" :
    $tbl_name = "f_".$mb_type;

    $sql = "UPDATE {$tbl_name} SET
    m_name = '{$m_name}', position = '{$position}', m_tel = '{$m_tel}', email = '{$email}'
    WHERE idx = {$p_idx}";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "alarmOnoff" :
    $tbl_name = "f_".$mb_type;
    $sql = "UPDATE {$tbl_name} SET alarm='{$alarm}' WHERE idx={$mb_idx}";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "del_list" :
    $sql = "UPDATE f_estimate_plz SET no_list='Y' WHERE idx={$ep_idx}";
    $re = sql_query($sql);
    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "ep_cancel" :
    $sql = "UPDATE f_estimate_plz SET cancel='Y' WHERE idx={$ep_idx}";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "noptEsti" :
    $sql = "UPDATE f_estimate SET nopt='Y' WHERE idx={$e_idx}";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "editInfoDP" :

    $box = explode(" ",$e_date);
    $e_date = $box[0]."-".$box[1]."-".$box[2];

    $sql = "UPDATE f_estimate_plz SET e_date='{$e_date}', target='{$target}' WHERE idx={$ep_idx}";
    sql_query($sql);
    $output['sql'] = $sql;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "acco" :
    $sql = "SELECT c_partner FROM f_member WHERE idx={$m_idx}";
    $re = sql_fetch_array(sql_query($sql));
    $c_partner = $re['c_partner'];
    $box = explode("|",$c_partner);
    sort($box);
    $cnt = count($box);
    $jud = in_array($p_idx,$box);
    $chk = 0;


    // 거래처 등록
    if($type==1){
      if($jud){
        $return_txt = "이미 거래처로 등록이 되어있습니다";
        $chk = 1;
      }else{
        $c_partner .= "|";
        $c_partner .= $p_idx;
        $return_txt = "등록 했습니다";
      }


    }else{
      // 거래처 삭제
      if(!$jud){
        $return_txt = "거래처로 등록되어있지 않습니다.";
        $chk = 1;
      }else{

        for($i=0; $i<$cnt; $i++){
          if($i == $cnt-1){
            $c_partner_txt .= $box[$i];
          }else{
            if($box[$i]!=$p_idx){
              $c_partner_txt .= $box[$i];
              $c_partner_txt .= "|";
              $return_txt = "삭제 했습니다";
            }
          }
        }
        $c_partner = $c_partner_txt;

      }    // if $jud close
    }   // if $type close

    if($chk != 1){
      $sql = "UPDATE f_member SET c_partner='{$c_partner}' WHERE idx={$m_idx}";
      $re = sql_query($sql);
    }


    $output['sql'] = $sql;
    $output['chk'] = $chk;
    $output['r_txt'] = $return_txt;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);

  break;


}




 ?>
