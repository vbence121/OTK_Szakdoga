<?php

    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'wamp' .DS.'www'.DS.'szakdoga');
    defined('INC_PATH') ? null : define('INC_PATH', SITE_ROOT.DS.'PHP_API'.DS.'includes');
    defined('API_PATH') ? null : define('API_PATH', SITE_ROOT.DS.'PHP_API'.DS.'API');

    require_once(INC_PATH.DS."config.php");
    require_once(API_PATH.DS."APIcontroller.php");

?>