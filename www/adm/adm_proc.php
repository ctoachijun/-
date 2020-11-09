<?php
include_once('./_common.php');


switch ($type){
  case "p_delete":
    $referer = parse_url($_SERVER['HTTP_REFERER']);
    $sql = "UPDATE f_partner SET live='N' WHERE idx={$idx}";
    $re = sql_query($sql);


    if($re==true){
      alert("삭제했습니다","member_list.php?s_key=1");
    }else if($re==false){
      alert("삭제에 실패했습니다",$referer);
    }
  break;

  case "m_delete":
    $referer = parse_url($_SERVER['HTTP_REFERER']);
    $sql = "UPDATE f_member SET live='N' WHERE idx={$idx}";
    $re = sql_query($sql);


    if($re==true){
      alert("삭제했습니다","member_list.php?s_key=1");
    }else if($re==false){
      alert("삭제에 실패했습니다",$referer);
    }
  break;

  case "send_sn":

    $return_url = $_SERVER['HTTP_REFERER'];
    $scheme = $_SERVER['REQUEST_SCHEME'];
    $host = $_SERVER['HTTP_HOST'];
    $hurl = $scheme."://".$host."/adm/img/forest_adm";

    $file = $_FILES['sn_img'];
    $f_err = $file['error'];
    $f_size = $file['size'];
    $f_type = $file['type'];
    $f_tmp = $file['tmp_name'];
    $f_name = $file['name'];
    $allow_file = array("gif", "jpeg", "jpg", "png");

    $utime = strtotime("Now");

    // 파일 확장자 검사
    if($f_name){
      $box = explode(".",$f_name);
      $box_type = end($box);
      $box_re = in_array($box_type,$allow_file);
      if(!$box_re){
        $return_txt = "이미지 파일만 올려주세요.";
      }
      // 파일이름 중복이 없게 timestamp 추가
      $f_name = $box[0]."_".$utime.".".$box_type;
    }

    // 파일 업로드 관련 처리 err 4 = 파일이름 없음(파일 안올릴때)
    if($f_err != 4){
      if($f_err == 1){
        $return_txt = "업로드에 실패했습니다.";
      }else{
        $re = move_uploaded_file($f_tmp, "./img/forest_adm/" . $f_name);
        if(!$re){
          $err_msg = "파일 업로드 실패입니다.";
        }
      }
    }

    if($return_txt){
      alert($return_txt,$return_url);
    }else if($err_msg){
      alert($err_msg,$return_url);
    }else{

      $s_sql = "INSERT INTO f_notice VALUES ('','{$mem_type}','{$t_sum}','{$f_name}','{$f_size}','{$t_cont}',DEFAULT)";
      // 알림과 공지 나눔
      if($kind == "notice"){

        if($mem_type=="P"){
          $tbl_name = "f_partner";
        }else{
          $tbl_name = "f_member";
        }
        $sql = "SELECT token FROM {$tbl_name} WHERE alarm='Y'";
        $re = sql_query($sql);
        $keys = array();
        while($row = sql_fetch_array($re)){
          if(trim($row['token'])){
            array_push($keys,$row['token']);
          }
        }
        $title = "=공지사항=";
        $content = $t_cont;
        $img_url = $hurl."/".$f_name;

        $p_re = send_push($keys,$title,$content,$img_url);
        $s_re = sql_query($s_sql);
        alert("정상적으로 전송되었습니다.",$return_url);

      }else{

        // 알림일경우 문자와 푸시로 나눠서 처리.
        $s_sql = "INSERT INTO f_sms_push VALUES ('','{$mem_type}','{$send_type}','{$t_sum}','{$f_name}','{$f_size}','{$t_cont}',DEFAULT)";

        // 문자처리
        if($send_type=="S"){
          $subject = "[트리넥트]\n";
          $re = sms_send($t_cont,$tels,$subject,$f_name,$f_type,$f_size);
          // echo "t_cont : $t_cont <br>";
          // echo "tels : $tels <br>";
          // echo "sub : $subject <br>";
          if($re->result_code > 0){
            $s_re = sql_query($s_sql);
            // 정상적으로 전송이 되었다면 아래 코드 실행
            alert("정상적으로 전송되었습니다.",$return_url);
          }else{
            alert("전송에 실패했습니다.",$return_url);
          }

        }else if($send_type=="P"){
          // 푸시처리
          if($mem_type=="P"){
            $tbl_name = "f_partner";
          }else{
            $tbl_name = "f_member";
          }
          $sql = "SELECT token FROM {$tbl_name} WHERE alarm='Y'";
          $re = sql_query($sql);
          $keys = array();
          while($row = sql_fetch_array($re)){
            if(trim($row['token'])){
              array_push($keys,$row['token']);
            }
          }
          $title = "=알림=";
          $content = $t_cont;
          $img_url = $hurl."/".$f_name;

          $p_re = send_push($keys,$title,$content,$img_url);
          $s_re = sql_query($s_sql);
          alert("정상적으로 전송되었습니다.",$return_url);

        }
      }
    }

  break;

  case "add_admin" :

    for($i=1; $i<7; $i++){
      $id_txt = "admin_id".$i;
      $name_txt = "admin_name".$i;
      $tel_txt = "admin_tel".$i;

      $sql = "SELECT * FROM f_sms_admin WHERE idx={$i}";
      $jud = sql_num_rows(sql_query($sql));

      if($jud>0){
        $sql = "UPDATE f_sms_admin SET admin_id = '{$$id_txt}', admin_name = '{$$name_txt}', admin_tel = '{$$tel_txt}'
        WHERE idx = {$i}";
      }else{
        $sql = "INSERT INTO f_sms_admin SET idx = {$i}, admin_id = '{$$id_txt}', admin_name = '{$$name_txt}', admin_tel = '{$$tel_txt}'";
      }
      $re = sql_query($sql);
    }
    alert("등록되었습니다.",$return_url);

  break;

  case "add_pic" :

    $file1 = $_FILES['pic1'];
    $f1_err = $file1['error'];
    $f1_tmp = $file1['tmp_name'];
    $f1_name = $file1['name'];

    $file2 = $_FILES['pic2'];
    $f2_err = $file2['error'];
    $f2_tmp = $file2['tmp_name'];
    $f2_name = $file2['name'];

    $utime1 = strtotime("Now");
    $utime2 = strtotime("+1 seconds");

    $img_src = G5_THEME_PATH."/img/forest/";


    if($f1_name){
      $box1 = explode('.',$f1_name);
      $f1_whak = end($box1);

      if($f1_tmp){
        $f1_name = $utime1.".".$f1_whak;
        if($f1_err != 4){
          if($f1_err == 1){
            $return_txt = "업로드에 실패했습니다.";
          }else{
            $re1 = move_uploaded_file($f1_tmp, $img_src.$f1_name);
          }
        }
      }
    }else{
      $f1_name = $pic_1;
    }

    if($f2_name){
      $box2 = explode('.',$f2_name);
      $f2_whak = end($box2);

      if($f2_tmp){
        $f2_name = $utime2.".".$f2_whak;
        if($f2_err != 4){
          if($f2_err == 1){
            $return_txt = "업로드에 실패했습니다.";
          }else{
            $re2 = move_uploaded_file($f2_tmp, $img_src.$f2_name);
          }
        }
      }

    }else{
      $f2_name = $pic_2;
    }

    if($type==2){
      $t_name = "f_member";
    }else{
      $t_name = "f_partner";
    }

    $sql = "SELECT pic1, pic2 FROM {$t_name} WHERE idx={$idx}";
    $re = sql_fetch($sql);

    $db_pic1 = $re['pic1'];
    $db_pic2 = $re['pic2'];

    $sql = "UPDATE {$t_name} SET pic1='{$f1_name}', pic2='{$f2_name}' WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      alert("정상적으로 등록되었습니다","./member_edit.php?idx={$idx}&type={$page_type}");
    }

  break;


}


?>
