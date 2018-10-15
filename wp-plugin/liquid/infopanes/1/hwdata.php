<?php
    $width = 530;
    $height = 151;
    
    $keyword = $_GET['keyword'];
    $url = 'http://sg.finance.yahoo.com/lookup?s=' . $keyword . '&t=S&m=ALL';

    $str = file_get_contents($url);

    $matches = array();
    preg_match  (  '/a href=\"\/q([^>]*)\"\\>View Quotes for All Above Symbols/'  ,  $str  ,  $matches );
    

    if(count($matches)>0){
         $yfsLink = $matches[1];
    }else{
         echo '{ "i1" : {
                                               "id" :2,
                                               "type" :"command",
                                               "label" :"Company not found"
                               }
               }';
         exit; 
    }
    
    

    //$url = 'http://download.finance.yahoo.com/d/quotes.csv?s=' . urlencode($keyword) . '&f=snl1&e=.csv';
    $url = 'http://sg.finance.yahoo.com/d/quotes.csv?s=' . urlencode($yfsLink) . '&f=snl1&e=.csv';
    $str = file_get_contents($url);
    

    $matches = array();
    preg_match_all  (  '/\"([^\"]*)\",\"([^\"]*)\",([0-9]+\.[0-9]+)/'  ,  $str  ,  $matches );
        //   var_dump($matches);
    echo "{";
    for($i=1;$i<count($matches[0]);$i++){
        
        echo '"i' . $i . '" : {
                                               "id" :"i' . $i . '",
                                               "type" :"command",
                                               "label" :"' . $matches[2][$i] . " (" . $matches[1][$i] . "): " . $matches[3][$i] . '",
                                               "shortcut" :null,
                                               "condition" :"",
                                               "command_function" :"infopane",
                                               "parent" :null,
                                               "left" :' . (2*($i-1)+1) . ',
                                               "right" :' . (2*($i-1)+2) . ',
                                               "command_params" : {
                                                               "infopane" :"1",
                                                               "graphthis" :"true",
                                                               "name" :"' . $matches[2][$i] . '",
                                                               "symbol" : "' .  $matches[1][$i] . '",
                                                               "period" :"1",
                                                               "height" :"' . $height . '",
                                                               "width" :"' . $width . '",
                                                               "win" : "1"
                                               }
                               }'; 
                               
                               if($i!=count($matches[0])-1){
                                    echo ",";   
                               }   
    }
    echo "}";
    

                               
?>
