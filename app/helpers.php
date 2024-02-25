<?php
function str_replace_first($search, $replace, $subject)
{
    $search = '/'.preg_quote($search, '/').'/';
    return preg_replace($search, $replace, $subject, 1);
}

function api($endpoint, $body, $method, $port, $decode = true)
{

    $key = 'xwa_78d6acd8bdfd7b3249ea1ca255edfbca';
    $url = 'http://localhost:8000/' . $endpoint; // local
    // $url = 'https://berburumobilimpian.co.id/redir/router.php?endpoint=' . $endpoint . '&method=' . $method;

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL             => $url,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_ENCODING        => '',
    CURLOPT_MAXREDIRS       => 10,
    CURLOPT_TIMEOUT         => 600,
    CURLOPT_FOLLOWLOCATION  => true,
    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST   => $method,
    CURLOPT_POSTFIELDS      => $body,
    CURLOPT_HTTPHEADER      => array(
        'x-api-key: '.$key,
        'Content-Type: application/json'
    ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $response = json_decode($response, true);
    
    if($decode === false){
      return $response;
    } else {
      return response()->json($response);
    }

}

function cleanMessage($message)
{
  $message = str_replace(array("\r"), '\r', $message);
  $message = str_replace(array("\n"), '\n', $message);
  return $message;
}

function cekStatus($kode_pemesanan)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sandbox.midtrans.com/v2/'.$kode_pemesanan.'/status',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
      'Authorization: Basic U0ItTWlkLXNlcnZlci1Tc0lMbVFMUnl2OGNoV2djY3lVaWFoZmc6'
  ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  return json_decode($response, true);
}