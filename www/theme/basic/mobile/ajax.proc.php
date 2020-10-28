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

}




 ?>
