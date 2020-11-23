<?php
if (!defined('_GNUBOARD_')) exit;

/*
// 081022 : CSRF 방지를 위해 코드를 작성했으나 효과가 없어 주석처리 함
if (!get_session('ss_admin')) {
    set_session('ss_admin', true);
    goto_url('.');
}
*/

// 스킨디렉토리를 SELECT 형식으로 얻음
function get_skin_select($skin_gubun, $id, $name, $selected='', $event='')
{
    global $config;

    $skins = array();

    if(defined('G5_THEME_PATH') && $config['cf_theme']) {
        $dirs = get_skin_dir($skin_gubun, G5_THEME_PATH.'/'.G5_SKIN_DIR);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = 'theme/'.$dir;
            }
        }
    }

    $skins = array_merge($skins, get_skin_dir($skin_gubun));

    $str = "<select id=\"$id\" name=\"$name\" $event>\n";
    for ($i=0; $i<count($skins); $i++) {
        if ($i == 0) $str .= "<option value=\"\">선택</option>";
        if(preg_match('#^theme/(.+)$#', $skins[$i], $match))
            $text = '(테마) '.$match[1];
        else
            $text = $skins[$i];

        $str .= option_selected($skins[$i], $selected, $text);
    }
    $str .= "</select>";
    return $str;
}

// 모바일 스킨디렉토리를 SELECT 형식으로 얻음
function get_mobile_skin_select($skin_gubun, $id, $name, $selected='', $event='')
{
    global $config;

    $skins = array();

    if(defined('G5_THEME_PATH') && $config['cf_theme']) {
        $dirs = get_skin_dir($skin_gubun, G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = 'theme/'.$dir;
            }
        }
    }

    $skins = array_merge($skins, get_skin_dir($skin_gubun, G5_MOBILE_PATH.'/'.G5_SKIN_DIR));

    $str = "<select id=\"$id\" name=\"$name\" $event>\n";
    for ($i=0; $i<count($skins); $i++) {
        if ($i == 0) $str .= "<option value=\"\">선택</option>";
        if(preg_match('#^theme/(.+)$#', $skins[$i], $match))
            $text = '(테마) '.$match[1];
        else
            $text = $skins[$i];

        $str .= option_selected($skins[$i], $selected, $text);
    }
    $str .= "</select>";
    return $str;
}


// 스킨경로를 얻는다
function get_skin_dir($skin, $skin_path=G5_SKIN_PATH)
{
    global $g5;

    $result_array = array();

    $dirname = $skin_path.'/'.$skin.'/';
    if(!is_dir($dirname))
        return;

    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..') continue;

        if (is_dir($dirname.$file)) $result_array[] = $file;
    }
    closedir($handle);
    sort($result_array);

    return $result_array;
}


// 테마
function get_theme_dir()
{
    $result_array = array();

    $dirname = G5_PATH.'/'.G5_THEME_DIR.'/';
    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..') continue;

        if (is_dir($dirname.$file)) {
            $theme_path = $dirname.$file;
            if(is_file($theme_path.'/index.php') && is_file($theme_path.'/head.php') && is_file($theme_path.'/tail.php'))
                $result_array[] = $file;
        }
    }
    closedir($handle);
    natsort($result_array);

    return $result_array;
}


// 테마정보
function get_theme_info($dir)
{
    $info = array();
    $path = G5_PATH.'/'.G5_THEME_DIR.'/'.$dir;

    if(is_dir($path)) {
        $screenshot = $path.'/screenshot.png';
        if(is_file($screenshot)) {
            $size = @getimagesize($screenshot);

            if($size[2] == 3)
                $screenshot_url = str_replace(G5_PATH, G5_URL, $screenshot);
        }

        $info['screenshot'] = $screenshot_url;

        $text = $path.'/readme.txt';
        if(is_file($text)) {
            $content = file($text, false);
            $content = array_map('trim', $content);

            preg_match('#^Theme Name:(.+)$#i', $content[0], $m0);
            preg_match('#^Theme URI:(.+)$#i', $content[1], $m1);
            preg_match('#^Maker:(.+)$#i', $content[2], $m2);
            preg_match('#^Maker URI:(.+)$#i', $content[3], $m3);
            preg_match('#^Version:(.+)$#i', $content[4], $m4);
            preg_match('#^Detail:(.+)$#i', $content[5], $m5);
            preg_match('#^License:(.+)$#i', $content[6], $m6);
            preg_match('#^License URI:(.+)$#i', $content[7], $m7);

            $info['theme_name'] = trim($m0[1]);
            $info['theme_uri'] = trim($m1[1]);
            $info['maker'] = trim($m2[1]);
            $info['maker_uri'] = trim($m3[1]);
            $info['version'] = trim($m4[1]);
            $info['detail'] = trim($m5[1]);
            $info['license'] = trim($m6[1]);
            $info['license_uri'] = trim($m7[1]);
        }

        if(!$info['theme_name'])
            $info['theme_name'] = $dir;
    }

    return $info;
}


// 테마설정 정보
function get_theme_config_value($dir, $key='*')
{
    $tconfig = array();

    $theme_config_file = G5_PATH.'/'.G5_THEME_DIR.'/'.$dir.'/theme.config.php';
    if(is_file($theme_config_file)) {
        include($theme_config_file);

        if($key == '*') {
            $tconfig = $theme_config;
        } else {
            $keys = array_map('trim', explode(',', $key));
            foreach($keys as $v) {
                $tconfig[$v] = trim($theme_config[$v]);
            }
        }
    }

    return $tconfig;
}


// 회원권한을 SELECT 형식으로 얻음
function get_member_level_select($name, $start_id=0, $end_id=10, $selected="", $event="")
{
    global $g5;

    $str = "\n<select id=\"{$name}\" name=\"{$name}\"";
    if ($event) $str .= " $event";
    $str .= ">\n";
    for ($i=$start_id; $i<=$end_id; $i++) {
        $str .= '<option value="'.$i.'"';
        if ($i == $selected)
            $str .= ' selected="selected"';
        $str .= ">{$i}</option>\n";
    }
    $str .= "</select>\n";
    return $str;
}


// 회원아이디를 SELECT 형식으로 얻음
function get_member_id_select($name, $level, $selected="", $event="")
{
    global $g5;

    $sql = " select mb_id from {$g5['member_table']} where mb_level >= '{$level}' ";
    $result = sql_query($sql);
    $str = '<select id="'.$name.'" name="'.$name.'" '.$event.'><option value="">선택안함</option>';
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $str .= '<option value="'.$row['mb_id'].'"';
        if ($row['mb_id'] == $selected) $str .= ' selected';
        $str .= '>'.$row['mb_id'].'</option>';
    }
    $str .= '</select>';
    return $str;
}

