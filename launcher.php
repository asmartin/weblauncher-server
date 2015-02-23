<?php
$url = "http://netflix.com";
if (isset($_POST['url'])) {
	$url = $_POST['url'];
}
$fp = fsockopen("tv", 8023, $errno, $errstr);
if (!$fp) {
    echo "ERROR: $errno - $errstr<br />\n";
} else {
    fwrite($fp, $url);
    fclose($fp);
}
?>
