<?php
require __DIR__ . "\includes\initialize.php";
 
$available = array("users","admins","dogs","events");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = substr($uri,strpos($uri, 'index.php'));
$uri = explode( '/', $uri );

if ((isset($uri[1]) && 
        !in_array($uri[1],$available)) || 
        !isset($uri[2])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$objFeedController = new APIcontroller($db);
$strMethodName = $uri[2].'_'.$uri[1];
$objFeedController->{$strMethodName}();
?>