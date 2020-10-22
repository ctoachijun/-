<?php
include_once('./_common.php');

switch($w_type){

  case "insert_ep" :

    $g_name=$_POST['g_name'];
    $i_tree = $_POST['i_tree'];
    $grade=$_POST['grade'];
    $g_place=$_POST['g_place'];
    $d_date=$_POST['d_date'];
    $etc=$_POST['etc'];
    $e_date=$_POST['e_date'];


    // 견적의뢰 테이블에 데이터 입력
    $e_sql = "INSERT INTO f_estimate_plz (m_idx,w_name,g_work,k_tree,to_idx,target,d_date,memo,e_date)
    VALUES(1,'{$g_name}',{$grade},{$i_tree},0,'{$g_place}','{$d_date}','{$etc}','{$e_date}')";
    $re = sql_query($e_sql);


    // 견적의뢰 idx 추출
    $idx_sql = "SELECT * FROM f_estimate_plz ORDER BY idx DESC LIMIT 0,1";
    $ire = sql_fetch_array(sql_query($idx_sql));
    $ep_idx = $ire['idx'];


    // 수목품목, 사이즈, 수량 체크, sql 칼럼명 생성
    $cnt = count($_POST['item']);
    for($i=0; $i<$cnt; $i++){
      if($_POST['item'][$i]!=""){
        $i_txt = "item".($i+1);       // 변수이름에 1부터 숫자를 붙이기위한 처리
        $$i_txt = $_POST['item'][$i];
        $sql_item .= $i_txt.",";
        $sql_ival .= "'".$$i_txt."',";

        $o_txt = "osum".($i+1);
        $$o_txt = $_POST['osum'][$i];
        $sql_osum .= $o_txt.",";
        $sql_oval .= $$o_txt.",";

        $s_txt = "size".($i+1);
        $$s_txt = "H".$_POST['size1'][$i]." X W".$_POST['size2'][$i];
        $sql_size .= $s_txt.",";
        $sql_sval .= "'".$$s_txt."',";
      }
    }


    //  발주 수목테이블에 데이터 입력
    $to_sql = "INSERT INTO f_tree_order (ep_idx,{$sql_item}{$sql_osum}{$sql_size}w_date)
    VALUES($ep_idx,{$sql_ival}{$sql_oval}{$sql_sval}DEFAULT)";
    sql_query($to_sql);

    //  발주 수목 idx 추출
    $tdx_sql = "SELECT * FROM f_tree_order ORDER BY idx DESC LIMIT 0,1";
    $tre = sql_fetch_array(sql_query($tdx_sql));
    $to_idx = $tre['idx'];

    //  견적의뢰 테이블의 발주수목 idx 데이터 입력(갱신)
    $uep_sql = "UPDATE f_estimate_plz SET to_idx={$to_idx} WHERE idx={$ep_idx}";
    sql_query($uep_sql);


    echo "전부 다 완료!";

  break;



}


 ?>
