<?php
include "../head_sub.php";
// if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//
// if( ! $config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
//     return;
// }



// $social_pop_once = false;
//
// $self_url = G5_BBS_URL."/login.php";
//
// //새창을 사용한다면
// if( G5_SOCIAL_USE_POPUP ) {
//     $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
// }


?>
<link rel="stylesheet" href="./style.css">
<div id="sns_login" class="login-sns sns-wrap-32 sns-wrap-over">
    <h3>소셜계정으로 로그인</h3>
    <div class="sns-wrap">
        <a href="" class="sns-icon social_link sns-naver" title="네이버">
            <span class="ico"></span>
            <span class="txt">네이버<i> 로그인</i></span>
        </a>
        <a href="" class="sns-icon social_link sns-kakao" title="카카오">
            <span class="ico"></span>
            <span class="txt">카카오<i> 로그인</i></span>
        </a>
        <script>
            jQuery(function($){
                $(".sns-wrap").on("click", "a.social_link", function(e){
                    e.preventDefault();

                    var pop_url = $(this).attr("href");
                    var newWin = window.open(
                        pop_url,
                        "social_sing_on",
                        "location=0,status=0,scrollbars=1,width=600,height=500"
                    );

                    if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
                         alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

                    return false;
                });
            });
        </script>


    </div>
</div>
