<?php
$symbol = $_GET['symbol'];
$dur = $_GET['dur'];
if($dur=="5d"){
    $url = "http://ichart.finance.yahoo.com/b?s=" . $symbol . "&lang=en-US&region=US";    
}else if($dur=="5d"){
    $url = "http://ichart.finance.yahoo.com/w?s=" . $symbol . "&lang=en-US&region=US";
}else{
    $url = "http://chart.finance.yahoo.com/c/" . $dur . "/_/" . $symbol . "?lang=en-US&region=US";
}
//echo $url;
error_reporting(1);

$im = imagecreatefrompng($url);
list($width,$height) = getimagesize($url);

//$newwidth = round($width/$height * 16);
//$im = imagecreatetruecolor($newwidth, 16);
//imagecopyresized  (  $im  ,  $inim  ,  0  ,  0 ,  0  ,  0  ,  $newwidth  ,  16  ,  $width  ,  $height  );

//if($im && imagefilter($im, IMG_FILTER_NEGATE))
//{
    //echo 'Image converted to Negated Colors.';

    //if($im && imagefilter($im, IMG_FILTER_GRAYSCALE ))
    //{

       // echo 'Image converted to grayscale.';
        //if($im && imagefilter($im, IMG_FILTER_COLORIZE, 0,0,0))
        //{

$white   = ImageColorAllocate ($im, 255, 255, 255);
$black = ImageColorAllocate ($im, 0, 0, 0);


for ($y=0;$y<$height;$y++)
{
    for ($x=0;$x<$width;$x++)
    {
        $rgb = imagecolorat($im,$x,$y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        //var_dump($r, $g, $b);



        $gray = ($r + $g + $b) / 3;
        $col = $black;

        if($gray > 1){
            $col = $white;
        }

        imagesetpixel($im,$x,$y,$col);

    }
}

            //echo 'Image converted to high contrast.';
            header('Content-type: image/gif');
            imagegif($im);
            //imagepng($im, 'stockout.png');
        //}

   // }
/*}
else
{
    echo 'Conversion to grayscale failed.';
}*/

imagedestroy($im);
?>
