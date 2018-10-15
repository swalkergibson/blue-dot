<?php
$str = <<<EOF
{
"Dow Jones Composite Average": "^DJA",
"Dow Jones": "^DJA",
"Dow Jones Industrial Average": "^DJI",
"Dow Jones Transportation Average": "^DJT",
"Dow Jones Utility Average": "^DJU",

"NYSE COMPOSITE INDEX (NEW METHO": "^NYA",
"NYSE": "^NYA",
"NYSE International 100": "^NIN",
"NYSE TMT": "^NTM",
"NYSE US 100": "^NUS",
"NYSE World Leaders": "^NWL",
"Volume in 000's": "^TV.N",

"NASDAQ Bank": "^IXBK",
"NASDAQ Biotechnology": "^NBI",
"NASDAQ Composite": "^IXIC",
"NASDAQ": "^IXIC",   
"NASDAQ Computer": "^IXK",
"NASDAQ Financial 100": "^IXF",
"NASDAQ Industrial": "^IXID",
"NASDAQ Insurance": "^IXIS",
"NASDAQ NNM COMPOSITE": "^IXQ",
"NASDAQ Other Finance": "^IXFN",
"NASDAQ Telecommunications": "^IXUT",
"NASDAQ Transportation": "^IXTR",
"NASDAQ-100": "^NDX",
"Volume in 000's": "^TV.O",

"S&P 100 INDEX": "^OEX",
"S&P 400 MIDCAP INDEX": "^MID",
"S&P 500 INDEX,RTH": "^GSPC",
"S&P COMPOSITE 1500 INDEX": "^SPSUPX",
"S&P SMALLCAP 600 INDEX": "^SML"
}
EOF;

$arr = json_decode($str,true);


if(array_key_exists($_GET['keyword'],$arr)){
    echo 1;
    
}else{
    echo 0;
}


?>