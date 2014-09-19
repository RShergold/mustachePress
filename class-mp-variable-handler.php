<?php

class MPVariableHandler {

  private $data_to_render;

  public function __construct( $data_to_render ) {
    $this->data_to_render = $data_to_render;
  }

  public function __isset( $variable_name ) {
    return true;
  }

  public function __get( $variable_name ) {

    //set up a Iterator for The Loop
    if ( $variable_name == 'posts_loop' ) {
      return ( have_posts() ) ? new MPPostsIterator : false;
    }

    //is it in data_to_render
    if ( array_key_exists( $variable_name, $this->data_to_render ) ) {
      return $this->data_to_render[$variable_name];
    }

    //try and execute variable as a function
    return $this->execute_variable_as_function( $variable_name );

  }

  private function execute_variable_as_function($function_details) {

    // get the component parts
    preg_match_all("/'(?:\\\\.|[^\\\\'])*'|\S+/", $function_details, $matches);

    if ( !is_callable($matches[0][0]) ) {
      return false; //this is not an existing function
    }

    $function_name = array_shift($matches[0]);
    $function_parameters = $matches[0];

    array_walk($function_parameters, array($this, 'clean_parameter_string') );

    ob_start();
    $function_return = call_user_func_array($function_name, $function_parameters);
    $function_echo = ob_get_clean();
    return ( strlen($function_echo) > 0 ) ? $function_echo :  $function_return;

  }

  private function clean_parameter_string(&$parameter) {

    if ($parameter[0] == "'" && substr($parameter, -1) == "'") {
      $parameter = substr($parameter, 1, -1);
      $parameter = str_replace("\'", "'", $parameter);
    }

  }

}
