<?php
error_reporting(0);
function rippy_readfile($file,$timeout=60,$lock=FALSE,$context=FALSE) {
#    echo "<!-- debug: reading $file -->\n";
  $content='';
  if ($context !== FALSE) {
    $handle=@fopen($file,'rb',FALSE,$context);
  } else {
     $handle=@fopen($file,'rb');
  }
  if ($handle) {
    if ($timeout>0) {
      stream_set_timeout($handle,$timeout);
    }
    if ($lock) {
       flock($handle,LOCK_SH);
    }
    while (!feof($handle) && strlen($content)<1024*256) {
        $content=$content.fgets($handle,1024*256);
    }
    if ($lock) {
     flock($handle,LOCK_UN);
    }
    fclose($handle);
  }
  return $content;
}
															   
function rippy_updatecache($url,$cache,$delay=3600,$timelimit=0,$chance=100,
   $context=FALSE) {
# echo "<!-- $cache is ".((time()-filemtime($cache))/86400)." days old. -->\n";
   if ($timelimit==0 || $timelimit>time())
   if (!file_exists($cache)
       || (filemtime($cache)+$delay<time() && (mt_rand(0,100)<$chance))
       || filesize($cache)==0) {

      $content=rippy_readfile($url,60,FALSE,$context);

      if (strlen($content)>0) {
         $out=fopen($cache,"ab");
         flock($out,LOCK_EX);
         ftruncate($out,0);
         fseek($out,0);
         fputs($out,$content);
         fflush($out);
         flock($out,LOCK_UN);
         fclose($out);
         return TRUE;
      }
   }
   return FALSE;
}

mt_srand((double)microtime()*1000000);

function doConditionalGet($timestamp) {
    // A PHP implementation of conditional get, see 
    //   http://fishbowl.pastiche.org/archives/001132.html
    $last_modified = substr(gmdate('r', $timestamp), 0, -5).'GMT';
    $etag = '"'.md5($last_modified).'"';
    // Send the headers
    header("Last-Modified: $last_modified");
    header("ETag: $etag");
    // See if the client has provided the required headers
    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
        stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
        false;
    $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
        stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
        false;
    if (!$if_modified_since && !$if_none_match) {
        return;
    }
    // At least one of the headers is there - check them
    if ($if_none_match && $if_none_match != $etag) {
        return; // etag is there but doesn't match
    }
    if ($if_modified_since && $if_modified_since != $last_modified) {
        return; // if-modified-since is there but doesn't match
    }
    // Nothing has changed since their last request - serve a 304 and exit
    header('HTTP/1.0 304 Not Modified');
    exit;
}
# doConditionalGet(floor(time()/86400)*86400);

rippy_updatecache('http://www.bankofcanada.ca/en/markets/csv/exchange_eng.csv',
                  './rates.cache',3600*4);

# table of currency codes
$nameabbr=array(
   'Canadia'=>'CAD',
   'U.S. Do'=>'USD',
   'Argenti'=>'ARS',
   'Austral'=>'AUD',
   'Bahamia'=>'BSD',
   'Brazili'=>'BRL',
   'Chilean'=>'CLP',
   'Chinese'=>'CNY',
   'Colombi'=>'COP',
   'Croatia'=>'HRK',
   'Czech R'=>'CZK',
   'Danish '=>'DKK',
   'East Ca'=>'XCD',
   'Europea'=>'EUR',
   'Fiji Do'=>'FJD',
   'CFA Fra'=>'CFA',
   'CFP Fra'=>'CFP',
   'Ghanaia'=>'GHC',
   'Guatema'=>'GTQ',
   'Hondura'=>'HNL',
   'Hong Ko'=>'HKD',
   'Hungari'=>'HUF',
   'Iceland'=>'ISK',
   'Indian '=>'INR',
   'Indones'=>'IDR',
   'Israeli'=>'ILS',
   'Jamaica'=>'JMD',
   'Japanes'=>'JPY',
   'Malaysi'=>'MYR',
   'Mexican'=>'MXN',
   'Morocca'=>'MAD',
   'Myanmar'=>'MMK',
   'Neth. A'=>'ANG',
   'New Zea'=>'NZD',
   'Norwegi'=>'NOK',
   'Pakista'=>'PKR',
   'Panaman'=>'PAB',
   'Peruvia'=>'PEN',
   'Philipp'=>'PHP',
   'Polish '=>'PLN',
   'Russian'=>'RUB',
   'Singapo'=>'SGD',
   'Slovak '=>'SKK',
   'South A'=>'ZAR',
   'South K'=>'KRW',
   'Sri Lan'=>'LKR',
   'Swedish'=>'SEK',
   'Swiss F'=>'CHF',
   'Taiwane'=>'TWD',
   'Thai Ba'=>'THB',
   'Trinida'=>'TTD',
   'Tunisia'=>'TND',
   'New Tur'=>'TRY',
   'U.K. Po'=>'GBP',
   'Venezue'=>'VEB',
   'Vietnam'=>'VND',
);

