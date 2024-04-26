<?php

class API {

  public static function handle_request($current_route) {
    
    $rest_route = trim(str_replace('/rest-api', '', $current_route));
    $api_json_instance = json_decode(file_get_contents(ROOT_DIR .'/rest.json'), true);

    if (!isset($api_json_instance[$rest_route])) {
      http_response_code(404);
      echo "Rest route not found";
      exit;
    }

    if (!isset($api_json_instance[$rest_route]['method'])) {
      http_response_code(404);
      echo "Rest request method not specified";
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== $api_json_instance[$rest_route]['method']) {
      http_response_code(404);
      echo "Rest request method does not match the specified method";
      exit;
    }

    if (!isset($api_json_instance[$rest_route]['callback_file'])) {
      http_response_code(404);
      echo "Rest request callback not found";
      exit;
    }

    if (file_exists(ROOT_DIR. '/rest/'. $api_json_instance[$rest_route]['callback_file'])) {
      require_once ROOT_DIR. '/rest/'. $api_json_instance[$rest_route]['callback_file'];
    } else {
      http_response_code(404);
      echo "Rest request callback not found";
      exit;
    }
  }

  
}