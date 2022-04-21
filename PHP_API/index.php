<?php

require __DIR__ . "\includes\initialize.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = substr($uri,strpos($uri, 'index.php'));
$uri = explode( '/', $uri );

if ((isset($uri[1]) && $uri[1] != 'user') || !isset($uri[2])) {

    header("HTTP/1.1 404 Not Found");
    exit();
}

$objFeedController = new APIcontroller($db);
$strMethodName = $uri[2];
$objFeedController->{$strMethodName}();
?>