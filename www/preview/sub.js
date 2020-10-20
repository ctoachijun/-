function sel_w_class(type){
  if(type==1){
    $(".red").attr("background","#F47B6E");
    $(".red").attr("font-color","#fff");
    $(".non_mar").attr("background","#fff");
    $(".non_mar").attr("font-color","#333333");
  }else if(type==2){
    $(".red").attr("background","#fff");
    $(".red").attr("font-color","#333333");
    $(".non_mar").attr("background","#F47B6E");
    $(".non_mar").attr("font-color","#fff");
  }

}
