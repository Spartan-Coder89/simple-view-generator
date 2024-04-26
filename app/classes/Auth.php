<?php 

class Auth {

  /**
   * Check session before accessing the specified routes. Need session_start() to work.
   * 
   * Sample parameter values:
   *  $current_route = '';
   *  $routes = ['/route1', '/route2', '/route3'];
   */
  public static function check_session($current_route, $routes) {
    
    if (in_array($current_route, $routes)) {

      if (!isset($_SESSION['user_id']) or empty($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
      }
    }
  }

  /**
   * Generate and return random string as nonce
   */
  public static function generate_nonce() {

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION['nonce'] = bin2hex(openssl_random_pseudo_bytes(16));
    return $_SESSION['nonce'];
  }

  /**
   * Verify nonce input is in session
   */
  public static function verify_nonce($nonce_input) {

    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if (!isset($_SESSION['nonce'])) {
      return false;
    }

    return ($_SESSION['nonce'] == $nonce_input) ? true : false;
  }
}