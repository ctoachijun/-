<?php
session_start();
include "../common.php";

// 파일명에서 카카오,네이버 판별
$box = explode("/",$_SERVER['SCRIPT_FILENAME']);
$box2 = explode("_",end($box));
$box3 = $box2[0];


// KAKAO LOGIN
define('KAKAO_CLIENT_ID', 'e19acc187b7ae280bd3372b78695d3af');
define('KAKAO_ADMIN_ID', 'faf1092e4b7e31201e3523b9710f00f9');
define('KAKAO_CALLBACK_URL', 'https://softer036.cafe24.com/preview/kakao_callback.php');



$returnCode = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다.
$restAPIKey = "e19acc187b7ae280bd3372b78695d3af"; // 본인의 REST API KEY를 입력해주세요
$callbacURI = urlencode("https://softer036.cafe24.com/preview/kakao_callback.php"); // 본인의 Call Back URL을 입력해주세요
// API 요청 URL
$returnUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&code=".$returnCode;

$isPost = false;


echo "<br>";
print_r($_POST);
echo "<br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $returnUrl);
curl_setopt($ch, CURLOPT_POST, $isPost);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = array();
$loginResponse = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close ($ch);

// echo "<br>";
// var_dump($loginResponse); // Kakao API 서버로 부터 받아온 값

$accessToken= json_decode($loginResponse)->access_token; //Access Token만 따로 뺌
// echo "<br><br> accessToken : ".$accessToken;


$admin_key = KAKAO_ADMIN_ID; //APP 키 발급 정보에 보면 ADMIN 키도 함께 있다.
$access_token = $accessToken;
$app_url= "https://kapi.kakao.com/v2/user/me";
$opts = array(
  CURLOPT_URL => $app_url,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $access_token )
);
$ch = curl_init();
curl_setopt_array($ch, $opts);
$result = curl_exec($ch);
curl_close($ch);

$uid = json_decode($result)->id;
$token = $accessToken;



// if($_SESSION['kakao_state']){
//   $provide = "K";
//   $uid = "kakao_".$uid;
// }else{
//   $provide = "N";
//   $uid = "naver_".$uid;
// }

$_SESSION['uid'] = $uid;
$_SESSION['token'] = $token;
$_SESSION['provide'] = $provide;

// print_r($_SESSION);

$sql = "SELECT * FROM f_sns_member WHERE m_id = '{$uid}'";
$re = sql_num_rows(sql_query($sql));

exit;
if($re == 0){
  goto_url("./join_sns.php");
}else{
  goto_url("./sub01.php");
}



// if ($_GET["code"]) {
//   //사용자 토큰 받기
//   $code = $_GET["code"];
//   $params = sprintf( 'grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', KAKAO_CLIENT_ID, KAKAO_CALLBACK_URL, $code);
//   $TOKEN_API_URL = "https://kauth.kakao.com/oauth/token";
//   $opts = array(
//     CURLOPT_URL => $TOKEN_API_URL,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_SSLVERSION => 1,   // TLS
//     CURLOPT_POST => true,
//     CURLOPT_POSTFIELDS => $params,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HEADER => false
//   );
//   $curlSession = curl_init();
//   curl_setopt_array($curlSession, $opts);
//   $accessTokenJson = curl_exec($curlSession);
//   curl_close($curlSession);
//   $responseArr = json_decode($accessTokenJson, true);
//   $_SESSION['kakao_access_token'] = $responseArr['access_token'];
//   $_SESSION['kakao_refresh_token'] = $responseArr['refresh_token'];
//   $_SESSION['kakao_refresh_token_expires_in'] = $responseArr['refresh_token_expires_in'];
//   echo "session : ";
//   print_r($_SESSION);
//   echo "<br>";
//
//   //사용자 정보 가저오기
//   $USER_API_URL= "https://kapi.kakao.com/v2/user/me";
//   $opts = array(
//     CURLOPT_URL => $USER_API_URL,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_SSLVERSION => 1,
//     CURLOPT_POST => true,
//     CURLOPT_POSTFIELDS => false,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $responseArr['access_token'])
//   );
//   $curlSession = curl_init();
//   curl_setopt_array($curlSession, $opts);
//   $accessUserJson = curl_exec($curlSession);
//   curl_close($curlSession);
//   $me_responseArr = json_decode($accessUserJson, true);
//   echo "respo : ";
//   print_r($me_resposeArr);
//   echo "<br>";
//   var_dump($loginResponse);
//   if ($me_responseArr['id']) {
//
//     // 회원아이디(kakao_ 접두사에 네이버 아이디를 붙여줌)
//     $mb_uid = 'kakao_'.$me_responseArr['id'];
//     echo $mb_uid;
//     // 회원가입 DB에서 회원이 있으면(이미 가입되어 있다면) 토큰을 업데이트 하고 로그인함
//
//      if ($mb_uid) {
//
//         // 멤버 DB에 토큰값 업데이트 $responseArr['access_token'];
//
//      // 로그인
//      }else {
//         // 회원정보가 없다면 회원가입
//         // 회원아이디 $mb_uid
//          // properties 항목은 카카오 회원이 설정한 경우만 넘겨 받습니다.
//          $mb_nickname = $me_responseArr['properties']['nickname'];  // 닉네임
//          $mb_profile_image = $me_responseArr['properties']['profile_image']; // 프로필 이미지
//          $mb_thumbnail_image = $me_responseArr['properties']['thumbnail_image']; // 프로필 이미지
//          $mb_email = $me_responseArr['kakao_account']['email']; // 이메일
//          $mb_gender = $me_responseArr['kakao_account']['gender']; // 성별 female/male
//          $mb_age = $me_responseArr['kakao_account']['age_range']; // 연령대
//          $mb_birthday = $me_responseArr['kakao_account']['birthday']; // 생일
//          // 멤버 DB에 토큰과 회원정보를 넣고 로그인
//      }
//    }else {
//        // 회원정보를 가져오지 못했습니다.
//    }
// }

?>
