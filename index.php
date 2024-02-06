<?php

// exit('Coming Soon');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Define constants to all over the codebase
 */
define('HTTP_PROTOCOL', (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://');
define('ROOT_DIR', dirname(__FILE__));
define('PUBLIC_URI', HTTP_PROTOCOL . $_SERVER['SERVER_NAME'] .'/public');

/**
 * Require global functions and variables
 */
require_once ROOT_DIR .'/app/globals.php';

/**
 * Autoload classes used
 */
spl_autoload_register(function ($class) {
  require_once ROOT_DIR .'/app/classes/' . $class . '.php';
});

/**
 * Intercept process if request is of rest request
 */
if (Route::is_rest_request(Route::get_current_route())) {
  API::handle_request(Route::get_current_route());
  exit;
}

/**
 * Initialize values involved in the current view
 */
View::initialize(Route::get_current_route());
?>

<!DOCTYPE html>
<html lang="<?php echo View::get_view_language(); ?>">
<head>
  <?php 
    echo View::get_view_title();
    echo View::get_view_favicon();
    echo View::get_view_apple_touch_icon();
    echo View::get_view_metadata();
    echo View::get_styles_enqueued();
    echo View::get_header_script_enqueued(); 
  ?>
</head>
<body>
  <?php 
    View::get_view();
    echo View::get_footer_script_enqueued();
  ?>
</body>
</html>