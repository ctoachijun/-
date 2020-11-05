<?php
include "./fcm_test.php";

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Insert title here</title>
</head>
<body>

<h1 id="order"></h1>

<h1> 파이어 메세지</h1>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>

<script>
  // Your web app's Firebase configuration
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
          $("#_token").html(token);
      })
      .catch(function(arr){
          console.log("Error Occured");
          console.log(arr);
      });

</script>

<span id="_token"></span>

</body>
</html>
