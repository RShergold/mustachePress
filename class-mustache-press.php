<?php

class MustachePress {

  private static $settings,
                 $mustache_engine;

  function init() {
    self::$settings = array(
      'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
      'loader' => new Mustache_Loader_FilesystemLoader( get_template_directory() ),
      'partials_loader' => new Mustache_Loader_FilesystemLoader( get_template_directory() )
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

}