// 권한 검사
function auth_check($auth, $attr, $return=false)
{
    global $is_admin;

    if ($is_admin == 'super') return;

    if (!trim($auth)) {
        $msg = '이 메뉴에는 접근 권한이 없습니다.\\n\\n접근 권한은 최고관리자만 부여할 수 있습니다.';
        if($return)
            return $msg;
        else
            alert($msg);
    }

    $attr = strtolower($attr);

    if (!strstr($auth, $attr)) {
        if ($attr == 'r') {
            $msg = '읽을 권한이 없습니다.';
            if($return)
                return $msg;
            else
                alert($msg);
        } else if ($attr == 'w') {
            $msg = '입력, 추가, 생성, 수정 권한이 없습니다.';
            if($return)
                return $msg;
            else
                alert($msg);
        } else if ($attr == 'd') {
            $msg = '삭제 권한이 없습니다.';
            if($return)
                return $msg;
            else
                alert($msg);
        } else {
            $msg = '속성이 잘못 되었습니다.';
            if($return)
                return $msg;
            else
                alert($msg);
        }
    }
}


// 작업아이콘 출력
function icon($act, $link='', $target='_parent')
{
    global $g5;

    $img = array('입력'=>'insert', '추가'=>'insert', '생성'=>'insert', '수정'=>'modify', '삭제'=>'delete', '이동'=>'move', '그룹'=>'move', '보기'=>'view', '미리보기'=>'view', '복사'=>'copy');
    $icon = '<img src="'.G5_ADMIN_PATH.'/img/icon_'.$img[$act].'.gif" title="'.$act.'">';
    if ($link)
        $s = '<a href="'.$link.'">'.$icon.'</a>';
    else
        $s = $icon;
    return $s;
}


// rm -rf 옵션 : exec(), system() 함수를 사용할 수 없는 서버 또는 win32용 대체
// www.php.net 참고 : pal at degerstrom dot com
function rm_rf($file)
{
    if (file_exists($file)) {
        if (is_dir($file)) {
            $handle = opendir($file);
            while($filename = readdir($handle)) {
                if ($filename != '.' && $filename != '..')
                    rm_rf($file.'/'.$filename);
            }
            closedir($handle);

            @chmod($file, G5_DIR_PERMISSION);
            @rmdir($file);
        } else {
            @chmod($file, G5_FILE_PERMISSION);
            @unlink($file);
        }
    }
}

// 입력 폼 안내문
function help($help="")
{
    global $g5;

    $str  = '<span class="frm_info">'.str_replace("\n", "<br>", $help).'</span>';

    return $str;
}

// 출력순서
function order_select($fld, $sel='')
{
    $s = '<select name="'.$fld.'" id="'.$fld.'">';
    for ($i=1; $i<=100; $i++) {
        $s .= '<option value="'.$i.'" ';
        if ($sel) {
            if ($i == $sel) {
                $s .= 'selected';
            }
        } else {
            if ($i == 50) {
                $s .= 'selected';
            }
        }
        $s .= '>'.$i.'</option>';
    }
    $s .= '</select>';

    return $s;
}

// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function get_admin_token()
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_admin_token', $token);

    return $token;
}

// 관리자가 자동등록방지를 사용해야 할 경우
function get_admin_captcha_by($type='get'){

    $captcha_name = 'ss_admin_use_captcha';

    if($type === 'remove'){
        set_session($captcha_name, '');
    }

    return get_session($captcha_name);
}

//input value 에서 xss 공격 filter 역할을 함 ( 반드시 input value='' 타입에만 사용할것 )
function get_sanitize_input($s, $is_html=false){

    if(!$is_html){
        $s = strip_tags($s);
    }

    $s = htmlspecialchars($s, ENT_QUOTES, 'utf-8');

    return $s;
}

function check_log_folder($log_path, $is_delete=true){

    if( is_writable($log_path) ){

        // 아파치 서버인 경우 웹에서 해당 폴더 접근 막기
        $htaccess_file = $log_path.'/.htaccess';
        if ( !file_exists( $htaccess_file ) ) {
            if ( $handle = @fopen( $htaccess_file, 'w' ) ) {
                fwrite( $handle, 'Order deny,allow' . "\n" );
                fwrite( $handle, 'Deny from all' . "\n" );
                fclose( $handle );
            }
        }

        // 아파치 서버인 경우 해당 디렉토리 파일 목록 안보이게 하기
        $index_file = $log_path . '/index.php';
        if ( !file_exists( $index_file ) ) {
            if ( $handle = @fopen( $index_file, 'w' ) ) {
                fwrite( $handle, '' );
                fclose( $handle );
            }
        }
    }

	if( $is_delete ) {
		try {
			// txt 파일과 log 파일을 조회하여 30일이 지난 파일은 삭제합니다.
			$txt_files = glob($log_path.'/*.txt');
			$log_files = glob($log_path.'/*.log');

			$del_files = array_merge($txt_files, $log_files);

			if( $del_files && is_array($del_files) ){
				foreach ($del_files as $del_file) {
					$filetime = filemtime($del_file);
					// 30일이 지난 파일을 삭제
					if($filetime && $filetime < (G5_SERVER_TIME - 2592000)) {
						@unlink($del_file);
					}
				}
			}
		} catch(Exception $e) {
		}
	}
}

// POST로 넘어온 토큰과 세션에 저장된 토큰 비교
function check_admin_token()
{
    $token = get_session('ss_admin_token');
    set_session('ss_admin_token', '');

    if(!$token || !$_REQUEST['token'] || $token != $_REQUEST['token'])
        alert('올바른 방법으로 이용해 주십시오.', G5_URL);

    return true;
}

// 관리자 페이지 referer 체크
function admin_referer_check($return=false)
{
    $referer = trim($_SERVER['HTTP_REFERER']);
    if(!$referer) {
        $msg = '정보가 올바르지 않습니다.';

        if($return)
            return $msg;
        else
            alert($msg, G5_URL);
    }

    $p = @parse_url($referer);

    $host = preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']);
    $msg = '';

    if($host != $p['host']) {
        $msg = '올바른 방법으로 이용해 주십시오.';
    }

    if( $p['path'] && ! preg_match( '/\/'.preg_quote(G5_ADMIN_DIR).'\//i', $p['path'] ) ){
        $msg = '올바른 방법으로 이용해 주십시오';
    }

    if( $msg ){
        if($return) {
            return $msg;
        } else {
            alert($msg, G5_URL);
        }
    }
}

