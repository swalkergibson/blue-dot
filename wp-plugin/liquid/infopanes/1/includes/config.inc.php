<?php
	define("TITLE",  "Graph Info Pane");
	define("SHOW_LEFT_AD", 0); // 0 or 1
	define("SHOW_BOTTOM_AD", 0); // 0 or 1
	define("SHOW_COMPARISON", 0); // 0 or 1
	define("SHOW_SPONSOR_AD", 1); // 0 or 1
	
	// Following is temporary article search link. You may edit but use [KEYWORD] & [FROM_DATE] in place of keyword & from date.
	$articleSearchLink = "http://www.economist.com/search/search.cfm?rv=2&qr=[KEYWORD]&fromdate=[FROM_DATE]";
	
	$arrTypesData = array(
						"Market" => array(
										  "^DJI" 	=> "Dow Jones",
										  "^IXIC" 	=> "Nasdaq", 
										  "^TNX" 	=> "10 Year Bond",
										  "^MXX"	=> "IPC",
										  "^GSPC" 	=> "S&amp;P 500"),
						"Share" => array(
										 "^BVSP" => "IBOVESPA",
										 "^MERV" => "MerVal",
										 "GOOG" => "Google"),
						"Commodity" => array(),
						"Currency" => array()
					);
					
	$arrDurations = array("1 Month", "2 Months", "3 Months", "6 Months", "1 Year", "2 Years", "3 Years");

       
        $uri = $_SERVER['REQUEST_URI'];
        $domain = $_SERVER['REQUEST_URI'];
        $host = $_SERVER['HTTP_HOST'];

        $uri = substr($uri,0, strrpos($uri, "/"));

        $basedir = "http://" . $host . $uri . "/";
       
?>