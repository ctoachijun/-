<?

function senc_push($title,$content){
  define( 'API_ACCESS_KEY', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
  $msg = array(
                    'message'       => 'Wakeup Wakeup!!',
                    'title'         => 'Wakeup call !',
                 );
  $fields = array(
               'registration_id'  => xxxxxxxxxx,
               'data'              => $msg
              );
  $headers = array
                (
                 'Authorization: key=' . API_ACCESS_KEY,
                 'Content-Type: application/json'
                 );

  $ch = curl_init();
  curl_setopt( $ch,CURLOPT_URL, '//gcm-http.googleapis.com/gcm/send' );
  curl_setopt( $ch,CURLOPT_POST, true );
  curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
  curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
  curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
  $result = curl_exec($ch );
  curl_close( $ch );
  echo $result;
}

?>