function admin_check_xss_params($params){

    if( ! $params ) return;

    foreach( $params as $key=>$value ){

        if ( empty($value) ) continue;

        if( is_array($value) ){
            admin_check_xss_params($value);
        } else if ( (preg_match('/<\s?[^\>]*\/?\s?>/i', $value) && (preg_match('/script.*?\/script/ius', $value) || preg_match('/[onload|onerror]=.*/ius', $value))) || preg_match('/^(?=.*token\()(?=.*xmlhttprequest\()(?=.*send\().*$/im', $value) || (preg_match('/[onload|onerror|focus]=.*/ius', $value) && preg_match('/(eval|expression|exec|prompt)(\s*)\((.*)\)/ius', $value)) ){
            alert('요청 쿼리에 잘못된 스크립트문장이 있습니다.\\nXSS 공격일수도 있습니다.', G5_URL);
            die();
        }
    }

    return;
}

function admin_menu_find_by($call, $search_key){
    global $menu;

    static $cache_menu = array();

    if( empty($cache_menu) ){
        foreach( $menu as $k1=>$arr1 ){

            if (empty($arr1) ) continue;
            foreach( $arr1 as $k2=>$arr2 ){
                if (empty($arr2) ) continue;

                $menu_key = isset($arr2[3]) ? $arr2[3] : '';
                if (empty($menu_key) ) continue;

                $cache_menu[$menu_key] = array(
                    'sub_menu'=>$arr2[0],
                    'title'=>$arr2[1],
                    'link'=>$arr2[2],
                    );
            }
        }
    }

    if( isset($cache_menu[$call]) && isset($cache_menu[$call][$search_key]) ){
        return$cache_menu[$call][$search_key];
    }

    return '';
}

// 접근 권한 검사
if (!$member['mb_id'])
{
    alert('로그인 하십시오.', G5_BBS_URL.'/login.php?url=' . urlencode(correct_goto_url(G5_ADMIN_URL)));
}
else if ($is_admin != 'super')
{
    $auth = array();
    $sql = " select au_menu, au_auth from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' ";
    $result = sql_query($sql);
    for($i=0; $row=sql_fetch_array($result); $i++)
    {
        $auth[$row['au_menu']] = $row['au_auth'];
    }

    if (!$i)
    {
        alert('최고관리자 또는 관리권한이 있는 회원만 접근 가능합니다.', G5_URL);
    }
}

// 관리자의 아이피, 브라우저와 다르다면 세션을 끊고 관리자에게 메일을 보낸다.
$admin_key = md5($member['mb_datetime'] . get_real_client_ip() . $_SERVER['HTTP_USER_AGENT']);
if (get_session('ss_mb_key') !== $admin_key) {

    session_destroy();

    include_once(G5_LIB_PATH.'/mailer.lib.php');
    // 메일 알림
    mailer($member['mb_nick'], $member['mb_email'], $member['mb_email'], 'XSS 공격 알림', $_SERVER['REMOTE_ADDR'].' 아이피로 XSS 공격이 있었습니다.<br><br>관리자 권한을 탈취하려는 접근이므로 주의하시기 바랍니다.<br><br>해당 아이피는 차단하시고 의심되는 게시물이 있는지 확인하시기 바랍니다.'.G5_URL, 0);

    alert_close('정상적으로 로그인하여 접근하시기 바랍니다.');
}

@ksort($auth);

// 가변 메뉴
unset($auth_menu);
unset($menu);
unset($amenu);
$tmp = dir(G5_ADMIN_PATH);
$menu_files = array();
while ($entry = $tmp->read()) {
    if (!preg_match('/^admin.menu([0-9]{3}).*\.php$/', $entry, $m))
        continue;  // 파일명이 menu 으로 시작하지 않으면 무시한다.

    $amenu[$m[1]] = $entry;
    $menu_files[] = G5_ADMIN_PATH.'/'.$entry;
}
@asort($menu_files);
foreach($menu_files as $file){
    include_once($file);
}
@ksort($amenu);

$amenu = run_replace('admin_amenu', $amenu);
if( isset($menu) && $menu ){
    $menu = run_replace('admin_menu', $menu);
}

$arr_query = array();
if (isset($sst))  $arr_query[] = 'sst='.$sst;
if (isset($sod))  $arr_query[] = 'sod='.$sod;
if (isset($sfl))  $arr_query[] = 'sfl='.$sfl;
if (isset($stx))  $arr_query[] = 'stx='.$stx;
if (isset($page)) $arr_query[] = 'page='.$page;
$qstr = implode("&amp;", $arr_query);

if ( isset($_REQUEST) && $_REQUEST ){
    if( admin_referer_check(true) ){
        admin_check_xss_params($_REQUEST);
    }
}

// 관리자에서는 추가 스크립트는 사용하지 않는다.
//$config['cf_add_script'] = '';


// 여기서부터가 추가 코드
function print_admin_menu(){
  $menu_name = array("매출현황","입금현황","회원관리","알림전송","통계","홈페이지관리","문자");

  for($i=1; $i<=count($menu_name); $i++){
    if($i==1){
      $menu_name[$i][0]="입금현황";
    }else if($i==2){
      $menu_name[$i][0]="전체 회원 리스트";
    }else if($i==3){
      $menu_name[$i][0]="알림전송";
      $menu_name[$i][1]="공지업데이트";
    }else if($i==4){
      $menu_name[$i][0]="품목별 거래량 및 평균단가 ";
      $menu_name[$i][1]="가입자 현황";
    }else if($i==5){
      $menu_name[$i][0]="";
    }
    // print_r($menu_name);
    // echo "<button type='button' class='btn_op_menu' onclick='admin_menu_oc({$i})'>".$menu_name[$i]."</button>";
    echo "<ul><li>".$menu_name[$i]."</li></ul>";
    echo "<ul class='menu{$i}'>";
    if(count($menu_name[$i])>1){
      echo "<li>".$menu_name[$i][0]."</li>";
      echo "<li>".$menu_name[$i][1]."</li>";
    }else{
      echo "<li>".$menu_name[$i]."</li>";
    }
    echo "</ul>";
  }
}

