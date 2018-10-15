<?php
$leftChartLink = "http://chart.apis.google.com/chart?chs=104x100&cht=ls&chco=9D9D9D,000000&chf=bg,s,FFFFFF00&chd=s:";
$rightChartLink = "http://chart.apis.google.com/chart?chs=274x100&cht=ls&chco=EDEDED,000000&chf=bg,s,FFFFFF00&chd=s:";

if (count($arrData1) > 0 && count($arrResult1) > 0) {
    $maxValue = max($arrResult["MaxValue"], $arrResult1["MaxValue"]);
    $a = simpleEncode($arrResult["HistPoints"], $maxValue);
    $b = simpleEncode($arrResult1["HistPoints"], $maxValue);
    $leftChartLink .= $a . "," . $b;

    $a = simpleEncode($arrResult["CurPoints"], $maxValue);
    $b = simpleEncode($arrResult1["CurPoints"], $maxValue);
    $rightChartLink .= $a . "," . $b;
} else {
    $maxValue = $arrResult["MaxValue"];
    $a = simpleEncode($arrResult["HistPoints"], $maxValue);
    $leftChartLink .= $a;

    $a = simpleEncode($arrResult["CurPoints"], $maxValue);
    $rightChartLink .= $a;
}
?>


<div id="middle_panel_left">
    <?php
    if (count($arrData1) > 0 && count($arrResult1) > 0) {
    ?>
        <span id="l_val_1"><?php echo $maxValue; ?></span>
        <span id="l_val_2"><?php echo $maxValue / 3 * 2; ?></span>
        <span id="l_val_3"><?php echo $maxValue / 3; ?></span>
        <span id="l_val_4">0</span>
    <?php
    } else {
        $imgTop = ($arrResult["PieUpPerc"] == 0 && $arrResult["PieDownPerc"] == 0) ? "green_circle_small.gif" : "blue_arrow.gif";
        $imgBottom = ($arrResult["PieUpPerc"] == 0 && $arrResult["PieDownPerc"] == 0) ? "green_circle_small.gif" : "red_arrow.gif";
        $imgPie = ($arrResult["PieUpPerc"] == 0 && $arrResult["PieDownPerc"] == 0) ? "green_circle.gif" : "http://chart.apis.google.com/chart?chs=51x47&chd=t:" . $arrResult["PieDownPerc"] . "," . $arrResult["PieUpPerc"] . "&chp=4.728&chco=FF0000,0000FF&cht=p&chf=bg,s,FFFFFF00";
    ?>
        <div id="pie_chart_div">
            <div id="top_arrow" style="height: 20px">
                <img src="<?php echo $basedir ?>images/<?php echo $imgTop; ?>" align="middle" id="hw_imgTop"/>
                <br/>
                <span class="span_text" id="hw_PieUpPerc"><?php echo $arrResult["PieUpPerc"]; ?>%</span>
            </div>


            <div id="percent_circle" style="height: 40px"><img src="" id="hw_imgPie" alt="" /></div>


            <div id="bottom_arrow" style="height: 20px"><span class="span_text" id="hw_PieDownPerc"><?php echo $arrResult["PieDownPerc"]; ?>%</span>
                <br/>
                <img src="<?php echo $basedir ?>images/<?php echo $imgBottom; ?>" align="middle" id="hw_imgBottom"/></div>
        </div>
    <?php
    }
    ?>
</div>
<div id="middle_panel_middle">
    <div id="graph_left"><img src="" id="hw_leftChartLink" /></div>
    <div id="right_large_graph">
        <div id="graph_right">
            <div id="loading">Loading<span id="dots"></span></div>
            <?php
            // Calculation for lines in bg of right chart
            /* 	$divTotalWidth = 274;
              $monthDiff = $dayDiff = 0;
              $totalLines = 1;

              $tmpDate = explode("-", $arrResult["CurrentDate"]);
              $tmp = explode(" ", $arrResult["Period"]);
              if($tmp[1] == "Year" || $tmp[1] == "Years"){
              $totalLines = 12;
              $monthDiff = $tmp[0];
              $startDate = date("Y-m-d", mktime(0, 0, 0, $tmpDate[1] + $tmp[0], $tmpDate[2], $tmpDate[0] -$tmp[0]));
              }elseif($tmp[1] == "Month" || $tmp[1] == "Months"){
              $totalLines = 15;
              $dayDiff = $tmp[0] * 2;
              $startDate = date("Y-m-d", mktime(0, 0, 0, $tmpDate[1], $tmpDate[2] - (($totalLines - 1) * $dayDiff), $tmpDate[0]));
              }
              $leftMargin = round($divTotalWidth / $totalLines, 2);
              $width = round($divTotalWidth / $totalLines);

              for($i = 1; $i < $totalLines; $i++){
              $link = str_replace(array("[KEYWORD]", "[FROM_DATE]"), array($_REQUEST["keyword"], $startDate), $articleSearchLink);

             * <a href="<?php echo $link;?>" target="_blank"><div style="margin-left:<?php echo $leftMargin * $i;?>px; width: <?php echo $width ?>px;" class="bg_lines" ><span><?php echo convertDate($startDate);?></span></div></a>
             */
            ?>


            <?php
            //$tmpDate = explode("-", $startDate);
            //$startDate = date("Y-m-d", mktime(0, 0, 0, $tmpDate[1] + $monthDiff, $tmpDate[2] + $dayDiff, $tmpDate[0]));
            //}
            ?>
            <img src="" id="hw_rightChartLink" style="z-index:10;" />
        </div>
        <div id="middle_panel_right">
            <span id="hw_maxValue" class="r_val_1"><?php echo $maxValue; ?></span>
            <span id="hw_maxValue_2" class="r_val_234"><?php echo $maxValue / 3 * 2; ?></span>
            <span id="hw_maxValue_3" class="r_val_234"><?php echo $maxValue / 3; ?></span>
            <span id="hw_maxValue_4" class="r_val_234">0</span>
        </div>
    </div>
</div>

<?php
//dont show yet comparison not allowed
            if (count($arrData1) > 0 && count($arrResult1) > 0) {
?>
                <div id="tmp_bottom_div">
                    <div id="bottom_div_bar"> <span id="hw_keyword1" class="keyword"><?php echo $_REQUEST["keyword1"]; ?></span> <span id="hw_BasicData" class="basic_data"><?php echo round($arrResult1["BasicData"], 2); ?></span>
                        <div id="hw_RateStatus" class="<?php echo $arrResult1["RateStatus"] == "up" ? "up_arrow" : "down_arrow"; ?>">&nbsp;</div>
                        <span id="hw_RateValue" class="basic_data2"><?php echo round($arrResult1["RateValue"], 2); ?></span> <span id="hw_RatePerc" class="basic_data3">(<?php echo $arrResult1["RatePerc"]; ?>%)</span> </div>
                </div>
<?php
            }
?>

