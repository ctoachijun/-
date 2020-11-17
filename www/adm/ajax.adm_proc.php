<?php
include_once('./_common.php');

switch ($w_type){
  case "edit_partner":
    $m_tel = hyphen_hp_number($m_tel);
    // 입력된 값으로 데이터 업데이트
    $sql = "UPDATE f_partner SET
    m_name='{$m_name}', position='{$position}',c_boss='{$c_boss}', c_name='{$c_name}',addr1='{$addr1}',addr2='{$addr2}',m_tel='{$m_tel}',
    c_tel='{$c_tel}',bank_name='{$bank_name}',bank_num='{$bank_num}', c_num='{$c_num}'
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
    $m_tel = hyphen_hp_number($m_tel);

    $sql = "UPDATE f_member SET
    c_name='{$c_name}', position='{$position}',c_boss='{$c_boss}', m_name='{$m_name}',addr1='{$addr1}',addr2='{$addr2}',m_tel='{$m_tel}',
    c_tel='{$c_tel}',bank_name='{$bank_name}',bank_num='{$bank_num}', c_num='{$c_num}'
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

    $t_sql = "SELECT idx as t FROM {$t_name} WHERE live = 'Y' AND alarm='Y'";
    $re = sql_num_rows(sql_query($t_sql));


    // 전송 할 회원의 휴대폰번호를 수납
    $tel_sql = "SELECT m_tel FROM {$t_name} WHERE live = 'Y' AND alarm='Y'";
    $tel_re = sql_query($tel_sql);
    $m_tels = array();
    while($row = sql_fetch_array($tel_re)){
      $box = explode("-",$row['m_tel']);
      $cnt = count($box);
      $txt = "";
      for($t=0; $t<$cnt; $t++){
        $txt .= $box[$t];
      }
      array_push($m_tels,$txt);
    }

    if($re >= 0){
      $output['state'] = "Y";
      $output['total'] = $re;
      $output['tels'] = $m_tels;
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

    $sql = "UPDATE f_tree_order SET order_sn='{$jud}' WHERE idx={$to_idx}";
    $re = sql_query($sql);

    // $output['sql'] = $jud;
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

  case "fee_apply" :
    $sql = "UPDATE f_fee_m SET tep='{$fee}', w_date=DEFAULT";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);

  break;

  case "fee_apply_p" :
    $sql = "UPDATE f_fee_p SET tep1='{$fee1}', tep2='{$fee2}', tep3='{$fee3}', w_date=DEFAULT";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
      $output['sql'] = $sql;
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);

  break;

  case "approval_p" :
    $sql = "SELECT approval FROM f_partner WHERE idx={$idx}";
    $re = sql_fetch($sql);
    $jud = $re['approval'];

    if($jud == "Y"){
      $app = "N";
      $msg = "승인 취소";
    }else{
      $app = "Y";
      $msg = "승인";
    }

    $sql = "UPDATE f_partner SET approval = '{$app}' WHERE idx={$idx}";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
      $output['msg'] = $msg;
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "wait" :
    $sql = "UPDATE f_wait_service SET wait = '{$wait_val}', w_date=DEFAULT";
    $re = sql_query($sql);

    if($wait_val=="Y"){
      $msg = "서비스 대기 상태로 전환했습니다.";
    }else{
      $msg = "서비스 대기 해제했습니다.";
    }
    if($re){
      $output['state'] = "Y";
      $output['msg'] = $msg;
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "set_rtxt" :
    $sql = "UPDATE f_wait_service SET max_partner = {$max}, cur_partner = {$cur}";
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
