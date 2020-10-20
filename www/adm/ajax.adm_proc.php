<?php
include_once('./_common.php');

switch ($w_type){
  case "edit_partner":
    // 입력된 값으로 데이터 업데이트
    $sql = "UPDATE f_partner SET
    m_name='{$m_name}', position='{$position}',c_name='{$c_name}',addr1='{$addr1}',addr2='{$addr2}',m_tel='{$m_tel}',
    c_tel='{$c_tel}',bank_name='{$bank_name}',bank_num='{$bank_num}'
    WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "edit_member":
    $sql = "UPDATE f_member SET
    c_name='{$c_name}', position='{$position}',m_name='{$m_name}',addr1='{$addr1}',addr2='{$addr2}',m_tel='{$m_tel}',
    c_tel='{$c_tel}',bank_name='{$bank_name}',bank_num='{$bank_num}'
    WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "edit_p_ship":
    $ps_sql = "UPDATE f_partner SET partner_ship={$partner_ship}
    WHERE idx={$idx}";
    $re = sql_query($ps_sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "sn_total":
    if($type==1){
      $t_name = "f_partner";
    }else if($type==2){
      $t_name = "f_member";
    }

    $t_sql = "SELECT idx as t FROM {$t_name} WHERE live = 'Y'";
    $re = sql_num_rows(sql_query($t_sql));

    if($re){
      $output['state'] = "Y";
      $output['total'] = $re;
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


}





?>
