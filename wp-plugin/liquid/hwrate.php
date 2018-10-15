<?php

$rate = intval($_REQUEST['rate']);
$customer_id = isset($_REQUEST['customer_id']) ? $_REQUEST['customer_id'] : "";
$comment = isset($_REQUEST['comment']) ? $_REQUEST['comment'] : "";
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
$callback_name = isset($_REQUEST['callback_name']) ? $_REQUEST['callback_name'] : "";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
define('DS', DIRECTORY_SEPARATOR);
$logDir = dirname(__FILE__) . DS . 'log';
$logFile = $logDir . DS . 'hyperwords.log';

$handle = fopen($logFile, "a");
$strLogNode = date("Y-m-d H:i:s") . ' - ' . $_SERVER['REMOTE_ADDR'] . ' - ' . $customer_id . ' : ' . $rate . ' : ' . $email . ' : ' . $comment . "\n";
fwrite($handle, $strLogNode);
fclose($handle);


if ($customer_id) {
    if (isset($_REQUEST['callback_name'])) {
        $postfields = "?callback_name=" . $callback_name . "&type=" . $type . "&customer_id=" . $customer_id . "&ip=" . $_SERVER['REMOTE_ADDR'] . "&rate=" . $rate . "&email=" . $email . "&comment=" . $comment;
    } else {
        $postfields = "?customer_id=" . $customer_id . "&ip=" . $_SERVER['REMOTE_ADDR'] . "&rate=" . $rate . "&email=" . $email. "&comment=" . $comment;
    }
    $url = "http://173.204.58.67/hwserver/settings/saverate";
    //$url = "http://173.204.58.67/hwserver_test/settings/saverate";
    //$url = "http://www.hyperwords.local/settings/saverate" . $postfields;


    //old
    /*    $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FAILONERROR, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 3);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "callback_name=".$callback_name."&type=".$type."&customer_id=" . $customer_id . "&ip=" . $_SERVER['REMOTE_ADDR'] . "&rate=" . $rate . "&email=" . $email. "&comment=" . $comment);
      $res = curl_exec($ch);
      if (!$res) {
      echo curl_error($ch) . "(" . curl_errno($ch) . ")";
      }
      else
      echo $res;
      curl_close($ch);
     */
    $res = file_get_contents($url);
    echo $res;
}
?>