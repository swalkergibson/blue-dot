<?
$terms = file_get_contents('../../settings/' . $_GET['cid'] . '/definition-terms.txt');

function mb_unserialize($serial_str) {
    $out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
    return unserialize($out);
}
$terms = mb_unserialize($terms);

if(array_key_exists(strtoupper($_GET['q']), $terms)) {
    echo "<div style=\"float: right; margin-top: 70px; margin-left: 45px; margin-right: 45px; margin-bottom: 70px;\"><img width=\"180px\" src=\"" . $_GET['basepath']  . "settings/" . $_GET['cid'] . "/definition-ad.jpg\">";
    echo "</div>";
    
        echo "<div style=\"margin-left: 45px; margin-right: 45px; margin-top: 30px; margin-bottom: 30px; width: 460px;\"><b>" . strtoupper($_GET['q']) . "</b><br /><br />";
	echo $terms[strtoupper($_GET['q'])];
        echo "</div>";

}else{
    echo "Definition not found!";
}
?>