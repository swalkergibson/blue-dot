<?php


	include_once("includes/config.inc.php");
	include_once("includes/functions.php");
	
	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "update_graphs"){
		$arrData = getData($_REQUEST["keyword"], $_REQUEST["type"]);
		$arrResult = getResults($arrData, $_REQUEST["period"]);
		
		if($_REQUEST["keyword1"] <> "" && $_REQUEST["type1"] <> ""){
			$arrData1 = getData($_REQUEST["keyword1"], $_REQUEST["type1"]);			
			$arrResult1 = getResults($arrData1, $_REQUEST["period"]);			
		}

                $leftChartLink = "http://chart.apis.google.com/chart?chs=104x100&cht=ls&chco=9D9D9D,000000&chf=bg,s,FFFFFF00&chd=s:";
                $rightChartLink = "http://chart.apis.google.com/chart?chs=274x100&cht=ls&chco=EDEDED,000000&chf=bg,s,FFFFFF00&chd=s:";

                if(count($arrData1) > 0 && count($arrResult1) > 0){
                        $maxValue = max($arrResult["MaxValue"], $arrResult1["MaxValue"]);
                        $a = simpleEncode($arrResult["HistPoints"], $maxValue);
                        $b = simpleEncode($arrResult1["HistPoints"], $maxValue);
                        $leftChartLink .= $a.",".$b;

                        $a = simpleEncode($arrResult["CurPoints"], $maxValue);
                        $b = simpleEncode($arrResult1["CurPoints"], $maxValue);
                        $rightChartLink .= $a.",".$b;
                }else{
                        $maxValue = $arrResult["MaxValue"];
                        $a = simpleEncode($arrResult["HistPoints"], $maxValue);
                        $leftChartLink .= $a;

                        $a = simpleEncode($arrResult["CurPoints"], $maxValue);
                        $rightChartLink .= $a;
                }
 
                
       		$imgTop = ($arrResult["PieUpPerc"] == 0 && $arrResult["PieDownPerc"] == 0)?$basedir."images/green_circle_small.gif":$basedir."images/blue_arrow.gif";
		$imgBottom = ($arrResult["PieUpPerc"] == 0 && $arrResult["PieDownPerc"] == 0)?$basedir."images/green_circle_small.gif":$basedir."images/red_arrow.gif";
		$imgPie = ($arrResult["PieUpPerc"] == 0 && $arrResult["PieDownPerc"] == 0)?$basedir."images/green_circle.gif":"http://chart.apis.google.com/chart?chs=51x47&chd=t:".$arrResult["PieDownPerc"].",".$arrResult["PieUpPerc"]."&chp=4.728&chco=FF0000,0000FF&cht=p&chf=bg,s,FFFFFF00";
                //$imgPie = $basedir . showChartImage($imgPie);
                //$leftChartLink = $basedir . showChartImage($leftChartLink, 2);
                //$rightChartLink = $basedir . showChartImage($rightChartLink, 3);
                $pieupperc = $arrResult["PieUpPerc"];
                $piedownperc = $arrResult["PieDownPerc"];
                //$maxValue;
                $basicdata =  round($arrResult["BasicData"], 2);
                $ratestatus = $arrResult["RateStatus"] == "up"?"up_arrow": $arrResult["RateStatus"] == "down"?"down_arrow":"no_move_dot";
                $ratevalue = round($arrResult["RateValue"], 2);
                $rateperc = $arrResult["RatePerc"] . "%";
                $histyears = $arrResult["HistYears"];
                //$arrDurations;
                $updatedate = convertDateTime($arrResult["UpdateDate"]);

                $retdata = array('imgTop' => $imgTop, 'imgBottom' => $imgBottom,
                                'imgPie' => $imgPie,
                                'leftChartLink' => $leftChartLink, 'rightChartLink' =>$rightChartLink,
                                'pieupperc' => $pieupperc, 'basicdata' => $basicdata,
                                'ratestatus' => $ratestatus, 'ratevalue' => $ratevalue,
                                'rateperc' => $rateperc, 'histyears' => $histyears,
                                'updatedate' => $updatedate,
                                'keyword' => $_REQUEST["keyword"],
                                'maxValue' => $maxValue,
                                'piedownperc' => $piedownperc,
                                'name' => $_REQUEST["name"]


                            );
              
                echo array_to_json($retdata);
		//include_once("graphs.inc.php");
	}


function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}
?>