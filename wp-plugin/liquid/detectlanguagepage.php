<?php

$q = $_GET['q'];
$url = "http://ajax.googleapis.com/ajax/services/language/detect?" .
        "v=1.0&key=AIzaSyC2PgUkUzTdgsU59BhGMcKVrlk4QV8DaU0&q=" . urlencode($q);
/* $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $body = curl_exec($ch);
  curl_close($ch);
 */
header('Content-type: application/json');
$body = file_get_contents($url);
if (isset($_GET['callback_name'])) {
    $callback = $_GET['callback_name'];
    echo $callback . "(" . json_encode(array('lang' => $body)) . ");";
} else {
    echo $body;
}
?>