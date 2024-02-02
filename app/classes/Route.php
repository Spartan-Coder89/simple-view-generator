<?php

class Route {

  /**
   * Process the request uri and returns the
   * current route
   */
  public static function get_current_route() {

    $request_uri = trim($_SERVER['REQUEST_URI']);

    if (trim($_SERVER['REQUEST_URI']) === '/') {
      return '/';
    }

    if (strpos(trim($_SERVER['REQUEST_URI']), '?') !== false) {
      $processed_uri = substr($request_uri, 0, strpos($request_uri, '?'));
      return (substr($processed_uri, -1) === '/') ? substr($processed_uri, 0, -1) : $processed_uri;
    }

    return (substr($request_uri, -1) === '/') ? substr($request_uri, 0, -1) : $request_uri;
  }

  /**
   * Retrieves the query string of the uri
   * and returns as a variable => value pair in array
   */
  public static function get_query_vars() {

    if (empty($_SERVER['QUERY_STRING'])) {
      return null;
    }

    $return_value = [];
    $query_string_expl = explode('&', trim($_SERVER['QUERY_STRING']));

    foreach ($query_string_expl as $key => $variable) {
      $variable_expl = explode('=', $variable);
      $return_value[$variable_expl[0]] = $variable_expl[1];
    }

    return $return_value;
  }

  /**
   * Check if the current request if for 
   * a rest request
   */
  public static function is_rest_request($current_route) {
    return strpos($current_route, '/rest-api') !== false ? true : false;
  }
}