//  입금현황 리스트
function list_depo($page,$list,$l_cnt){
  $start_num = ($page-1) * $list;
  $col_add = "d.e_idx as e_idx, d.idx as d_idx, m.c_name as mc, p.c_name as pc, m.m_tel as mt, p.m_tel as pt";

  $d_sql = "SELECT *,{$col_add} FROM f_deposit AS d JOIN f_member AS m ON d.m_idx=m.idx
  JOIN f_partner AS p ON d.p_idx=p.idx WHERE d.cancel='N' ORDER BY d.idx DESC LIMIT $start_num,$list";
  $d_rs = sql_query($d_sql);

  while($row = sql_fetch_array($d_rs)){
    $e_idx = $row['e_idx'];
    $d_idx = $row['d_idx'];
    $m_idx = $row['m_idx'];
    $p_idx = $row['p_idx'];
    $o_idx = $row['o_idx'];
    $m_depo = $row['m_deposit'];
    $p_depo = $row['p_deposit'];
    $pc_date = $row['m_push_date'];

    $sql = "SELECT cancel_esti FROM f_estimate WHERE idx={$e_idx}";
    $ebox = sql_fetch($sql);
    $cancel_esti = $ebox['cancel_esti'];

    if($cancel_esti=='N'){

      // 결제금액
      $m_price = $row['m_price'];
      $p_price = $row['p_price'];

      //고객 정보
      $m_name = $row['mc'];
      $p_name = $row['pc'];
      $m_tel = $row['mt'];
      $p_tel = $row['pt'];

      // 고객, 파트너의 주문상태
      if($row['m_deposit']==1){
        $m_depo_txt = "결제 완료";
      }else{
        $m_depo_txt = "결제 대기";
      }

      if($row['p_deposit']==1){
        $p_depo_txt = "입금 완료";
      }else{
        $p_depo_txt = "입금 대기";
      }

      // 날짜 표시용으로 가공
      $box = explode(" ",$pc_date);
      $date1 = $box[0];
      $box2 = explode(":",$box[1]);
      $date2 = $box2[0].":".$box2[1];

      // 견적의뢰 테이블에서 공사명 추출
      $e_sql = "SELECT * FROM f_estimate_plz WHERE o_idx={$o_idx}";
      $e_rs = sql_fetch($e_sql);
      $g_name = $e_rs['w_name'];
      $to_idx = $e_rs['to_idx'];

      // 요청일자부터 몇시간이 지났는지 계산
      $now = date("Y-m-d H:i:s");
      $re = strtotime($now) - strtotime($pc_date);
      $c_h = ceil($re / (60*60));

      $chk_d = 0;
      if($c_h > 24){
        while($c_h > 24){
          $chk_d++;
          $c_h -= 24;
          $chk_h = $c_h;
        }
      }else{
        $chk_h = $c_h;
      }
      $c_date_txt = "+".$chk_d."일".$chk_h."시간";

      echo "<input type='hidden' name='m_depo{$d_idx}' value={$m_depo} />";
      echo "<input type='hidden' name='p_depo{$d_idx}' value={$p_depo} />";
      echo "<input type='hidden' name='to_idx{$d_idx}' value={$to_idx} />";
      echo "<tr>";
      echo "<td class='depo_cont_l'>".$m_depo_txt."</td>";
      echo "<td class='depo_cont_l'>".$p_depo_txt."</td>";
      echo "<td class='depo_cont_l'>".$g_name."</td>";
      echo "<td class='depo_cont_l'>".$p_name."</td>";
      echo "<td class='depo_cont_l'>".$m_name."</td>";
      echo "<td class='depo_cont_l'>".$p_tel."</td>";
      echo "<td class='depo_cont_l'>".$m_tel."</td>";
      echo "<td class='depo_cont_l'>".$date1." | ".$date2."</td>";
      echo "<td class='depo_cont_l'>".$c_date_txt."</td>";
      echo "<td class='depo_price_l'><div class='attend'><div class='mp'>".number_format($m_price)."</div><div onclick='pay_confirm(1,{$d_idx})' class='g".$row['m_deposit']."'>".$m_depo_txt."</div></div></td>";
      echo "<td class='depo_price_l'><div class='attend'><div class='pp'>".number_format($p_price)."</div><div onclick='pay_confirm(2,{$d_idx})' class='i".$row['p_deposit']."'>".$p_depo_txt."</div></div</td>";
      echo "<tr><td class='b_line' colspan='13'><div id='bottom_line'></div></td></tr>";
      echo "</tr>";
    }
  }
}

function list_mem($s_key,$type){
  // $start_num = ($page-1) * $list;

  if($type=="com"){
    $table_name = "f_partner";
    $search_col = "c_";
    $v_type = 1;
  }else if($type=="mem"){
    $table_name = "f_member";
    $search_col = "m_";
    $v_type = 2;
  }
  if($s_key){
    $where = "{$search_col}name like '%{$s_key}%' ";
  }else{
    $where = 1;
  }
  $p_sql = "SELECT * FROM {$table_name} WHERE {$where} AND live='Y' ORDER BY idx DESC ";
  $p_rs = sql_query($p_sql);
  $mcnt = sql_num_rows($p_rs);

  $col_name_txt = $search_col."name";


  // 상세페이지로 넘길 데이터 설정
  echo "<input type='hidden' name='page_type' value='{$v_type}'/>";


  if(!$p_rs){
    echo "<tr>";
    echo "<td class='no_search' colspan='6'>찾으시는 결과가 없습니다</td>";
    echo "</tr>";
  }else{

    while($row=sql_fetch_array($p_rs)){
      $addr1 = explode(" ",$row['addr1']);
      $date = explode(" ",$row['join_date']);
      $col_name = $row[$col_name_txt];
      $app = $row['approval'];

      if($app == "N"){
        $no_app = "no_app";
      }else{
        $no_app = "";
      }

      // 베스트농원 글자색 변화
      if($type=="com"){
        $ps = $row['partner_ship'];
        if($ps==3){
          $col_name = "<span class='yt'>".$col_name."</span>";
        }
      }


      echo "<input type='hidden' name='idx' />";
      echo "<tr class='{$no_app}'>";
      echo "<td class='mem_p_cont'>".$mcnt."</td>";
      echo "<td class='mem_p_cont'>".$col_name."</td>";
      echo "<td class='mem_p_cont'>".$row[$search_col.'tel']."</td>";
      echo "<td class='mem_p_cont'>".$addr1[0]."</td>";
      echo "<td class='mem_p_cont'>".$date[0]."</td>";
      echo "<td class='mem_p_cont'><button type='button' class='detail_btn' onclick='view_detail(".$row['idx'].",{$v_type})'>상세보기</button></td>";
      echo "<tr><td class='b_line' colspan='6'><div id='bottom_line'></div></td></tr>";
      echo "</tr>";
      $mcnt--;
    }

  }
}

function partner_detail($idx,$type){

  if($type==1){
    $idx_name = "p_idx";
    $t_name = "f_partner";
  }else{
    $idx_name = "m_idx";
    $t_name = "f_member";
  }

  $sql = "SELECT * FROM {$t_name} WHERE idx={$idx}";
  $rs = sql_fetch($sql);

  if($type==1){
    $ps_jud = $rs['partner_ship'];
    if($ps_jud==1){
      $partner_ship_txt = "일반 농원";
    }else if($ps_jud==2){
      $partner_ship_txt = "베스트 농원";
    }else if($ps_jud==3){
      $partner_ship_txt = "공식파트너 농원";
    }
  }
  echo "<tr>";
  echo "<td class='column'>이름</td>";
  echo "<td class='cont'>".$rs['m_name']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>직급</td>";
  echo "<td class='cont'>".$rs['position']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>업체명</td>";
  echo "<td class='cont'>".$rs['c_name']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>주소</td>";
  echo "<td class='cont'>".$rs['addr1'].$rs['addr2']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>휴대전화번호</td>";
  echo "<td class='cont'>".$rs['m_tel']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>사업장전화번호</td>";
  echo "<td class='cont'>".$rs['c_tel']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>계좌은행</td>";
  echo "<td class='cont'>".$rs['bank_name']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='column'>계좌번호</td>";
  echo "<td class='cont'>".$rs['bank_num']."</td>";
  echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
  echo "</tr>";

  if($type==1){
    echo "<tr>";
    echo "<td class='column'>농원등급</td>";
    echo "<td class='cont'>{$partner_ship_txt}</td>";
    echo "<tr><td class='b_line' colspan='2'><div class='bottom_lines'></div></td></tr>";
    echo "</tr>";
  }
}

