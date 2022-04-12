<?php

    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'wamp' .DS.'www'.DS.'szakdoga');
    defined('INC_PATH') ? null : define('INC_PATH', SITE_ROOT.DS.'includes');
    defined('CORE_PATH') ? null : define('CORE_PATH', SITE_ROOT.DS.'core');
    defined('API_PATH') ? null : define('API_PATH', SITE_ROOT.DS.'API');
    
    require_once(INC_PATH.DS."config.php");
    require_once(API_PATH.DS."users.php");

?>