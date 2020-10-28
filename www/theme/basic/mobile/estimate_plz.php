<?php
include_once('../../../common.php');
include G5_THEME_MOBILE_PATH."/head.php";

$today = date("Y-m-d");
$mb_idx = getMbIdx($_SESSION['ss_mb_id']);


?>


<style>
.content{background-color:#fff;height:92vh;}
.wrap{margin-top:8vh;}
</style>

<div class="header">
  <h2>견적의뢰서</h2>
</div>



<div class="wrap">
  <div class="sub06">
    <form method="POST" action="./proc.php" onsubmit="return chk_data()" name="esti_form">
      <input type="hidden" name="" value="" />
      <input type="hidden" name="w_type" value="esti_plz" />
      <input type="hidden" name="w_class" value="1" />
      <input type="hidden" name="t_class" value="1" />
      <input type="hidden" name="m_idx" value="<?=$mb_idx?>" />
      <input type="hidden" name="div_cnt" />
      <h2>포레스트</h2>
      <p class="date"><?=$today?></p>

      <div class="work_na">
        <h4>공사명</h4>
        <div><input type="text" class="in_txt" name="w_name" maxlength="50" placeholder="공사명 입력" /></div>
      </div>

      <p class="notice">공사 등급과 수목 품목은 둘 중 한가지만 선택가능합니다.</p>

      <div class="choice">
        <div class="w_class">
          <div class="w_class1" onclick="sel_w_class(1)"><p class="wcf1">관급공사 (A급 조경수)</p></div>
          <div class="w_class2" onclick="sel_w_class(2)"><p class="wcf2">사급공사 (B급 조경수)</p></div>
        </div>
        <div class="tree_ca">
          <div class="t_class1" onclick="sel_t_class(1)"><p class="tcf1">교목</p></div>
          <div class="t_class2" onclick="sel_t_class(2)"><p class="tcf2">관목</p></div>
        </div>
      </div>

      <div class="size">
        <div class="size_title"><p>품목</p> <p>규격(단위:m)</p> <p>수량</p></div>
        <hr style="width:100%;margin:0 auto;border:1px solid #bbb;margin-top:5px;margin-bottom:10px;">
        <div id="item1" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item2" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item3" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item4" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item5" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item6" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item7" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>
        <div id="item8" class="item_div">
          <div>
            <input type="text" name="item_name[]" placeholder="입력"/>
            <input type="text" name="h_size[]" placeholder="H값" />
            <input type="text" name="w_size[]" placeholder="W값" />
            <input type="text" name="total[]" placeholder="입력" />
          </div>
          <div class="line_top"></div>
        </div>

        <div class="add" onclick="plus_div()"><p>+품목 추가</p></div>
      </div>

      <div class="delivery_date">
        <div class="date">
          <p>납품현장</p><p>납품날짜</p><p>요청사항</p>
        </div>
        <div class="box">
          <div><input type="text" name="w_place" class="no_border" /></div>
          <div>
            <input type="text" name="wr_1" value="<?php echo $write["wr_1"]; ?>" id="date_wr_1" required class="frm_input" size="11" readonly="readonly">
            <label for="date_wr_1"><img src="<?=$img_src?>/date_b.png" alt="납품 날짜"></label>
          </div>
          <div><input type="text" name="memo" class="no_border" /></div>
        </div>
      </div>

      <div class="date_dead">
        <div class="dd_head">입찰 마감일</div>
        <div class="dd_cont">
          <input type="text" name="wr_2" value="<?php echo $write["wr_2"]; ?>" id="date_wr_2" required class="frm_input" size="11" readonly="readonly">
          <label for="date_wr_2"><img src="<?=$img_src?>/date_w.png" alt="입찰 마감일"></label>
        </div>
      </div>

      <div class="click_box">
        <a href="<?=G5_URL?>" class="back">뒤로가기</a>
        <input type="submit" value="견적신청" class="enter" />
      </div>
    </form>

  </div>
</div>

<?
 include G5_THEME_MOBILE_PATH."/tail.php";
?>