function view_depo($idx,$type,$c_name){
  if($type==1){
    $idx_name = "p_idx";
    $col_name = "p_";
    $p_name = "t_price";
  }else{
    $idx_name = "m_idx";
    $col_name = "m_";
    $p_name = "total_p";
  }

  // 거래 완료건수
  $sql = "SELECT * FROM f_order WHERE {$idx_name}={$idx}";
  $re = sql_query($sql);
  $cnt = sql_num_rows($re);

  // $sql = "SELECT d.{$col_name}price, d.{$col_name}deposit,e.ep_idx,e.d_date FROM f_deposit as d JOIN f_estimate as e ON d.e_idx=e.idx WHERE d.{$idx_name} = {$idx}";
  // $rs = sql_query($sql);
  // $cnt = sql_num_rows($rs);
  // echo $sql."<br>";

  if($cnt==0){
    echo "<tr>";
    echo "<td colspan='6' class='no_data'>거래 내역이 없습니다.</td>";
    echo "</tr>";
  }else{
    while($row = sql_fetch_array($re)){
      $o_idx = $row['idx'];
      $e_idx = $row['e_idx'];
      $to_idx = $row['to_idx'];
      $sql = "SELECT ep_idx,t_price FROM f_estimate WHERE idx={$e_idx}";
      $ebox = sql_fetch($sql);
      $ep_idx = $ebox['ep_idx'];
      $t_price = $ebox['t_price'];

      // // 수수로 20% 계산
      // $tep  = $t_price*0.2;
      // $total_p = $t_price + $tep;

      $sql = "SELECT w_name,d_date FROM f_estimate_plz WHERE idx={$ep_idx}";
      $epbox = sql_fetch($sql);
      $w_name = $epbox['w_name'];
      $d_date = $epbox['d_date'];

      $sql = "SELECT * FROM f_deposit WHERE o_idx={$o_idx}";
      $dbox = sql_fetch($sql);
      $jud = $dbox[$col_name."deposit"];

      if($jud==1){
        $class_name = "ok";
        if($type==1){
          $depo_txt = "입금완료";
        }else{
          $depo_txt = "결제완료";
        }
      }else{
        $class_name = "no";
        if($type==1){
          $depo_txt = "입금대기";
        }else{
          $depo_txt = "결제대기";
        }
      }
      echo "<tr>";
      echo "<td>{$cnt}</td>";
      echo "<td>".$c_name."</td>";
      echo "<td>{$w_name}</td>";
      echo "<td>".number_format($$p_name)."</td>";
      echo "<td>".$d_date."</td>";
      echo "<td class='chk_depo'><button type='button' class='detail_btn{$class_name}'>{$depo_txt}</button></td>";
      echo "<tr><td class='b_line' colspan='6'><div id='bottom_line'></div></td></tr>";
      echo "</tr>";
      $cnt--;
    }
  }
}

function star_score($idx){
  $st_sql = "SELECT sum(point) as t FROM f_partner_ship WHERE p_idx = {$idx}";
  $box = sql_fetch_array(sql_query($st_sql));

  $t_sql = "SELECT * FROM f_partner_ship WHERE p_idx = {$idx}";
  $cnt = sql_num_rows(sql_query($t_sql));

  $score = $box['t'] / $cnt;
  if(!$cnt) $score=0;

  return $score;
}

function get_Partnername($idx,$type){

  if($type==1){
      $t_name = "f_partner";
      $col_name = "c_";
  }else{
      $t_name = "f_member";
      $col_name = "m_";
  }

  $n_sql = "SELECT * FROM {$t_name} WHERE idx = {$idx}";
  $box = sql_fetch_array(sql_query($n_sql));

  return $box[$col_name.'name'];
}



function newbi($opt){
  $ym = date("Y-m") ;
  if($opt==1){
    $table = "f_partner";
  }else if($opt==2){
    $table = "f_member";
  }
  $where = "WHERE join_date like '{$ym}%'";
  $n_sql = "SELECT * FROM {$table} {$where}";
  $newbi_cnt = sql_num_rows(sql_query($n_sql));

  return $newbi_cnt;

}



function paging($page,$list,$l_cnt){
  $block_ct = 10;

  $block_num = ceil($page/$block_ct);
  $block_start = (($block_num -1) * $block_ct) + 1;
  $block_end = $block_start + $block_ct -1;

  $total_page = ceil($l_cnt / $list);
  if($block_end > $total_page){
    $block_end = $total_page;
  }
  $total_block = ceil($total_page / $block_ct);
  $start_num = ($page-1) * $list;

  $p_sql = "SELECT * FROM f_deposit
  ORDER BY idx DESC
  LIMIT {$start_num}, {$list}";
  $p_rs = sql_query($p_sql);


  if($page <= 1){
    echo "<li class='fo_re'>처음</li>";
  }else{
    echo "<li><a href='?page=1'>처음</a></li>";
  }
  if($page <= 1){

  }else{
    $pre = $page-1;
    echo "<li><a href='?page=$pre'>이전</a></li>";
  }

  for($i=$block_start; $i<=$block_end; $i++){
    if($page == $i){
      echo "<li class='fo_re'>[$i]</li>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
    }else{
      echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 $i
    }
  }
  if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
  }else{
    $next = $page + 1; //next변수에 page + 1을 해준다.
    echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
  }
  if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
    echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
  }else{
    echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
  }

}

