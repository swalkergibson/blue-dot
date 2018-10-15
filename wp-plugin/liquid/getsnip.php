<?php
$url = $_GET['url'];

$url = 'http://snipurl.com/site/snip?link=' . urlencode($url);

echo file_get_contents($url);
?>
