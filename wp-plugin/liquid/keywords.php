<?php
$terms = file_get_contents('economist-terms.txt');
$terms = unserialize($terms);

if(isset($_GET['kwd'])){
	echo $terms[$_GET['kwd']];
}