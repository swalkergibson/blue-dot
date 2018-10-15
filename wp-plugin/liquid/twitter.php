<?php

session_start();
require_once('lib/twitter/twitteroauth.php');
require_once('lib/snipurl/snipurl.php');

// make sure you swap these for your own!
$consumer_key = '6TEYSq1kdfIttN84Wwi6Ew';
$consumer_secret = '5dLuOHm5jVWLTaWTBjuB21Pp7tj5ZlRZC8YBxVQj8';

if (isset($_GET['login_require'])) {
    // create some request tokens
    $toa = new TwitterOAuth($consumer_key, $consumer_secret);
    $tokens = $toa->getRequestToken();
//var_dump($tokens);
    $_SESSION['oauth_request_token'] = $tokens['oauth_token'];
    $_SESSION['oauth_request_token_secret'] = $tokens['oauth_token_secret'];
    $_SESSION['oauth_state'] = 'SENT';

    // send the user on their way
    header('Location: '.$toa->getAuthorizeURL($tokens['oauth_token']));
}

if (empty($_SESSION['oauth_state'])
    || ($_SESSION['oauth_state'] == 'SENT' && empty($_GET['oauth_verifier']))
    || $_GET['oauth_verifier'] == 'null'
        ) {
    echo '{"result":"login_require"}';
    exit;
}

switch ($_SESSION['oauth_state']) {
    case 'SENT':
        $toa = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
        $tokens = $toa->getAccessToken($_GET['oauth_verifier']);
        if(empty($tokens['oauth_token'])) {
            unset($_SESSION['oauth_state']);
            $matches = array();
            preg_match('/<error>(.*)<\/error>/i', implode(' ', $tokens), $matches);
            $result = array('result' => 'ERROR', 'message' => $matches[1]);
            echo json_encode($result);
            exit;
        }
        $_SESSION['oauth_state'] = 'RETURNED';
        $_SESSION['oauth_access_token'] = $tokens['oauth_token'];
        $_SESSION['oauth_access_token_secret'] = $tokens['oauth_token_secret'];

        break;
    case 'RETURNED':
        if (empty($_GET['text']) || empty($_GET['url'])) {
            echo '{"result":"ERROR", "message":"Select text please"}';
            exit;
        }
        $snipurl = new Snipurl('apmpc', '8d548111516914d450a2b2470dff3587');
        $text = $_GET['text'] . ' ' . $snipurl->getSnip($_GET['url']);
        if (strlen($text) > 140) {
            echo '{"result":"ERROR", "message": "Long text"}';
            exit;
        }
        $toa = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
        $result = $toa->OAuthRequest('https://twitter.com/statuses/update.xml', 'POST', array('status' => $text));
        if (preg_match('/Error/i', $result)) {
            $result = array('result' => 'ERROR', 'message' => $result);
            echo json_encode($result);
            exit;
        }
        break;

}

echo '{"result":"OK"}';

?>