function view_sn_history(){
  $sql = "SELECT * FROM f_sms_push ORDER BY idx DESC LIMIT 0,3";
  $re = sql_query($sql);

  while($row = sql_fetch_array($re)){
      if($row['target']=="P"){
        $target = "농원";
      }else if($row['target']=="M"){
        $target = "고객";
      }

      if($row['type']=="P"){
        $type = "푸시";
      }else if($row['type']=="S"){
        $type = "문자";
      }



      $cont_txt = $row['content'];
      if($cont_txt){
        $cont_txt .= "<br><br>";
      }
      if($row['size'] > 0){
        $cont_txt .= "<a href='./img/forest_adm/".$row['img']."'><img class='his_img' src='./img/forest_adm/".$row['img']."' /></a>";
      }
      $d_box = explode(" ",$row['send_date']);

      echo "<div class='view_history'>";
      echo "<table>";
      echo "<tr><td colspan='2' class='his_date'>".$d_box[0]."</td></tr>";
      echo "<tr><td class='head_td'>회원 구분</td><td class='cont_td'>{$target}({$type})</td></tr>";
      echo "<tr><td class='head_td'>받는 사람</td><td class='cont_td'>".$row['t_idx']."</td></tr>";
      echo "<tr><td class='head_td'>알림 내용</td><td class='cont_td'>{$cont_txt}</td></tr>";
      echo "</table>";
      echo "</div>";
  }

}

function view_no_history(){
  $sql = "SELECT * FROM f_notice ORDER BY idx DESC LIMIT 0,3";
  $re = sql_query($sql);

  while($row = sql_fetch_array($re)){
      if($row['target']=="P"){
        $target = "농원";
      }else if($row['target']=="M"){
        $target = "고객";
      }

      $cont_txt = $row['content'];

      if($row['size'] > 0){
        $cont_txt .= "<br><br>";
        $cont_txt .= "<a href='./img/forest_adm/".$row['img']."'><img class='his_img' src='./img/forest_adm/".$row['img']."' /></a>";
      }

      $d_box = explode(" ",$row['w_date']);

      echo "<div class='view_history'>";
      echo "<table>";
      echo "<tr><td colspan='2' class='his_date'>".$d_box[0]."</td></tr>";
      echo "<tr><td class='head_td'>회원 구분</td><td class='cont_td'>{$target}</td></tr>";
      echo "<tr><td class='head_td'>받는 사람</td><td class='cont_td'>".$row['t_idx']."</td></tr>";
      echo "<tr><td class='head_td'>알림 내용</td><td class='cont_td'>{$cont_txt}</td></tr>";
      echo "</table>";
      echo "</div>";
  }
}


function getWeekData($item){

  $today = date("Y-m-d");

  //이번주 일~토
  $yoday = date("w",strtotime($today));
  $start_yodate_1 = date("Y-m-d", strtotime($today." -".$yoday."days"));
  $end_yodate_1 = date("Y-m-d", strtotime($start_yodate_1." +6days"));

  /// 1주전 일~토
  $before_week = date("Y-m-d",strtotime($today." -7days"));
  $yoday = date("w",strtotime($before_week));
  $start_yodate_2 = date("Y-m-d", strtotime($before_week." -".$yoday."days"));
  $end_yodate_2 = date("Y-m-d", strtotime($start_yodate_2." +6days"));

  // 2주전 일~토
  $before_week = date("Y-m-d",strtotime($before_week." -7days"));
  $yoday = date("w",strtotime($before_week));
  $start_yodate_3 = date("Y-m-d", strtotime($before_week." -".$yoday."days"));
  $end_yodate_3 = date("Y-m-d", strtotime($start_yodate_3." +6days"));

  // 3주전 일~토
  $before_week = date("Y-m-d",strtotime($before_week." -7days"));
  $yoday = date("w",strtotime($before_week));
  $start_yodate_4 = date("Y-m-d", strtotime($before_week." -".$yoday."days"));
  $end_yodate_4 = date("Y-m-d", strtotime($start_yodate_4." +6days"));


  // 검색어가 있을경우 칼럼명 1~8까지 전부 검색하도록 search문 작성
  if($item){
    for($i=1; $i<=8; $i++){
      if($i==8){
          $search_col .= "item".$i." LIKE '%{$item}%'";
      }else{
        $search_col .= "item".$i." LIKE '%{$item}%' || ";
      }
    }



    // 주차별로 검색 기간 where문 생성
    $where1 = "&& w_date BETWEEN '{$start_yodate_1}' and '{$end_yodate_1}' && ";
    $where2 = "&& w_date BETWEEN '{$start_yodate_2}' and '{$end_yodate_2}' && ";
    $where3 = "&& w_date BETWEEN '{$start_yodate_3}' and '{$end_yodate_3}' && ";
    $where4 = "&& w_date BETWEEN '{$start_yodate_4}' and '{$end_yodate_4}' && ";


    $total_sum1 = 0;
    $total_sum2 = 0;
    $total_sum3 = 0;
    $total_sum4 = 0;


    for($d=1; $d<5; $d++){
      $dcol = "where".$d;
      $tsum = "total_sum".$d;
      $s_name = "s_name".$d;
      $s_sum = "s_sum".$d;
      $to_idx = "to_idx".$d;
      $to_idx_num = "to_idx_num".$d;

      // 검색대상 주문 수량 산출
      $sn_sql = "SELECT * FROM f_tree_order WHERE order_sn='Y' {$$dcol} ({$search_col})";
      $sn_re =sql_query($sn_sql);
      // echo $sn_sql;
      // echo "<br>";

      $cnt=0;
      $val_txt = " ";
      while($row = sql_fetch_array($sn_re)){
        for($i=1; $i<=8; $i++){
          // 값이 있을시 하나의 문자열로 만들어 배열에 대입.
          if($row['item'.$i]){
            // echo "i : ".$i."<br>";
            // echo "item : ".$row['item'.$i]."<br>";
            // echo "sum : ".$row['osum'.$i]."<br>";
            $$s_name[$cnt] .= $row['item'.$i];
            $$s_name[$cnt] .= "|";
            $$s_sum[$cnt] .= $row['osum'.$i];
            $$s_sum[$cnt] .= "|";
            $$to_idx[$cnt] = $row['idx'];
          }
        }
        $cnt++;
      }
      // echo "name : ".$to_idx."<br>";
      // print_r($$to_idx);
      // echo "<br>";

      // echo "s_name : ".$s_name."<br>";
      // print_r($$s_name);
      // echo "<br>";
      // echo "s_sum : ".$s_sum."<br>";
      // print_r($$s_sum);
      // echo "<br>";
      // echo "tsum : ".$tsum."<br>";
      // print_r($$tsum);
      // echo "<br>";
        // 검색 된 데이터중에서 itme1~8까지 데이터가 검색값을 포함하면 추출
        $a_cnt = count($$s_name);
        $to_cnt = count($$to_idx);
        for($i=0; $i<$a_cnt; $i++){
          $box = explode("|",$$s_name[$i]);
          $box2 = explode("|",$$s_sum[$i]);

          $in_num = 0;
          for($a=0; $a<count($box); $a++){
            $pattern = "/{$item}/i";
            if(preg_match($pattern,$box[$a],$re)){

                $$tsum += $box2[$a];
                $tree_name = $box[$a];
                $$to_idx_num[$i] = $a;
                // echo "bin_num : ".$in_num."<br>";
                // echo "cnt : ".count($box)."<br>";
                // echo "a : ".$a."<br>";
                // echo "box : ".$box[$a]."<br>";
                // echo "num : ".$$to_idx_num[$in_num]."<br>";
                // echo "<br>";
                $in_num++;

                // $val_txt .= $a."|";
                // $$to_idx_num[0] = $val_txt;
                // echo "val_txt : "."<br>";
                // echo "to_idx_num : ".$to_idx_num."<br>";
                // print_r($$to_idx_num);
                // echo "<br>";
                // echo "<br>";
            }
          }
          // echo "tsum : ".$tsum."<br>";
          // print_r($$tsum);
          // echo "<br>";
          // echo "<br>=====================<br>";


      }
      // echo "=====================";
      // echo "<br>";
      // echo "<br>";




    }   // end of for
  }   // end of if

//  echo "================<br><br>";
  $result[0] = array("{$total_sum1}","{$total_sum2}","{$total_sum3}","{$total_sum4}");


  // 검색한 품목 평균 단가 산출
  $cnt = 0;
  for($i=1; $i<=4; $i++){
    $to_idx = "to_idx".$i;
    $to_idx_num = "to_idx_num".$i;
    // echo "name : ".$to_idx."<br>";
    // print_r($$to_idx);
    // echo "<br>";
    // echo "num : ".$to_idx_num."<br>";
    // print_r($$to_idx_num);
    // echo "<br>";


    $ibox = "to_idx".$i;
    $inbox = "to_idx_num".$i;
    // echo "ibox : ".$ibox."<br>";
    // echo "cnt_arr : ".count($$ibox)."<br>";
    $price_sum = 0;
    $avg_price = 0;
    for($a=0; $a<count($$ibox); $a++){
      $idx = $$ibox[$a];
      $pbox = "price".($$inbox[$a]+1);
      // echo "cnt : ".count($$ibox)."<br>";
      // echo "a : ".$a."<br>";
      // echo "idx : ".$idx."<br>";
      // echo "inbox : ";
      // print_r($$inbox);
      // echo "<br>";
      // echo "pbox : ".$pbox."<br>";
      // echo "<br>";

      $sql = "SELECT e_idx FROM f_order WHERE to_idx = {$idx}";
      $re = sql_fetch_array(sql_query($sql));
      $e_idx = $re['e_idx'];

      $sql = "SELECT {$pbox} FROM f_estimate WHERE idx = {$e_idx}";
      $re = sql_fetch_array(sql_query($sql));
      $price_sum += $re[$pbox];

      $cnt++;
      // echo $sql;
      // echo "<br>";
      // echo "pbox : ".$pbox."<br>";
      // echo "price : ".$re[$pbox]."<br>";
      // echo "price_sum : ".$price_sum."<br>";
      // echo "pbox : ".$pbox."<br>";
      // echo "cnt : ".$cnt."<br>";
      // echo "price : ".$re[$pbox]."<br><br>";
      if($a==count($$ibox)-1){
          $avg_price = $price_sum / $cnt;
          $price_sum = 0;
          $cnt = 0;
      }
    }
      // echo "avg : ".$avg_price."<br>";
      // echo "<br>======================";
      // echo "<br>";

      if($i==4){
          $arr_avg_txt[0] .= $avg_price;
      }else{
        $arr_avg_txt[0] .= $avg_price."|";
      }
  }
  // print_r($arr_avg_txt);
  // echo "<br>======================";
  // echo "<br>";



  $box = explode("|",$arr_avg_txt[0]);
  $result[1] = $box;
  $result[2] = $tree_name;

  return $result;

}


