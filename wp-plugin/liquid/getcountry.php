<?php
$url = 'http://api.hostip.info/country.php?ip=' . $_SERVER["REMOTE_ADDR"];
$str = file_get_contents($url);

if($str==""|| $str == "XX"){
	$str = "US";
}
echo $str;
?>
