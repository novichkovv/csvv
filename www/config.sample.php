<?php
/**
 * configuration file
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath($_SERVER['DOCUMENT_ROOT']) . DS);
define('CORE_DIR', ROOT_DIR . 'core' . DS);
$site_dir = 'http://' . str_replace('http://', '', $_SERVER['HTTP_HOST'] . '/');
$project = 'frontend';
if(!empty($_GET['route'])) {
    $route = trim($_GET['route'], '\\/');
    $parts = explode('?', $route);
    $arr = explode('/', $parts[0]);
    if($arr[0] == 'backend') {
        if(count($arr) > 1) {
            unset($arr[0]);
            $_GET['route'] = implode('/', $arr) . '/';
        } else {
            unset($_GET['route']);
        }
        $project = 'backend';
    } else {
        $project = 'frontend';
    }
}

define('SITE_DIR', $site_dir);
if(count($arr = explode('.', $_SERVER['HTTP_HOST'])) > 2) {
    $sub_domain = array_shift($arr);
}
define('MAIN_SITE_DIR', 'http://' . str_replace('http://', '', implode('.', $arr) . '/'));
define('PROJECT', $project);
define('TEMPLATE_DIR', ROOT_DIR . 'templates' . DS . PROJECT . DS);
define('CONTROLLER_DIR', ROOT_DIR . 'controllers' . DS . PROJECT . DS);
define('LIBS_DIR', ROOT_DIR . 'libs' . DS);
define('IMAGE_DIR', SITE_DIR . '/images/' . PROJECT . '/');
define('DEVELOPMENT_MODE', true);



define('DB_NAME', 'csv');
define('DB_USER', 'csv');
define('DB_PASSWORD', '74dk$^dus0');
define('DB_HOST', 'localhost');

