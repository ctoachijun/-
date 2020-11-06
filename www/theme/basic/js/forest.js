
function sel_w_class(num){
  if(num==1){
    $(".w_class1").css("backgroundColor","#F47B6E");
    $(".w_class1").css("border","none");
    $(".wcf1").css("color","#fff");

    $(".w_class2").css("backgroundColor","#fff");
    $(".w_class2").css("border","1px solid #ddd");
    $(".wcf2").css("color","#000");

  }else if(num==2){
    $(".w_class1").css("backgroundColor","#fff");
    $(".w_class1").css("border","1px solid #ddd");
    $(".wcf1").css("color","#000");

    $(".w_class2").css("backgroundColor","#F47B6E");
    $(".w_class2").css("border","none");
    $(".wcf2").css("color","#fff");
  }
  $("input[name=w_class]").val(num);
}

function sel_t_class(num){
  if(num==1){
    $(".t_class1").css("backgroundColor","#F47B6E");
    $(".t_class1").css("border","none");
    $(".tcf1").css("color","#fff");

    $(".t_class2").css("backgroundColor","#fff");
    $(".t_class2").css("border","1px solid #ddd");
    $(".tcf2").css("color","#000");

  }else if(num==2){
    $(".t_class1").css("backgroundColor","#fff");
    $(".t_class1").css("border","1px solid #ddd");
    $(".tcf1").css("color","#000");

    $(".t_class2").css("backgroundColor","#F47B6E");
    $(".t_class2").css("border","none");
    $(".tcf2").css("color","#fff");
  }
  $("input[name=t_class]").val(num);
}

function plus_div(){
  let cnt = parseInt($("input[name=div_cnt]").val());
  if(!cnt){
    cnt = 1;
  }

  let pcnt = cnt+1;

  if(pcnt < 9){
    let div_name = "item"+pcnt;
    $("#"+div_name).css("display","flex");
    $("input[name=div_cnt]").val(pcnt);
  }else{
    $("input[name=div_cnt]").val(8);
  }

}


function chk_data(){
  let w_name = $("input[name=w_name]").val();
  let item_name = $("input[name='item_name[]']")[0].value;
  let h_size = $("input[name='h_size[]']")[0].value;
  let w_size = $("input[name='w_size[]']")[0].value;
  let total = $("input[name='total[]']")[0].value;
  let w_place = $("input[name=w_place]").val();
  let wr_1 = $("input[name=wr_1]").val();
  let memo = $("input[name=memo]").val();
  let wr_2 = $("input[name=wr_2]").val();

  if(!w_name){
    alert("공사명을 입력 해 주세요.");
    $("input[name=w_name]").focus();
    return false;
  }
  if(!item_name){
    alert("품목명을 입력 해 주세요.");
    $("input[name='item_name[]']")[0].focus();
    return false;
  }
  if(!h_size){
    alert("H 사이즈를 입력 해 주세요.");
    $("input[name='h_size[]']")[0].focus();
    return false;
  }
  if(!w_size){
    alert("W 사이즈를 입력 해 주세요.");
    $("input[name='w_size[]']")[0].focus();
    return false;
  }
  if(!total){
    alert("수량을 입력 해 주세요.");
    $("input[name='total[]']")[0].focus();
    return false;
  }
  if(!w_place){
    alert("납품현장을 입력 해 주세요.");
    $("input[name=w_place]").focus();
    return false;
  }
  if(!wr_1){
    alert("납품날짜를 입력 해 주세요.");
    $("input[name=w_r1]").focus();
    return false;
  }
  if(!wr_2){
    alert("입찰 마감일을 입력 해 주세요.");
    $("input[name=w_r2]").focus();
    return false;
  }
  if(h_size > 20){
    alert("단위는 m 입니다. 확인 해 주세요.");
    $("input[name='h_size[]']")[0].focus();
    return false;
  }
  if(w_size > 5){
    alert("단위는 m 입니다. 확인 해 주세요.");
    $("input[name='w_size[]']")[0].focus();
    return false;
  }

  return true;
}

function selTree(num){
  $("input[name=t_type]").val(num);
  $("#scol").submit();
}