$foreign=array();
if (is_array($_REQUEST['F'])) {
   foreach ($_REQUEST['F'] as $fl) {
      foreach (explode(',',$fl) as $f) {
         if (in_array($f,$nameabbr)) {
            $foreign[]=$f;
         }
      }
   }
} else {
   foreach (explode(',',$_REQUEST['F']) as $f) {
      if (in_array($f,$nameabbr)) {
         $foreign[]=$f;
      }
   }
}

$base='USD';
$foreign=array('CAD','USD','ARS','AUD','BSD','BRL','CLP','CNY','COP','HRK','CZK','DKK','XCD','EUR','FJD','CFA','CFP','GHC','GTQ','HNL','HKD','HUF','ISK','INR','IDR','ILS','JMD','JPY','MYR','MXN','MAD','MMK','ANG','NZD','NOK','PKR','PAB','PEN','PHP','PLN','RUB','SGD','SKK','SIT','ZAR','KRW','LKR','SEK','CHF','TWD','THB','TTD','TND','TRY','GBP','VEB','VND');

# load rates
$handle=fopen('./rates.cache','r');
$dates=FALSE;
$rates=array('CAD'=>array('Canadian Dollar',1,1,1,1,1,1,1));
while (!feof($handle)) {
   $line=chop(fgets($handle));
   if (substr($line,0,1)=='#') { continue; }
   $larr=explode(',',$line);
   if ($dates===FALSE) {
      $dates=$larr;
      continue;
   }
   if ($larr[0]=='$Can/US closing rate') { continue; }
   if (count($larr)<3) { continue; }
   $rates[$nameabbr[substr($larr[0],0,7)]]=$larr;
}

# change a date into y-m-d
function ymddate($in) {
   return preg_replace('%^([0-9]+)/([0-9]+)/([0-9]+)$%','$3-$1-$2',$in);
}

# format a number with significant digits
function sigfigs($in,$prec=5,$plus=FALSE,$ref=FALSE) {
   if ($ref===FALSE) { $ref=$in; }
   if ($ref==0) {
      $expo=0;
   } else {
      $expo=floor(log(abs($ref),10));
   }
   return sprintf('%'.($plus?'+.':'.').max(0,$prec-1-$expo).'f',
                  round($in,$prec-1-$expo));
}

# get a single rate
function getrate($f,$b,$r) {
   global $_REQUEST,$rates;

   if ($_REQUEST['T']=='F') {
      if ($rates[$f][$r]>0) {
         $rate=$rates[$b][$r]/$rates[$f][$r];
      } else {
         $rate=0;
      }
   } else {
      if ($rates[$b][$r]>0) {
         $rate=$rates[$f][$r]/$rates[$b][$r];
      } else {
         $rate=0;
      }
   }
   return $rate;
}

# title for a quote
function quotename($f,$base) {
   global $_REQUEST,$rates;

   if ($_REQUEST['I']=='B') {
      $quote=($_REQUEST['T']=='F'?"$f/$base":"$base/$f");
   } elseif ($_REQUEST['I']=='L') {
      $quote=$rates[$f][0];
   } else {
      $quote=$f;
   }
   return $quote;
}

# get a current quote
function getquote($f,$base) {
   global $dates;

   $quote=quotename($f,$base);
   $count=count($dates);
   $rate=getrate($f,$base,$count-1);
   if ($rate>0) {
         $quote.=('  '.sigfigs($rate,5));
   } else {
      $quote.='  (n/a)';
   }
   return $quote;
}

# generate output
$descs=array();
$jrates="\"rates\":[";
$jnames="{\"symbols\":[";
foreach ($foreign as $f) {
  if($f === 'CAD') {
   $jnames.=("\"".quotename($f,$base)."\"");
   $jrates.=("\"".sigfigs(getrate($f,$base,count($dates)-1),5)."\"");
  }
  else {
   $jnames.=(",\"".quotename($f,$base)."\"");
   $jrates.=(",\"".sigfigs(getrate($f,$base,count($dates)-1),5)."\"");
  }
}
$jnames.="],\n";
$jrates.="]}\n";
echo($jnames);
echo($jrates);
?>
