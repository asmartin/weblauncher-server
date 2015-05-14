<?php
require_once("config.php");

$url = "http://avidandrew.com";
if (isset($_POST['url'])) {
        $url = $_POST['url'];
}
$fp = fsockopen("$VIEWER_HOST", 8023, $errno, $errstr);
if (!$fp) {
    echo "ERROR: $errno - $errstr<br />\n";
} else {
    fwrite($fp, $url);
    fclose($fp);
}
?>