function sortList(num){
  let sort_txt = "";
  if(num==1){
    sort_txt = "nd";
  }else{
    sort_txt = "dd";
  }
  $("input[name=sort_type]").val(sort_txt);
  $("#scol").submit();

}
function no_viewPartner(pidx,epidx){
  if(confirm("해당 견적의뢰서를 더이상 보지않으시겠습니까?")){
    let box = {"exe_type":"no_view","idx":epidx,"pidx":pidx};

    $.ajax({
            url: "../ajax.proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.sql);
      if(json.state=="Y"){
        alert("수정했습니다.");
        history.go(0);
      }else{
        alert("수정에 실패했습니다.");
      }
    });
  }
}

function sum_price(num){
  let sum_price = 0;
  let sum_price1 = 0;
  let price = 0;
  let p_box = 0;
  let dp = parseInt($("input[name=d_price]").val());;
  if(!dp){
    dp = 0;
  }

  for(var i=0; i<num; i++){
    let name_txt = "price"+(i+1);
    let x_txt = "osum"+(i+1);
    price = parseInt($("input[name="+name_txt+"]").val());
    if(!price){
      price = 0;
    }
    x_val = parseInt($("input[name="+x_txt+"]").val());

    p_box = price*x_val;
    sum_price += p_box;
  }

  sum_price1 = sum_price;
  sum_price = addComma(sum_price);
  $(".sum_price").val(sum_price);
  sum_price1 += dp;
  $("input[name=t_price]").val(sum_price1);
  sum_price1 = addComma(sum_price1);
  $(".total_price").val(sum_price1);


}

function gettotal_price(){

  let sump = $(".sum_price").val();
  let dp = parseInt($("input[name=d_price]").val());;
  let totalp = 0;

  if(!sump){
    sump = 0;
  }

  sump = parseInt(removeComma(sump));
  totalp = dp + sump;
  $("input[name=t_price]").val(totalp);
  totalp = addComma(totalp);
  $(".total_price").val(totalp);

}


function addComma(value){
    value = String(value);
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return value;
 }
function removeComma(str){
	let n = parseInt(str.replace(/,/g,""));
	return n;
}
function call_back(){
  history.go(-1);
}

function chk_form(num){

  for(var i=0; i<num; i++){
    let name_txt = "price"+(i+1);
    if(!$("input[name="+name_txt+"]").val()){
      alert("납품단가를 입력 해 주세요 ");
      $("input[name="+name_txt+"]").focus();
      return false;
    }
  }

  if(!$("input[name=d_price]").val()){
    alert("예상 운임비를 입력 해 주세요 ");
    $("input[name=d_price]").focus();
    return false;
  }

  return true;
}

function inputHview(mb_type,p_idx){

  if($("input[name=m_name]").is(":disabled")){

    $("input[name=m_name]").removeAttr("disabled");
    $("input[name=position]").removeAttr("disabled");
    $("input[name=m_tel]").removeAttr("disabled");
    $("input[name=email]").removeAttr("disabled");

    $("input[name=m_name]").css("border","1px solid #ccc");
    $("input[name=position]").css("border","1px solid #ccc");
    $("input[name=m_tel]").css("border","1px solid #ccc");
    $("input[name=email]").css("border","1px solid #ccc");

  }else if(!$("input[name=m_name]").is(":disabled")){

    let m_name = $("input[name=m_name]").val();
    let position = $("input[name=position]").val();
    let m_tel = $("input[name=m_tel]").val();
    let email = $("input[name=email]").val();

    let data_list = {"m_name":m_name, "position":position, "m_tel":m_tel, "email":email, "exe_type":"myp_edit", "mb_type":mb_type, "p_idx":p_idx};

    $.ajax({
      url: "/theme/basic/mobile/ajax.proc.php",
      type: "post",
      contentType:"application/x-www-form-urlencoded;charset=UTF8",
      data: data_list
    });

    $("input[name=m_name]").attr("disabled",true);
    $("input[name=position]").attr("disabled",true);
    $("input[name=m_tel]").attr("disabled",true);
    $("input[name=email]").attr("disabled",true);

    $("input[name=m_name]").css("border","0px");
    $("input[name=position]").css("border","0px");
    $("input[name=m_tel]").css("border","0px");
    $("input[name=email]").css("border","0px");
  }
}

