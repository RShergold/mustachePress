<?php
  /*
  Plugin Name: mustachePress
  Plugin URI:
  Description: Use the Mustache templating engine with Wordpress
  Author: Remi Shergold
  Version: 1.0
  Author URI: http://www.remi-shergold.com
  */

if( !class_exists('mustachePress') ):

//require Mustache ( errors are fatal )
require 'mustache/Autoloader.php';

//include mustachePress classes ( errors are warnings )
include('class-mustache-press.php');
include('class-mp-variable-handler.php');
include('class-mp-posts-iterator.php');

//init classes
Mustache_Autoloader::register();
MustachePress::init();

endif; // class_exists check