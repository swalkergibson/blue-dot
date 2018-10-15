<?php
$terms = file_get_contents('economist-terms.txt');
$terms = unserialize($terms);
if(array_key_exists($_GET['q'], $terms)) {
	echo $terms[$_GET['q']];
}
?>