function getNewbiData(){
  $today = date("Y-m-d");

  //이번주 일~토
  $yoday = date("w",strtotime($today));
  $start_yodate_1 = date("Y-m-d", strtotime($today." -".$yoday."days"));
  $end_yodate_1 = date("Y-m-d", strtotime($start_yodate_1." +6days"));

  /// 1주전 일~토
  $before_week = date("Y-m-d",strtotime($today." -7days"));
  $yoday = date("w",strtotime($before_week));
  $start_yodate_2 = date("Y-m-d", strtotime($before_week." -".$yoday."days"));
  $end_yodate_2 = date("Y-m-d", strtotime($start_yodate_2." +6days"));

  // 2주전 일~토
  $before_week = date("Y-m-d",strtotime($before_week." -7days"));
  $yoday = date("w",strtotime($before_week));
  $start_yodate_3 = date("Y-m-d", strtotime($before_week." -".$yoday."days"));
  $end_yodate_3 = date("Y-m-d", strtotime($start_yodate_3." +6days"));

  // 3주전 일~토
  $before_week = date("Y-m-d",strtotime($before_week." -7days"));
  $yoday = date("w",strtotime($before_week));
  $start_yodate_4 = date("Y-m-d", strtotime($before_week." -".$yoday."days"));
  $end_yodate_4 = date("Y-m-d", strtotime($start_yodate_4." +6days"));

  // 주차별로 검색 기간 where문 생성
  $where1 = "join_date BETWEEN '{$start_yodate_1}' and '{$end_yodate_1}' ";
  $where2 = "join_date BETWEEN '{$start_yodate_2}' and '{$end_yodate_2}' ";
  $where3 = "join_date BETWEEN '{$start_yodate_3}' and '{$end_yodate_3}' ";
  $where4 = "join_date BETWEEN '{$start_yodate_4}' and '{$end_yodate_4}' ";

  for($i=1; $i<5; $i++){
    $w_name = "where".$i;

    // 오늘부터 3주전까지 가입자수 산출
    $psql = "SELECT idx as total FROM f_partner WHERE {$$w_name}";
    $pre = sql_num_rows(sql_query($psql));
    $pbox[$i] = $pre;


    //  오늘부터 3주전까지 가입자수 산출
    $msql = "SELECT idx as total FROM f_member WHERE {$$w_name}";
    $mre = sql_num_rows(sql_query($msql));
    $mbox[$i] = $mre;
  }

  $return_box[0] = $pbox;
  $return_box[1] = $mbox;

  return $return_box;

}


