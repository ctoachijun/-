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

  case "pay_conf_m":
    if($jud=="Y"){
      $depo = 1;
    }else if($jud=="N"){
      $depo = 2;
    }

    $sql = "UPDATE f_deposit SET m_deposit={$depo}, m_pay_date=DEFAULT WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "pay_conf_p":
    if($jud=="Y"){
      $depo = 1;
    }else if($jud=="N"){
      $depo = 2;
    }

    $sql = "UPDATE f_deposit SET p_deposit={$depo}, p_pay_date=DEFAULT WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "edit_menu" :

    if($type=="ld"){
      $tbl_name = "f_late_delivery";
    }else{
      $tbl_name = "f_cancel_bidding";
    }


    $box = explode("|",$data);
    $cnt = count($box);

    for($i=0; $i<8; $i++){
        $col_txt = "menu".($i+1);
        $$col_txt = $box[$i];

        if($i==7){
          $set_txt .= $col_txt."='".$$col_txt."' ";
        }else{
          $set_txt .= $col_txt."='".$$col_txt."',";
        }
    }

    $sql = "SELECT * FROM {$tbl_name}";
    $jud = sql_num_rows(sql_query($sql));

    if($jud==0){
      $sql = "INSERT INTO {$tbl_name} SET {$set_txt}";
    }else{
      $sql = "UPDATE {$tbl_name} SET {$set_txt}";
    }
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
      $output['sql'] = $sql;
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "edit_agree" :
    $sql = "SELECT * FROM f_agree";
    $jud = sql_num_rows(sql_query($sql));

    if($jud==0){
      $sql = "INSERT INTO f_agree SET content='{$content}', w_date=DEFAULT";
    }else{
      $sql = "UPDATE f_agree SET content='{$content}', w_date=DEFAULT";
    }
    $re = sql_query($sql);
          $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
      $output['sql'] = $sql;
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

}





?>
