// SMS 푸쉬 전송화면에서 파일 업로드쪽 조치
$(document).ready(function(){
  let fileTarget = $("#sn_img");
  fileTarget.on('change',function(){
    let cur=$(".file_box input[type='file']").val();
    $(".up_file").val(cur);
  });
});

// 알림내용 글자 수 제한
$('.sn_cont').keyup(function (e){
    var content = $(this).val();
    console.log(content);
    $('.counter').html("("+content.length+" / 최대 200자)");

    if (content.length > 200){
        alert("최대 200자까지 입력 가능합니다.");
        $(this).val(content.substring(0, 200));
        $('.counter').html("(200 / 최대 200자)");
    }
});

function check_all(f)
{
    var chk = document.getElementsByName("chk[]");

    for (i=0; i<chk.length; i++)
        chk[i].checked = f.chkall.checked;
}

function btn_check(f, act)
{
    if (act == "update") // 선택수정
    {
        f.action = list_update_php;
        str = "수정";
    }
    else if (act == "delete") // 선택삭제
    {
        f.action = list_delete_php;
        str = "삭제";
    }
    else
        return;

    var chk = document.getElementsByName("chk[]");
    var bchk = false;

    for (i=0; i<chk.length; i++)
    {
        if (chk[i].checked)
            bchk = true;
    }

    if (!bchk)
    {
        alert(str + "할 자료를 하나 이상 선택하세요.");
        return;
    }

    if (act == "delete")
    {
        if (!confirm("선택한 자료를 정말 삭제 하시겠습니까?"))
            return;
    }

    f.submit();
}

function is_checked(elements_name)
{
    var checked = false;
    var chk = document.getElementsByName(elements_name);
    for (var i=0; i<chk.length; i++) {
        if (chk[i].checked) {
            checked = true;
        }
    }
    return checked;
}

function delete_confirm(el)
{
    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        var token = get_ajax_token();
        var href = el.href.replace(/&token=.+$/g, "");
        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }
        el.href = href+"&token="+token;
        return true;
    } else {
        return false;
    }
}

function delete_confirm2(msg)
{
    if(confirm(msg))
        return true;
    else
        return false;
}

function get_ajax_token()
{
    var token = "";

    $.ajax({
        type: "POST",
        url: g5_admin_url+"/ajax.token.php",
        cache: false,
        async: false,
        dataType: "json",
        success: function(data) {
            if(data.error) {
                alert(data.error);
                if(data.url)
                    document.location.href = data.url;

                return false;
            }

            token = data.token;
        }
    });

    return token;
}

function view_detail(idx,type){
  $("input[name=idx]").val(idx);
  $("#view_data_"+type).submit();
}

function delp(type){
  if(type==2){
    $("input[name=type]").val("m_delete");
  }

  let re = confirm("삭제 하시겠습니까?");
  if(re==true){
    $("#del_post").submit();
  }
}

function editp(type){
  $("#del_post").attr("action","./member_edit.php");
  $("input[name=type]").val(type);
  $("#del_post").submit();
}

function editp_exc(type){
  if(type==2){
    $("input[name=w_type]").val("edit_member");
  }else if(type==1){
    $("input[name=w_type]").val("edit_partner");
  }

  let box = $("#edit_post").serialize();
  console.log(box);
  if(confirm("수정하시겠습니까?")){
    $.ajax({
            url: "ajax.adm_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            // async: false,
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      if(json.state=="Y"){
        alert("수정했습니다.");
        // move_back();
      }else{
        alert("수정에 실패했습니다.");
      }
    });
  }

}

function move_back(){
  $("#edit_post").attr("action","./member_list_detail.php");
  $("#edit_post").submit();
}


function partner_ship(type){
  let p_idx = $("input[name=idx]").val();
  let box = {"w_type":"edit_p_ship","partner_ship":type,"idx":p_idx};
  let con_txt = "으로 지정하시겠습니까?";
  if(type==1){
    con_txt = "일반농원"+con_txt;
  }else if(type==2){
    con_txt = "베스트농원"+con_txt;
  }else if(type==3){
    con_txt = "공식파트너농원"+con_txt;
  }

  let jud = confirm(con_txt);
  if(jud){
    $.ajax({
      url: "ajax.adm_proc.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      async: false,
      data: box
    }).done(function(data){
      let json = JSON.parse(data);
      if(json.state=="Y"){
        alert("지정했습니다.");
      }else{
        alert("지정에 실패했습니다.");
      }
    });
  }

}

function total_sum(stype){
  let box = {"w_type":"sn_total","type":stype};

  $.ajax({
    url: "ajax.adm_proc.php",
    type : "post",
    // async: false,
    data: box
  }).done(function(data){
    let json = JSON.parse(data);

    if(json.state=="Y"){
      let total_txt = "회원 ("+json.total+")명";
      $("#send_mem").val(total_txt);
      $("input[name=t_sum]").val(json.total);
    }else{
      alert("시스템 오류입니다.");
    }

  });
}


