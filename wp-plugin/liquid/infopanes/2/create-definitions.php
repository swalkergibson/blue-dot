<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$row = 1;


$file = '../../settings/' . $_GET['cid'] . '/economist-dict.csv';

if (($handle = fopen($file, "r")) !== FALSE) {
   $arr = array();
   $lines = "";
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);

        $row++;
        if(strtoupper($data[0])==$data[0]){
            if($lines!=""){
                $arr[$curheader]=$lines;
                $lines="";
            }
            $curheader = $data[0];

        }else{
            $lines .= $data[0] . "<br>";
        }
        //for ($c=0; $c < $num; $c++) {
        //    echo $data[$c] . "<br />\n";
        //}
    }
    fclose($handle);

    $str = serialize($arr);
    file_put_contents("definition-terms.txt",$str);
    
    foreach( $arr as $key=>$val){
        $str2 .= '"' . $key . '",';
    }

    file_put_contents("definition-terms.js",$str2);
}
?>
