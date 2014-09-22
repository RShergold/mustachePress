<?php

class MustachePress {

  private static $settings,
                 $mustache_engine;

  function init() {
    self::$settings = array(
      'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
      'loader' => self::get_FilesystemLoader(),
      'partials_loader' => self::get_FilesystemLoader()
    );
  }

  public static function settings( $settings ) {
    self::$settings = array_merge( self::$settings, $settings );
    self::$mustache_engine = new Mustache_Engine( self::$settings );
  }

  public static function render( $template, $data=array() ) {

    if ( !isset(self::$mustache_engine) ){
      self::$mustache_engine = new Mustache_Engine( self::$settings );
    }

    return self::$mustache_engine->render( $template, new MPVariableHandler($data) );

  }

  private static function get_FilesystemLoader() {
    $default_views_directory = get_template_directory() . '/views';
    $mustache_views_directory = ( file_exists($default_views_directory) ) ? $default_views_directory : get_template_directory();
    return new Mustache_Loader_FilesystemLoader( $mustache_views_directory );
  }

}
