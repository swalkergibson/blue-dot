<?php
$keyword = $_GET['s'];
//$url = 'http://download.finance.yahoo.com/d/quotes.csv?s=' . urlencode($keyword) . '&f=snl1&e=.csv';
$url = 'http://sg.finance.yahoo.com/d/quotes.csv?s=' . urlencode($keyword) . '&f=c1snl1&e=.csv';
echo file_get_contents($url);
?>
