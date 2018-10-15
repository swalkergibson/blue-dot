<?php
$keyword = $_GET['s'];
if(empty($_GET['m'])){
    $market = "ALL";    
}else{
    $market = $_GET['m'];
}

$url = 'http://in.finance.yahoo.com/lookup?s=' . $keyword . '&t=S&m=' . $market;

echo file_get_contents($url);
?>
