<?php

define('STRAY_VERSION', '0.1');
define('STRAY_VERSION_CODE', 'Leoric');

define('STRAY_PATH_TO_APPS', '../apps/');
define('STRAY_PATH_TO_MODELS', '../models/');
define('STRAY_PATH_TO_LIB', '../lib/');
define('STRAY_PATH_TO_SCRIPTS', '../scripts/');
define('STRAY_PATH_TO_WEB', '');
define('STRAY_PATH_TO_INSTALL', '../');

// check if dev env
if (false === defined('STRAY_ENV'))
{
  define('STRAY_ENV', ('development' === getenv('STRAY_ENV') ? 'development' : 'production'));
}

// include php_error if development
if ('development' === STRAY_ENV)
{
  require STRAY_PATH_TO_LIB . 'vendor/php_error.php';
  \php_error\reportErrors();
}

// stray
$straypath = STRAY_PATH_TO_LIB . 'stray/';
require $straypath . 'global/require.php';
require $straypath . 'exception/require.php';
require $straypath . 'config/require.php';
require $straypath . 'persistance/require.php';
require $straypath . 'models/require.php';
require $straypath . 'models/query/require.php';
require $straypath . 'routing/require.php';
require $straypath . 'locale/require.php';
require $straypath . 'apps/require.php';
require $straypath . 'form/require.php';
require $straypath . 'ext/require.php';

// require attended routing
if ('development' === STRAY_ENV)
{
  require $straypath . 'routing/strayRoutingBootstrapDev.class.php';
  require $straypath . 'persistance/profiler/strayProfiler.class.php';
}
else
  require $straypath . 'routing/strayRoutingBootstrap.class.php';

// run
strayRouting::fGetInstance()->SetHost($_SERVER['SERVER_NAME']);
$url = (false === empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'] || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'] . str_replace('/index.php', null, $_SERVER['REQUEST_URI']);
strayRoutingBootstrap::fGetInstance()->Run($url, $_SERVER['REQUEST_METHOD']);
