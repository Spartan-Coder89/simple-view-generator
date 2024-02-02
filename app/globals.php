<?php

/**
 * Returns the site address
 */
function get_site_url() {
  $protocol = (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
  return $protocol . $_SERVER['SERVER_NAME'];
}

/**
 * Get the partial template file
 */
function get_partial_template($template_file) {
    
  if (file_exists(ROOT_DIR .'/templates/partials/'. $template_file)) {
    require_once ROOT_DIR .'/templates/partials/'. $template_file;
  } else {
    echo 'Partial template not found';
  }
}