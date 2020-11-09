<?php
include_once('./_common.php');

switch($w_type){
  case "sms_cert" :

    $datetime = date("Y-m-d H:i:s");
    $cert_num = rand(1000,9999);
    $sql = "INSERT INTO f_sms_cert SET cert_time='{$datetime}', cert_num={$cert_num}, cert_tel='{$tel}'";
    sql_query($sql);

    // 문자보내기 처리
    $msg = "[트리넥트]\n인증번호 : ";
    $msg .= "{$cert_num}";
    $msg .= "\n\n인증전송은 최대 3회까지입니다.\n";
    $msg .= "참고 부탁드립니다.";

    $send_re = send_certNum($msg,$tel);

    $output['re'] = $send_re;
    $output['sql'] = $sql;
    $output['dt'] = $datetime;

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;



}




?>
