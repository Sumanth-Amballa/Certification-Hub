<?php

$HTTP_HOST = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


define('secret', '79938292767981260961852095245701');
define('encrypt_key', '79938292767981260961852095245701');
define('adminManagerId', 8520952457);
define('managerManagerId', 7981260961);

define('jwtSecretKey', 'ma79dhu9su85man2sai79ram8gou93ri8');
define ('DECRYPT_ALGO', array('HS256'));
