<?php
	include_once("includes/config.inc.php");
	include_once("includes/functions.php");
	

	$keyword = isset($_REQUEST["keyword"])?$_REQUEST["keyword"]: (isset($_REQUEST["symbol"])? $_REQUEST["symbol"] : "Nasdaq");
	$name = isset($_REQUEST["name"])?$_REQUEST["name"]: $keyword;
	$type = isset($_REQUEST["type"])?$_REQUEST["type"]:"Market";
	
	$arrData = getData($keyword, $type);
        if($arrData!="No data available"){
            $arrResult = getResults($arrData);
        }
	$arrData1 = array();
	$arrResult1 = array();
	$type1 = $keyword1 = "";
	

?>



<link href="<?php echo $basedir ?>includes/styles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $basedir ?>includes/menus.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<link href="<?php echo $basedir ?>includes/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if IE 7]>
<link href="<?php echo $basedir ?>includes/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lt IE 7]>
<script type="text/javascript" src="<?php echo $basedir ?>includes/iepngfix/iepngfix_tilebg.js"></script>
<style type="text/css">
 img, div, input { behavior: url("<?php echo $basedir ?>includes/iepngfix/iepngfix.htc") !important; }
</style>
<![endif]-->

<?php
if(isset($_REQUEST["win"])==1){
?>
<script type="text/javascript" src="./includes/jquery-1.3.2.js"></script>
<script type="text/javascript" src="./includes/jquery.infopane.1.js"></script>
<script type="text/javascript" src="./includes/menu.js"></script>
<script type="text/javascript" src="./includes/jquery.simpletip-1.3.1.pack.js"></script>
<script type="text/javascript" src="./includes/urlEncode.js"></script>
<script type="text/javascript" src="./includes/stocklist.js"></script>
<script type="text/javascript" src="./includes/jquery.client.js"></script>


		<script language="JavaScript">
				jQuery(document).ready(function(){
					//jQuery.hw_basePath = 'http://localhost:8099/hyperwords/hsserver/hyperwords/';
					jQuery.hw_basePath = 'http://www.hyperwords.net/hwserver/hyperwords/';
					jQuery.InfoPane1InitDiv();
					jQuery.InfoPane1UpdateData('<?php echo $name ?>', '<?php echo $keyword ?>', '<?php echo $_GET['period'] ?>');
				});
        </script>
<?php
}        
?>
<div id="hw_info_pane_1">
<div id="ad_left_container">
<?php if(SHOW_LEFT_AD == 1){ ?>
		<div id="ad_panel" class="ad_panel"> <img alt="" src="images/ad_img.gif" /> </div>
<?php } ?>
	<div id="left_panel" class="left_panel">
<?php if(SHOW_SPONSOR_AD == 1){ ?>
	    <img alt="" src="<?php echo $basedir ?>images/american_express.gif" />
<?php } ?>        
	</div>
</div>
<div id="top_div">
	<div id="top_div_bar">
		<span id="hw_keyword" class="keyword"><?php echo $keyword;?></span>
		<span id="hw_basic_data" class="basic_data"><?php echo round($arrResult["BasicData"], 2);?></span>
		<div id="hw_RateStatus" class="no_data">&nbsp;</div>
		<span id="hw_RateValue" class="basic_data2"><?php echo round($arrResult["RateValue"], 2);?></span>
		<span id="hw_RatePerc" class="basic_data3">(<?php echo $arrResult["RatePerc"];?>%)</span>
	</div>
</div>
<div class="main_graph_div">
<?php

//if($arrData!="No data available" && $keyword!=""){
if(true){
?>
    <div class="middle_panel">
        
        <div id="middle_panel_top">&nbsp;</div>
        <div id="graphs_container">
        <?php include_once("graphs.inc.php"); ?>
        </div>
        

        <div id="middle_panel_bottom">
        	

            <div id="menu_div">
            	        	        <?php if(SHOW_COMPARISON == 1){ ?>
                <input type="button" class="hierarchal_menu" title="Expand/Collaps" value="" onclick="open_menu('menu');" />
                <ul id="menu">
                <?php
					foreach($arrTypesData as $key=>$arr){
				?>
      					<li> <a href="#" class="main_type"><?php echo $key;?></a>
                        	<ul>
							<?php
                                foreach($arr as $k => $val){
                            ?>
                                    <li class="<?php echo $key;?>_list"><a href="#" class="sub_item"><?php echo $val;?></a></li>
                            <?php
                                }
                            ?>
                              <li class="input_bg">
                                <input type="text" id="<?php echo $key;?>_list" class="submit" />
                              </li>
                            </ul>
				      </li>
             <?php
				 }
			 ?>
      			<li> <a id="close_menu" href="#">None</a> </li>
    		</ul>
    		            				<?php } ?> 
    		
            </div>
 
            
            <div id="year_div1"><span id="hw_HistYears"><?php echo $arrResult["HistYears"];?> Years</span></div>
            <div id="year_div2">
                <div id="year_left">&nbsp;</div>
                <div id="year_middle">
                	<div id="year_btn" >1 Year</div>
                    <ul id="years_menu">
                    <?php
						foreach($arrDurations as $val){
					?>
                   	  		<li><?php echo $val;?></li>
                    <?php
						}
					?>
                    </ul>
                </div>
            </div>
            <div id="date_time"><span id="hw_UpdateDate">Updated <?php echo convertDateTime($arrResult["UpdateDate"]);?></span></div>
        </div>
      
        
        <div id="bottom_div"></div>
        <?php if(SHOW_BOTTOM_AD == 1){ ?>
	        <div id="bottom_ad_panel"> <img alt="" src="<?php echo $basedir ?>images/bottom_ad_img.gif" /> </div>
		<?php } ?>
    </div>
</div>
<?php
}else{
?>
<div class="middle_panel">
        <div style="position: absolute; left: 215px; font-size: 12px; color: red;">Prototype</div>
        <div id="middle_panel_top">&nbsp;</div>
        <div id="graphs_container" style="color: red; text-align: center; font-size: 20px; margin-top: 50px;">
            No data available
        </div>


        <div id="bottom_div"></div>
        <?php if(SHOW_BOTTOM_AD == 1){ ?>
	        <div id="bottom_ad_panel"> <img alt="" src="<?php echo $basedir ?>images/bottom_ad_img.gif" /> </div>
		<?php } ?>
       </div>
</div>
<?php
}
?>

<input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
<input type="hidden" name="type1" id="type1" value="<?php echo $type1;?>" />
<input type="hidden" name="keyword1" id="keyword1" value="<?php echo $keyword1;?>" />
</div>
