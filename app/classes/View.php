<?php

class View {

  private static $current_route = '';
  private static $styles = '';
  private static $header_scripts = '';
  private static $footer_scripts = '';
  private static $view_title = 'Document';
  private static $view_language = 'en';
  private static $view_metadata = '';
  private static $view_id = '';
  private static $view_favicon = '';
  private static $view_apple_touch_icon = '';
  private static $route_valid = true;

  /**
   * Setup the page title
   */
  private function set_view_title($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['view_title'])) {
      self::$view_title = $pages_json_instance[$current_route]['view_title'];
    }
  }

  /**
   * Setup the page language
   */
  private function set_view_language($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['language'])) {
      self::$view_language = $pages_json_instance[$current_route]['language'];
    }
  }

  /**
   * Setup the page favicon
   */
  private function set_view_favicon($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['favicon'])) {

      $favicon = $pages_json_instance[$current_route]['favicon'];
      self::$view_favicon .= '<link rel="icon" type="image/x-icon" href="'. CONFIG['site_url'] .'/public/images/'. $favicon .'">';
    }
  }

  /**
   * Setup the page apple touch icon
   */
  private function set_view_apple_touch_icon($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['apple_touch_icon'])) {

      $apple_touch_icon = $pages_json_instance[$current_route]['apple_touch_icon'];
      self::$view_apple_touch_icon .= '<link rel="apple-touch-icon" sizes="180x180" href="'. CONFIG['site_url'] .'/public/images/'. $apple_touch_icon .'">';
    }
  }

  /**
   * Setup the page metadata
   */
  private function set_view_metadata($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['meta'])) {

      $metadata = $pages_json_instance[$current_route]['meta'];
      foreach ($metadata as $key => $meta) {

        $attributes = '';
        foreach ($meta as $attribute => $value) {
          $attributes .= ' '. $attribute .'="'. $value .'"';
        }

        self::$view_metadata .= '<meta '. $attributes .'>';
      }
    }
  }

  /**
   * Setup the page id
   */  
  private static function set_view_id($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['page_id'])) {
      self::$view_id = $pages_json_instance[$current_route]['page_id'];
    }
  }

  /**
   * Setup the styles to be enqueued
   */
  private function set_styles_enqueue($current_route, $pages_json_instance) {

    if (self::$route_valid and isset($pages_json_instance[$current_route]['styles_enqueue'])) {

      $styles_enqueue = $pages_json_instance[$current_route]['styles_enqueue'];
      foreach ($styles_enqueue as $key => $css_file) {
        self::$styles .= '<link rel="stylesheet" href="'. PUBLIC_URI .'/css/'. $css_file .'">';
      }
    }
  }

  /**
   * Setup the scripts to be enqueued in the header
   */
  private function set_header_script_enqueue($current_route, $pages_json_instance) {

    if (self::$route_valid and 
        isset($pages_json_instance[$current_route]['script_enqueue']) and 
        !empty($pages_json_instance[$current_route]['script_enqueue'])) {

      $script_enqueue = $pages_json_instance[$current_route]['script_enqueue'];

      foreach ($script_enqueue as $key => $script_src) {

        if (strpos($script_src, '|') == false) {

          $defer = strpos($script_src, 'defer') !== false ? 'defer' : '';
          self::$header_scripts = self::$header_scripts .'<script '. $defer .' src="'. PUBLIC_URI .'/js/'. $script_src .'"></script>';
        }

        if (strpos($script_src, '|') !== false and 
            strpos($script_src, 'external') !== false and 
            strpos($script_src, 'footer') == false) {
          
          $defer = strpos($script_src, 'defer') !== false ? 'defer' : '';
          $script_src = substr($script_src, 0, strpos($script_src, '|'));
          self::$header_scripts = self::$header_scripts .'<script '. $defer .' src="'. $script_src .'"></script>';
        }
      }
    }
  }

  /**
   * Setup the scripts to be enqueued in the header
   */
  private function set_footer_script_enqueue($current_route, $pages_json_instance) {

    if (self::$route_valid and 
        isset($pages_json_instance[$current_route]['script_enqueue']) and 
        !empty($pages_json_instance[$current_route]['script_enqueue'])) {

      $script_enqueue = $pages_json_instance[$current_route]['script_enqueue'];

      foreach ($script_enqueue as $key => $script_src) {

        if (strpos($script_src, '|') !== false and 
            strpos($script_src, 'footer') !== false and 
            strpos($script_src, 'external') == false) {
          
          $defer = strpos($script_src, 'defer') !== false ? 'defer' : '';
          $script_src = substr($script_src, 0, strpos($script_src, '|'));
          self::$footer_scripts = self::$footer_scripts .'<script '. $defer .' src="'. PUBLIC_URI .'/js/'. $script_src .'"></script>';
        }

        if (strpos($script_src, '|') !== false and 
            strpos($script_src, 'footer') !== false and 
            strpos($script_src, 'external') !== false) {

          $defer = strpos($script_src, 'defer') !== false ? 'defer' : '';
          $script_src = substr($script_src, 0, strpos($script_src, '|'));
          self::$footer_scripts = self::$footer_scripts .'<script '. $defer .' src="'. $script_src .'"></script>';
        }
      }
    }
  }

  /**
   * Check the validity of the route
   */
  private function check_route_validity($current_route, $pages_json_instance) {
    return isset($pages_json_instance[$current_route]) ? true : false;
  }

  /**
   * Initialize this class
   */
  public static function initialize($current_route) {

    self::$current_route = $current_route;
    $pages_json_instance = json_decode(file_get_contents(ROOT_DIR .'/pages.json'), true);
    
    $self_instance = new self;

    self::$route_valid = $self_instance->check_route_validity($current_route, $pages_json_instance);

    $self_instance->set_view_title($current_route, $pages_json_instance);
    $self_instance->set_view_language($current_route, $pages_json_instance);
    $self_instance->set_view_metadata($current_route, $pages_json_instance);
    $self_instance->set_view_favicon($current_route, $pages_json_instance);
    $self_instance->set_view_apple_touch_icon($current_route, $pages_json_instance);
    $self_instance->set_view_id($current_route, $pages_json_instance);
    $self_instance->set_styles_enqueue($current_route, $pages_json_instance);
    $self_instance->set_header_script_enqueue($current_route, $pages_json_instance);
    $self_instance->set_footer_script_enqueue($current_route, $pages_json_instance);
  }

  /**
   * Returns the page title
   */
  public static function get_view_title() {
    return '<title>'. self::$view_title .'</title>';
  }

  /**
   * Returns the page language
   */
  public static function get_view_language() {
    return self::$view_language;
  }

  /**
   * Returns the page metadata
   */
  public static function get_view_metadata() {
    return self::$view_metadata;
  }

  /**
   * Returns the page favicon
   */
  public static function get_view_favicon() {
    return self::$view_favicon;
  }

  /**
   * Returns the page apple touch icon
   */
  public static function get_view_apple_touch_icon() {
    return self::$view_apple_touch_icon;
  }

  /**
   * Returns the view id
   */
  public static function get_view_id() {
    return self::$view_id;
  }

  /**
   * Returns the styles setup
   */
  public static function get_styles_enqueued() {
    return self::$styles;
  }

  /**
   * Returns the header scripts setup
   */
  public static function get_header_script_enqueued() {
    return self::$header_scripts;
  }

  /**
   * Returns the footer scripts setup
   */
  public static function get_footer_script_enqueued() {
    return self::$footer_scripts;
  }

  /**
   * Renders the view template of the current route
   */
  public static function get_view() {

    $pages = json_decode(file_get_contents(ROOT_DIR .'/pages.json'), true);

    if (isset($pages[self::$current_route]) and file_exists(ROOT_DIR .'/templates/'. $pages[self::$current_route]['template_file'])) {
      require_once ROOT_DIR .'/templates/'. $pages[self::$current_route]['template_file'];
    } else {
      if (file_exists(ROOT_DIR .'/templates/404.php')) {
        require_once ROOT_DIR .'/templates/404.php';
      }
    }
  }
}