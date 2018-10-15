<?php
	function dateDifference($dformat, $endDate, $beginDate){
		$date_parts1 = @explode($dformat, $beginDate);
		$date_parts2 = @explode($dformat, $endDate);
		$start_date = @gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date = @gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		return $end_date-$start_date;
	}
	
	function simpleEncode($array, $maxValue = 0){
		$maxValue = ($maxValue == 0)?ceil(max($array)):$maxValue;
		$simpleEncoding = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$cSimpleEncoding = strlen($simpleEncoding)-1;		
		$chartData = array();
		//Add increment factor to reduce the length of request uri.
		if(count($array) <= 30){
			$incFactor = 1;
		}else if(count($array) <= 365){
			$incFactor = 2;
		}else{
			$incFactor = ceil(round(count($array) / 365));
		}
		for($i=0; $i<count($array); $i+=$incFactor){
			$currentValue = $array[$i];
			if(/*is_integer($currentValue) && */$currentValue >= 0){
				$factor = round($cSimpleEncoding * $currentValue / $maxValue);
				$charAt = substr($simpleEncoding,$factor, 1);
				$chartData[] = $charAt;
			} else{
				$chartData[] = "_";
			}
		}
		return join("", $chartData);
	}
	
	function myRound($val){
		$val = round($val);
		if($val % 10 == 0 && $val % 3 == 0){		
			return $val;
		}
		$val++;
		return myRound($val);
	}
	
	function convertDateTime($dt){
		$a = explode(" ", $dt);
		$t = explode(":", $a[1]);
		$d = explode("-", $a[0]);
		return date("d M 'y H:i",mktime($t[0], $t[1], $t[2], $d[1], $d[2], $d[0]));
	}
	
	function convertDate($date){
		$d = explode("-", $date);
		return date("d M 'y",mktime(0, 0, 0, $d[1], $d[2], $d[0]));
	}
	
	function getData($keyword, $type){
		global $arrTypesData;
		$arrData = array();
		/***Actual data will be fetched here against keyword & type. Following is dummy data.***/		
		/*$files = array("table1.csv", "table2.csv", "table3.csv");
		if($keyword == "Nasdaq"){
			$selFile = "table.csv";
		}else{
			$selFile = $files[array_rand($files)];
		}*/

		//$q = array_search($keyword, $arrTypesData[$type]);
                $q = $keyword;

		if($q === FALSE){
			return $arrData;	
		}
		$dFrom = date("d", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") - 6));
		$mFrom = date("m", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") - 6)) - 1;
		$yFrom = date("Y", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") - 6));
		$dTo = date("d");
		$mTo = date("m") -1;
		$yTo = date("Y");
		// Fetching data from yahoo finance
		$selFile = "http://ichart.finance.yahoo.com/table.csv?s=".$q."&d=$mTo&e=$dTo&f=$yTo&g=d&a=$mFrom&b=$dFrom&c=$yFrom&ignore=.csv";
		
                $handle = fopen($selFile, "r");
		$row = -1;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if($data==""){
                        //echo "No data available";
                        return "No data available";
                    }
			if ($row == -1) {
				$row++;
				continue;
			}
			$arrData[$row]["Date"] = $data[0];
			/*$arrData[$row]["Open"] = $data[1];
			$arrData[$row]["High"] = $data[2];
			$arrData[$row]["Low"] = $data[3];*/
			$arrData[$row]["Close"] = $data[4];
			/*$arrData[$row]["Volume"] = $data[5];*/		
			$row++;
		}
		fclose($handle);
  
		return $arrData;
	}	
	
	function getResults($arrData, $period = "1 Year"){
		$arrResult = array();
		$currentDate = $arrData[0]["Date"];//date("Y-m-d");
		$tmp = explode(" ", $period);
		$tmpY = ($tmp[1] == "Year" || $tmp[1] == "Years")?$tmp[0]:0;
		$tmpM = ($tmp[1] == "Month" || $tmp[1] == "Months")?$tmp[0]:0;
		$tmp = explode("-", $currentDate);
		$startDate = date("Y-m-d", mktime(0, 0, 0, $tmp[1] - $tmpM, $tmp[2], $tmp[0] - $tmpY));
		$arrCurPoints = array();
		$arrHistPoints = array();
		$pieUp = 0;
		$pieDown = 0;
		$preValue == NULL;
		$count = 0;
		foreach($arrData as $arr){
			if(dateDifference("-", $arr["Date"], $startDate) >= 0){
				$arrCurPoints[] = round($arr["Close"]); // *** temp round
				if(preValue <> NULL){
					if($arr["Close"] > $preValue){
						$pieDown++;
						$count++;
					}elseif($arr["Close"] < $preValue){
						$pieUp++;
						$count++;
					}
				}
				$preValue = $arr["Close"];
			}else{
				$arrHistPoints[] = round($arr["Close"]);
			}
		}
		
		$arrCurPoints = array_reverse($arrCurPoints);
		$arrHistPoints = array_reverse($arrHistPoints);
		$maxValue = max(array_merge($arrCurPoints, $arrHistPoints));
		$maxValue = myRound($maxValue);
		
		$pieUpPerc = round($pieUp / $count * 100);
		$pieDownPerc = 100 - $pieUpPerc;
		$basicData = $arrData[0]["Close"];
		$rateStatus = ($arrData[0]["Close"] >= $arrData[1]["Close"])?"up":"down";
		$rateValue = $arrData[0]["Close"] - $arrData[1]["Close"];
		$ratePerc = round((($arrData[0]["Close"] - $arrData[1]["Close"]) / $arrData[1]["Close"]) * 100 , 2);
		$updateDate = date("Y-m-d H:i:s"); // current date
		$histYears = round(dateDifference("-", $arrData[0]["Date"], $arrData[count($arrData) -1]["Date"]) / 365, 1);
		
		$arrResult["CurPoints"] = $arrCurPoints;
		$arrResult["HistPoints"] = $arrHistPoints;
		$arrResult["MaxValue"] = $maxValue;
		
		$arrResult["PieUpPerc"] = $pieUpPerc;
		$arrResult["PieDownPerc"] = $pieDownPerc;
		
		$arrResult["BasicData"] = $basicData;
		$arrResult["RateStatus"] = $rateStatus;
		$arrResult["RateValue"] = $rateValue;
		$arrResult["RatePerc"] = $ratePerc;
		$arrResult["UpdateDate"] = $updateDate;
		$arrResult["HistYears"] = $histYears;
		$arrResult["Period"] = $period;
		$arrResult["CurrentDate"] = $currentDate;
		
		return $arrResult;
	}
	
	function showChartImage($img){
                $dir = dirname(__FILE__) . "/../";
                $pathret = "images/tmp/".date("dmYHis").rand(1,99).".png";

		$path = $dir . $pathret;
		$ch = curl_init ($img);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$cData = curl_exec($ch);
		curl_close ($ch);
		if(file_exists($path)){
			unlink($path);
		}
		$fp = fopen($path, 'x');
		if(!$fp){
                    return "error";
                }
                fwrite($fp, $cData);
		fclose($fp);
		return $pathret;
	}
?>