function alarmOnoff(mb_type,mb_idx){
  let onoff = $(".onoff").val();

  if(onoff == "Y"){
    $(".onoff").val("N");
    $(".onoffBtn").attr("src","http://softer036.cafe24.com/theme/basic/img/off.jpg");
  }else{
    $(".onoff").val("Y");
    $(".onoffBtn").attr("src","http://softer036.cafe24.com/theme/basic/img/on.jpg");
  }

  onoff = $(".onoff").val();
  let data_list = {"exe_type":"alarmOnoff", "mb_idx":mb_idx, "mb_type":mb_type, "alarm":onoff}
  $.ajax({
    url: "/theme/basic/mobile/ajax.proc.php",
    type: "post",
    contentType:"application/x-www-form-urlencoded;charset=UTF8",
    data: data_list
  }).done(function(data){
    let json = JSON.parse(data);
    // console.log(json.sql);
  });
}

function noListExe(type,ep_idx){

  let data_list;

  if(type==1){
    // 내역삭제 처리
    if(confirm("내역에서 삭제하시겠습니까?")){
      data_list = {"exe_type":"del_list", "ep_idx":ep_idx};
      $.ajax({
        url: "/theme/basic/mobile/ajax.proc.php",
        type: "post",
        contentType: "application/x-www-form-urlencoded;charset=UTF8",
        data: data_list
      }).done(function(data){
        let json = JSON.parse(data);
        if(json.state=="Y"){
          alert("삭제 했습니다.");
          history.go(0);
        }else{
          alert("삭제에 실패했습니다.");
        }
      });
    }

  }else if(type==2){
    // 견적의뢰 취소 처리
    if(confirm("견적의뢰를 취소 하시겠습니까?")){
      data_list = {"exe_type":"ep_cancel", "ep_idx":ep_idx};
      $.ajax({
        url: "/theme/basic/mobile/ajax.proc.php",
        type: "post",
        contentType: "application/x-www-form-urlencoded;charset=UTF8",
        data: data_list
      }).done(function(data){
        let json = JSON.parse(data);
        if(json.state=="Y"){
          alert("취소 했습니다.");
          history.go(0);
        }else{
          alert("취소에 실패했습니다.");
        }
      });
    }
  }

}

function noptEsti(e_idx){
  if(confirm("견적을 거절 하시겠습니까?")){
    let data_list = {"exe_type":"noptEsti", "e_idx":e_idx}
    $.ajax({
      url: "/theme/basic/mobile/ajax.proc.php",
      type: "post",
      contentType:"application/x-www-form-urlencoded;charset=UTF8",
      data: data_list
    }).done(function(data){
      let json = JSON.parse(data);
      if(json.state=="Y"){
        alert("견적을 거절 했습니다.");
        history.go(0);
      }else{
        alert("견적 거절에 실패했습니다.");
      }
    });
  }
  history.go(0);
}

function editDPinfo(ep_idx,e_idx,opt){
  let t_name = "target"+e_idx;
  let ed_name = "ed_date"+e_idx;
  // console.log(t_name);
  // console.log(ed_name);
  let target = $('.'+t_name).val();
  let ed_date = $('.'+ed_name).val();
  let ro = $('.'+ed_name).prop(opt);
  ed_date = ed_date.replace(/[^0-9]/g," ");

  let data_list = {"exe_type":"editInfoDP", "e_date":ed_date, "target":target, "ep_idx":ep_idx};

  if(ro){
    $('.'+ed_name).prop("readonly",false);
    $("."+t_name).prop("readonly",false);
    $('.'+ed_name).css("border","1px solid #858585");
    $("."+t_name).css("border","1px solid #858585");
  }else{
    $('.'+ed_name).prop("readonly",true);
    $("."+t_name).prop("readonly",true);
    $('.'+ed_name).css("border","0");
    $("."+t_name).css("border","0");
  }
  $.ajax({
    url: "/theme/basic/mobile/ajax.proc.php",
    type: "post",
    contentType:"application/x-www-form-urlencoded;charset=UTF8",
    data: data_list
  }).done(function(data){
    let json = JSON.parse(data);
    // console.log(json.sql);
  });

}

