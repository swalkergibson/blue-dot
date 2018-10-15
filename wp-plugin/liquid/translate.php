<?php

	$url = "http://www.worldlingo.com/S3643.1/api";
	$postdata =  "wl_data=" . urlencode($_REQUEST["wl_data"]) . "&wl_srclang=" . $_REQUEST["wl_srclang"] . "&wl_trglang=" . $_REQUEST["wl_trglang"] . "&wl_password=" . $_REQUEST["wl_password"] . "&wl_errorstyle=" . $_REQUEST["wl_errorstyle"] . "&wl_srcenc=" . $_REQUEST["wl_srcenc"];
/*
	$ch = curl_init();
  curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
  curl_setopt( $ch, CURLOPT_URL, $url );
  
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_FAILONERROR, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 30);
  
  $r=curl_exec ($ch);
  
  $ch_info=curl_getinfo($ch);

 header("Content-Type: " . $ch_info['content_type']);
  if (curl_errno($ch)) return false;
  else curl_close($ch);
  
  $r = trim($r);

  if (empty($r) && $_REQUEST["wl_srclang"] == $_REQUEST["wl_trglang"]) $r = trim($_REQUEST["wl_data"]);
  
  echo $r;
 */


        $res = file_get_contents($url."?".$postdata);
        if (empty($res) && $_REQUEST["wl_srclang"] == $_REQUEST["wl_trglang"]) $r = trim($_REQUEST["wl_data"]);
        echo $res;

?> 