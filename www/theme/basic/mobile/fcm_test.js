importScripts('https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js');

// Initialize Firebase
var firebaseConfig = {
  apiKey: "AIzaSyDQFnSGEwcTHVfgNe0zdT0CVJmKmTde-v4",
  authDomain: "forest-2cbc0.firebaseapp.com",
  databaseURL: "https://forest-2cbc0.firebaseio.com",
  projectId: "forest-2cbc0",
  storageBucket: "forest-2cbc0.appspot.com",
  messagingSenderId: "529706540188",
  appId: "1:529706540188:web:1557f552348a3301cee159"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload){
  const title = "Hello World";
  const options = { body: payload.data.status };
  return self.registration.showNotification(title,options);
});