function none_view(){
  let nov = $(".none").css("display");
  if(nov=="none"){
    $(".none").show();
  }else{
    $(".none").hide();
  }

}

function submit_pay(num){
  let txt;
  if(num==1){
    txt = "결제 하시겠습니까?";
  }else{
    txt = "입금확인 요청하시겠습니까?";
  }
  if(confirm(txt)){
    $("form").submit();
  }

}

function addPartner(p_idx,m_idx,type){
  let data_list = {"p_idx":p_idx, "m_idx":m_idx, "exe_type":"acco","type":type};
  $.ajax({
    url: "/theme/basic/mobile/ajax.proc.php",
    type: "post",
    contentType:"application/x-www-form-urlencoded;charset=UTF8",
    data: data_list
  }).done(function(data){
    let json = JSON.parse(data);
    console.log(json.sql);
    console.log(json.chk);
    alert(json.r_txt);
  });
}

function delPartner(p_idx,m_idx,type){
  let data_list = {"p_idx":p_idx, "m_idx":m_idx, "exe_type":"acco","type":type};
  if(confirm("거래처에서 삭제 하시겠습니까?")){
    $.ajax({
      url: "/theme/basic/mobile/ajax.proc.php",
      type: "post",
      contentType:"application/x-www-form-urlencoded;charset=UTF8",
      data: data_list
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.box1);
      console.log(json.box2);
      console.log(json.sql);
      console.log(json.chk);
      alert(json.r_txt);
    });
    history.go(0);
  }

}

function select_input(){
  let r_val = $("SELECT").val();

  if(r_val=="0"){
    $(".input_reason").show();
  }else{
    $(".input_reason").hide();
  }
}

function cancel_late(type,e_idx){
  let reason = $(".reason_input").val();
  let selector = $("SELECT").val();
  let ru = $("input[name=return]").val();
  let con_txt = "";
  let re_txt = "";

  if(type==1){
    con_txt = "입찰을 취소하시겠습니까?";
    re_txt = "취소";
  }else{
    con_txt = "배송지연 등록을 하시겠습니까?";
    re_txt = "등록";
  }

  let box = {"reason":reason, "selector":selector, "exe_type":"cancel_late", "type":type, "e_idx":e_idx};
  if(confirm(con_txt)){
    $.ajax({
      url: "../ajax.proc.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      data: box
    }).done(function(data){
      let json = JSON.parse(data);

      if(json.state=="Y"){
        alert(re_txt+"했습니다");
        window.location.href=ru;
      }else{
        alert("시스템 오류입니다.");
      }
    });
  }
}

function submit_wpic(){
  $("FORM").submit();
}

function setWpic(f_name){
  $('.pic_div').css({'background': 'url(../../img/forest/'+f_name+')'});
  $('.pic_div').css({'background-repeat': 'no-repeat'});
  $('.pic_div').css({'background-size': 'contain'});
  $('.pic_div').css({'background-position': 'center'});
}

function add_eval(e_idx,m_idx,p_idx){
  let point = $("#star_point").val();
  let comment = $("#comment").val().trim();
  let eval = $("input[name=eval]").val();
  let ru = $("input[name=return]").val();
  let con_txt = "";

  if(point==0){
    alert("평점을 선택 해 주세요");
  }else if(!comment){
    alert("후기를 입력 해 주세요.");
    $("#comment").focus();
  }else{
    if(eval==1){
      con_txt = "후기를 수정 하시겠습니까?";
    }else{
      con_txt = "후기를 등록 하시겠습니까?";
    }

    if(confirm(con_txt)){
      let box = {"exe_type":"add_eval", "e_idx":e_idx, "comment":comment, "point":point, "m_idx":m_idx, "p_idx":p_idx, "eval":eval};
      $.ajax({
        url: "ajax.proc.php",
        type: "post",
        contentType:'application/x-www-form-urlencoded;charset=UTF8',
        data: box
      }).done(function(data){
        let json = JSON.parse(data);
        // console.log(json.sql);
        if(json.state=="Y"){
          alert("등록했습니다");
          window.location.href=ru;
        }else{
          alert("시스템 오류입니다.");
        }
      });
    }

  }

}
