<?php

define('DS', DIRECTORY_SEPARATOR);
$logDir = dirname(__FILE__) . DS . 'log';
$logFile = $logDir . DS . 'hyperwords.log';

$adminLogin = 'admin';
$adminPassword = 'admin';


if (!empty($_POST['command'])) {
    $handle = fopen($logFile, "a");
    $strLogNode = date("Y-m-d H:i:s") . ' - ' . $_SERVER['REMOTE_ADDR'] . ' - ' . $_POST['command'] . ' : ' . $_POST['word'] . "\n";
    fwrite($handle, $strLogNode);
} else {
    if (!empty($_POST)) {
        if ($_POST['login'] != $adminLogin || $_POST['password'] != $adminPassword) {
            die ('Access Denied!');
        }
        if (!is_readable($logFile)) {
            die ('Access Denied!');
        }
        $is_download = false;
        if (isset($_POST['download'])) {
            $is_download = true;
        }
        if ($is_download) {
            header("Content-type:text/plain");
            header("Content-Disposition: attachment; filename=hwlog.txt");
        }
        $handle = fopen($logFile, "r");
        while (!feof($handle)) {
            $block = fread($handle, 8192);
            if ($is_download) {
                echo $block;
            } else {
                echo nl2br($block);
            }
        }
        fclose($handle);
    } else {
        if (!is_writable($logFile) && !is_writable($logDir)) {
            die ('Check files! File '.$logFile.' must be writeable!');
        }
        ?>
<HTML>
    <HEAD>
        <TITLE>Login</TITLE>
    </HEAD>
    <BODY BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0000FF" VLINK="#663399" ALINK="#663399">
        <CENTER>
            <H2>Login for view statistic</H2>
                <FORM METHOD="POST" ACTION="hwlog.php">
                    <TABLE ALIGN=CENTER BORDER=0>
                        <TR>
                            <TD>Login Name:&nbsp;&nbsp;&nbsp;</TD>

                            <TD><INPUT TYPE="TEXT" MAXLENGTH="15" NAME="login"></TD>
                        </TR>
                        <TR>
                            <TD>Password (case sensitive):</TD>
                            <TD><INPUT TYPE="PASSWORD" MAXLENGTH="15" NAME="password">
                            </TD>
                        </TR>
                    </TABLE>
                    <P ALIGN=CENTER><INPUT TYPE="SUBMIT" VALUE="Login"></P>
<?php if (isset($_GET['download'])): ?>
                    <INPUT TYPE="HIDDEN" NAME="download" VALUE="true">
<?php endif; ?>
                </FORM>
            </CENTER>
    </BODY>
</HTML>
    <?php
    }
}

?>