function print_menu($type){
  if($type=="ld"){
    $tbl_name = "f_late_delivery";
    $head_txt = "배송지연 사유";
  }else if($type=="cb"){
    $tbl_name = "f_cancel_bidding";
    $head_txt = "입찰취소 사유";
  }

  $sql = "SELECT * FROM {$tbl_name}";
  $re = sql_fetch_array(sql_query($sql));

  echo "<table class='{$type}'>";
  echo "<tr>";
  echo "<td colspan='2' class='title'>{$head_txt}</td>";
  echo "</tr>";

  for($i=1; $i<9; $i++){
    $col_name = "menu".$i;
    $value = $re[$col_name];
    if(!$value){
      $no_value = "없음";
    }
    echo "<tr>";
    echo "<td>사유 {$i}</td>";
    echo "<td class='td_cont'><input type='text' name='{$type}' value='{$value}' placeholder='{$no_value}' /></td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td colspan='2' class='btn'><button onclick='exe_reason(\"{$type}\")' class='exe_btn'>변경</button></td>";
  echo "</tr>";
  echo "</table>";
}

function print_agree(){
  $sql = "SELECT * FROM f_agree";
  $re = sql_fetch_array(sql_query($sql));

  $title = "이용약관";
  $content = $re['content'];

  echo "<table class='t_agree'>";
  echo "<tr>";
  echo "<td class='title'>{$title}</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='agree_cont'>";
  echo "<textarea class='agree_txt'>{$content}</textarea>";
  echo "</td>";
  echo "<tr>";
  echo "<td class='btn'><button onclick='exe_agree()' class='exe_btn'>변경</button></td>";
  echo "</tr>";
  echo "</table>";

}



function sms_send($msg,$receiver,$subject,$f_name,$f_type,$f_size){

  $sms_url = "https://apis.aligo.in/send/"; // 전송요청 URL
  $sms['user_id'] = "jl010302"; // SMS 아이디
  $sms['key'] = "xugzsb9xhge82qgglc87fdzbqubt98gt";//인증키
  /****************** 인증정보 끝 ********************/

  /****************** 전송정보 설정시작 ****************/

  $sms['msg'] = stripslashes($msg);
  $sms['receiver'] = $receiver;
  $sms['sender'] = "010-6675-7290";
  // $sms['testmode_yn'] = "Y";
  $sms['title'] = $subject;

  if($f_name){
    $path = "./img/forest_adm/".$f_name;
    $_POST['image'] = $path;
  }

  // 이미지 전송 설정
  if(!empty($_POST['image'])) {
  	if(file_exists($_POST['image'])) {
  		$tmpFile = explode('/',$_POST['image']);
  		$str_filename = $tmpFile[sizeof($tmpFile)-1];
  		$tmp_filetype = mime_content_type($_POST['image']);
  		if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
  			$sms['image'] = new CURLFile($_POST['image'], $tmp_filetype, $str_filename);
  			curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
  		} else {
  			$sms['image'] = '@'.$_POST['image'].';filename='.$str_filename. ';type='.$tmp_filetype;
  		}
  	}
  }

  $host_info = explode("/", $sms_url);
  $port = $host_info[0] == 'https:' ? 443 : 80;

  $oCurl = curl_init();
  curl_setopt($oCurl, CURLOPT_PORT, $port);
  curl_setopt($oCurl, CURLOPT_URL, $sms_url);
  curl_setopt($oCurl, CURLOPT_POST, 1);
  curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
  curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
  $ret = curl_exec($oCurl);
  curl_close($oCurl);

  // echo $ret;
  $retArr = json_decode($ret);
  return $retArr;

}


function getAdminInfo(){
  $sql = "SELECT * FROM f_sms_admin";
  $re = sql_query($sql);

  return $re;

}


function modify_fee_m(){
  $sql = "SELECT * FROM f_fee_m";
  $re = sql_fetch_array(sql_query($sql));
  $value = $re['tep'];

  $head_txt = "고객 수수료 관리";

  echo "<table class='fee_table'>";
  echo "<tr>";
  echo "<td colspan='2' class='title'>{$head_txt}</td>";
  echo "</tr>";

  for($i=1; $i<2; $i++){
    echo "<tr>";
    echo "<td>수수료 요율</td>";
    echo "<td class='td_cont'><input type='text' name='fee' value='{$value}' /> %</td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td colspan='2' class='btn'><button onclick='fee_apply()' class='exe_btn'>적용</button></td>";
  echo "</tr>";
  echo "</table>";
}


function modify_fee_p(){
  $sql = "SELECT * FROM f_fee_p";
  $re = sql_fetch($sql);
  $v1 = $re['tep1'];
  $v2 = $re['tep2'];
  $v3 = $re['tep3'];

  $head_txt = "농원 수수료 관리";

  echo "<table class='fee_table'>";
  echo "<tr>";
  echo "<td colspan='2' class='title'>{$head_txt}</td>";
  echo "</tr>";

  for($i=1; $i<4; $i++){
    $value = "v".$i;
    if($i==1){
      $grade = "일반농원";
    }else if($i==2){
      $grade = "베스트농원";
    }else{
      $grade = "공식파트너";
    }
    echo "<tr>";
    echo "<td >{$grade}</td>";
    echo "<td class='td_cont'><input type='text' name='fee{$i}' value='{$$value}' /> %</td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td colspan='2' class='btn'><button onclick='fee_apply_p()' class='exe_btn'>적용</button></td>";
  echo "</tr>";
  echo "</table>";

}

function conf_ready(){
  $sql = "SELECT * FROM f_wait_service";
  $re = sql_fetch($sql);
  $wait = $re['wait'];
  $max = $re['max_partner'];
  $cur = $re['cur_partner'];

  if($wait=="Y"){
    $checked_y = "checked";
  }else{
    $checked_n = "checked";
  }

  echo "<div class='ready_form'>";
  echo "<table class=''>";
  echo "<tr>";
  echo "<td colspan='2' class='title'>서비스 준비 상태 설정</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td >준비화면 설정</td>";
  echo "<td class='td_cont'>";
  echo "<input type='radio' name='wait' id='rwait1' value='Y' {$checked_y}/><label for='rwait1'>설정</label>";
  echo "<input type='radio' name='wait' id='rwait2' value='N' {$checked_n}/><label for='rwait2'>해제</label>";
  echo "</tr>";
  echo "<tr>";
  echo "<td colspan='2' class='btn'><button onclick='wait_service()' class='exe_btn'>적용</button></td>";
  echo "</tr>";
  echo "</table>";
  echo "</div>";

  echo "<div class='ready_txt'>";
  echo "<table class=''>";
  echo "<tr>";
  echo "<td colspan='2' class='title'>서비스 목표 농원 설정</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td >텍스트 설정</td>";
  echo "<td class='td_cont'>";
  echo "<input type='number' name='cur_part' value='{$cur}' /> &nbsp;/&nbsp; ";
  echo "<input type='number' name='max_part' value='{$max}' />";
  echo "</tr>";
  echo "<tr>";
  echo "<td colspan='2' class='btn'><button onclick='set_rtxt()' class='exe_btn'>적용</button></td>";
  echo "</tr>";
  echo "</table>";
  echo "</div>";


}



function getPartnerInfo($idx){
  $sql = "SELECT * FROM f_partner WHERE idx={$idx}";
  $rs = sql_fetch($sql);

  return $rs;
}



?>
