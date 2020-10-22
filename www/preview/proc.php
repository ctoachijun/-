<?php
include_once('../common.php');
include "./head_sub.php";

$return_url = $_SERVER['HTTP_REFERER'];
switch($work){
  case "login" :

    $sql = "SELECT * FROM f_member WHERE m_id = '{$m_id}'";
    $re = sql_fetch_array(sql_query($sql));

    $db_pass = $re['m_pass'];
    if($db_pass != $m_pass){
      $jud = 1;
    }

    if(!$re || $jud==1){
      alert("아이디 또는 비밀번호가 일치하지 않습니다.",$return_url);
    }else{
      if($keep=="ok"){
        set_session('keep','ok');
      }
      set_session('login','success');
      goto_url("./sub01.php");
    }

  break;

  case "sns_join" :
    $check_email=preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);

    echo "djlfd";
    echo $check_email;
    exit;
    if(!$email){
      alert("이메일 주소를 입력 해 주세요.",$return_url);
    }else if($check_email==false){
      alert("이메일 형식을 확인 해 주세요.",$return_url);
    }else{




    }


  break;

}





?>
