<?php

class Snipurl {
    var $url = 'http://snipr.com/site/getsnip';
    var $user = '';
    var $api_key = '';

    function __construct($user, $api_key) {
        $this->user = $user;
        $this->api_key = $api_key;
    }

    function Snipurl($user, $api_key) {
        $this->__construct($user, $api_key);
    }

    function getSnip($url, $title='') {
        // OPTIONAL FIELDS
        $snipnick   = '';            // MEANINGFUL NICKNAME FOR SNIPURL
        $snippk     = '';                      // PRIVATE KEY IF ANY
        $snipowner  = '';                      // IF THE SNIP OWNER IS SOMEONE ELSE
        $snipformat = 'simple';                      // DEFAULT RESPONSE IS IN XML, SEND "simple"
                                               // FOR JUST THE SNIPURL
        $snipformat_includepk = "";            // SET TO "Y" IF YOU WANT THE PRIVATE KEY
                                               // RETURNED IN THE SNIPURL ALONG WITH THE ALIAS
        $sniplink   = rawurlencode($url);
        $snipnick   = rawurlencode($snipnick);
        $sniptitle  = rawurlencode($title);

        // POSTFIELD
        $postfield =  'sniplink='  . $sniplink  . '&' .
                      'snipnick='  . $snipnick  . '&' .
                      'snipuser='  . $this->user  . '&' .
                      'snipapi='   . $this->api_key   . '&' .
                      'sniptitle=' . $sniptitle . '&' .
                      'snipowner=' . $snipowner . '&' .
                      'snipformat='. $snipformat. '&' .
                      'snippk='    . $snippk
          ;

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
?>
