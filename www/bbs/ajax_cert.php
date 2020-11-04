<?php
include_once('./_common.php');

switch($w_type){
  case "sms_cert" :

    $datetime = date("Y-m-d H:i:s");
    $cert_num = rand(1000,9999);
    $sql = "INSERT INTO f_sms_cert SET cert_time='{$datetime}', cert_num={$cert_num}, cert_tel='{$tel}'";
    sql_query($sql);
    // 문자보내기 처리
    $msg = "[포레스트]인증번호입니다.";
    $msg .= "{$cert_num}";

    $send_re = send_certNum($msg,$tel);

    $output['re'] = $send_re;
    $output['sql'] = $sql;
    $output['dt'] = $datetime;

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;



}




?>