function con_submit(){
  var blank_pattern = /^\s+|\s+$/g;

  if(!$(".up_file").val()){
    if(!$(".sn_cont").val()){
      alert("알림 내용을 입력 해 주세요.");
      return false;
    }else if($(".sn_cont").val().replace(blank_pattern,'')==""){
      alert("공백만 입력되었습니다.");
      $(".sn_cont").val("");
      return false;
    }
  }
  return confirm("전송하시겠습니까?");

}

// 막대그래프
function show_stick(col4,col3,col2,col1){

  $("#chart1").append("<div id=col1Area><div id=col1 class='col1' style='margin-top:301px;'></div></div>");
  $("#chart1").append("<div id=col2Area><div id=col2 class='col2' style='margin-top:301px;'></div></div>");
  $("#chart1").append("<div id=col3Area><div id=col3 class='col3' style='margin-top:301px;'></div></div>");
  $("#chart1").append("<div id=col4Area><div id=col4 class='col4' style='margin-top:301px;'></div></div>");

  let plan = null;
  let out = null;
  let maxValue = (Number(col1) > Number(col2)) ? Number(col1) : Number(col2);
  let maxValue1 = (Number(col3) > Number(col4)) ? Number(col3) : Number(col4);

  // 그래프 총 길이는 maxHeight. 그래프 막대 길이는 height. 그래프 막대 시작위치는 marginTop
  // maxHeight - height = marginTop
  // 여기서 0.5당 60px의 height를 주면 된다.
  // 단, maxHeight가 300일때의 계산법.

  // 막대그래프 높이를 계산
  col4 *= 60;
  col3 *= 60;
  col2 *= 60;
  col1 *= 60;

  let maxHeight = 300;
  let marginTop = $("#col1").get(0).style.marginTop.replace('px','');

  plan = Math.floor(Number((maxHeight * col1) / maxValue));
  out = Math.floor(Number((maxHeight * col2) / maxValue));
  plan1 = Math.floor(Number((maxHeight * col3) / maxValue1));
  out1 = Math.floor(Number((maxHeight * col4) / maxValue1));


  // 막대그래프 윗쪽 여백을 계산
  col1_mt = maxHeight - col1;
  col2_mt = maxHeight - col2;
  col3_mt = maxHeight - col3;
  col4_mt = maxHeight - col4;

  $("#col1").animate({ height: col1 + "px", marginTop: col1_mt + "px"}, 1800);
  $("#col2").animate({ height: col2 + "px", marginTop: col2_mt + "px"}, 1800);
  $("#col3").animate({ height: col3 + "px", marginTop: col3_mt + "px"}, 1800);
  $("#col4").animate({ height: col4 + "px", marginTop: col4_mt + "px"}, 1800);

  // $("#col2").animate({ height: out + "px", marginTop: (Number(marginTop) - out) -1 + "px"}, 1800);
  // $("#col3").animate({ height: plan1 + "px", marginTop: (Number(marginTop) - plan1) -1 + "px"}, 1800);
  // $("#col4").animate({ height: out1 + "px", marginTop: (Number(marginTop) - out1) -1 + "px"}, 1800);

}

function show_line(a1,a2,a3,a4,stx){

  // $.jqplot('graph',[[,a1,a2,a3,a4,]],{
  $.jqplot('graph',[[,a1,a2,a3,a4,]],{
    axesDefaults: {
      tickOptions: {
        fontSize: '12pt',
        markSize: 0
      }
    },
    animate : true,
    seriesDefaults: {
      color: '#F57B6F'
    },
    grid :{
      background: '#fff'
    },

    axes:{
      xaxis:{
        label: stx,
        tickOptions:{
          showGridline:false,
          formatString:"%s"
        },
        ticks:[[1,''],[2,'3주전'],[3,'2주전'],[4,'1주전'],[5,'이번주'],[6,'']]
      },
      yaxis:{
        tickOptions:{
        },
      }
    }
  });
}

function show_stick(w1,w2,w3,w4,stx){
  let line1 = [ ['3주전', w1], ['2주전', w2], ['1주전', w3], ['이번주', w4] ];
  $.jqplot('stick', [line1], {
    animate : true,
    series:[ {
      renderer:$.jqplot.BarRenderer,
      rendererOptions: {
        barWidth: 50,
        color: '#34B8E9'
      }

    } ],
    seriresDefaults: {

    },
    grid :{
      background: '#fff'
    },
    axesDefaults: {
      tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
      tickOptions: {
        /*옵션들은 document페이지를 참고*/
        fontSize: '12pt',
        markSize: 0
      }
    },
    axes: {
      xaxis: {
        renderer: $.jqplot.CategoryAxisRenderer,
        label: stx,
        tickOptions: {
          showGridline:false,
        }
      }
    }
  });
}



$(function() {
    $(document).on("click", "form input:submit, form button:submit", function() {
        var f = this.form;
        var token = get_ajax_token();

        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }

        var $f = $(f);

        if(typeof f.token === "undefined")
            $f.prepend('<input type="hidden" name="token" value="">');

        $f.find("input[name=token]").val(token);

        return true;
    });
});
