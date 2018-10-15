<?php


//$secret="182fa76ae0ead975eedf9c32fca5cf11";
//$api_key="51148faaf30906431b3ae75d270bbfc4";
$api_key = "97fd0a868768eab706ce876b572fa778";
$secret = "7ed2f0745094d02a923c7c762ba6eaf9";
$facebookUrl = "http://www.facebook.com/";

include 'lib/facebook/facebook.php';
include 'lib/facebook/facebook_desktop.php';

$facebook = new FacebookDesktop($api_key, $secret);



if (isset($_GET['share_require'])) {
    $permUrl = $facebookUrl.'connect/prompt_permissions.php?api_key='.$api_key.'&v=1.0&next='.$facebookUrl.'connect/login_success.html?xxRESULTTOKENxx&display=popup&ext_perm=publish_stream';
    $facebook->redirect($permUrl);
}

if (isset($_GET['login_require'])) {
    if (!empty($_GET['auth_token'])) {
        echo '<html><head><title></title><script language="JavaScript">window.close();</script></head><body></body></html>';
//        echo 'Login success';
        exit;
    }
//    $loginUrl = $facebook->get_login_url(Facebook::current_url(), $facebook->in_fb_canvas()) . '&ext_perm=publish_stream';
//    $facebook->redirect($loginUrl);
    $fbuser = $facebook->require_login();
} elseif (!$fbuser = $facebook->get_loggedin_user()) {
    echo '{"result":"login_require"}';
    exit;
}

$post_url = $_GET['url'];
$post_text = $_GET['text'];
try {
    if (!$facebook->api_client->users_hasAppPermission('publish_stream',$fbuser )) {
        echo '{"result":"share_require"}';
        exit;
    }
} catch (FacebookRestClientException $ex) {
    // facebook session is dead, kill the fb user session
    switch ($ex->getCode()) {
        case 102:
            $facebook->expire_session();
            echo '{"result":"login_require"}';
            break;
        default:
            echo '{"result":"share_require"}';
    }
    exit;
}

if (empty($_GET['text']) || empty($_GET['url'])) {
    echo '{"result":"text_require"}';
    exit;
}

$link_id = $facebook->api_client->links_post($post_url,$post_text,$fbuser);

echo $link_id;

echo json_encode(array('result' => 'OK', 'user_id' => $fbuser, 'link_id' => $link_id));

?>