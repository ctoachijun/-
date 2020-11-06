<?php
include "./common.php";

// $mb_id = "drops";
// $exe_type = "get_token";
// $mb_type = "member";

?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>

<input type="hidden" name="mb_id" value="<?=$mb_id?>" />
<input type="hidden" name="exe_type" value="<?=$exe_type?>" />
<input type="hidden" name="mb_type" value="<?=$mb_type?>" />
<input type="hidden" name="token" id="_token" />

<script>
var firebaseConfig = {
  apiKey: "AIzaSyDQFnSGEwcTHVfgNe0zdT0CVJmKmTde-v4",
  authDomain: "forest-2cbc0.firebaseapp.com",
  databaseURL: "https://forest-2cbc0.firebaseio.com",
  projectId: "forest-2cbc0",
  storageBucket: "forest-2cbc0.appspot.com",
  messagingSenderId: "529706540188",
  appId: "1:529706540188:web:1557f552348a3301cee159"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
console.log(firebase);

const messaging = firebase.messaging();
  //token값 알아내기
messaging.requestPermission()
    .then(function(){
        console.log("Have permission");
        return messaging.getToken();
    })
    .then(function(token){
        console.log(token);
        $("#_token").val(token);
        $("#vtoken").html(token);
        let mb_id = $("input[name=mb_id]").val();
        let exe_type = $("input[name=exe_type]").val();
        let mb_type = $("input[name=mb_type]").val();
        let gtoken = token;
        // alert(token);
        console.log(exe_type);
        let box = {"exe_type":exe_type,"mb_id":mb_id,"token":gtoken,"mb_type":mb_type};

        $.ajax({
                url: "theme/basic/mobile/ajax.proc.php",
                type: "post",
                contentType:'application/x-www-form-urlencoded;charset=UTF8',
                data: box
        }).done(function(data){
          let json = JSON.parse(data);
          console.log(json.sql);
          // alert(json.sql);
          if(json.state=="Y"){
            // alert("등록했습니다.");
          }else{
            // alert("등록에 실패했습니다.");
          }
        });

    })
    .catch(function(arr){
        console.log("Error Occured");
        console.log(arr);
    });

</script>

<span id="vtoken"></span>
