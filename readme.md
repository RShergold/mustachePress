MustachePress.php
=================

A [Wordpress](http://wordpress.com) plugin for using [Mustache](http://mustache.github.com/) tempates.

This is just a very small wrapper around the excellent [Mustache.php](https://github.com/bobthecow/mustache.php) engine by Justin Hileman. Included in this repository (in `/Mustache`) is a complete copy of Mustache.php

It is the version from September 2014. If you would like to update to the newer version simply swap it out. However I can't be sure it will work!

Usage
-----

<small>index.php</small>

	<?php
	
	echo MustachePress::render('index');

<small>index.mustache</small>

	<h1> {{get_bloginfo name}} </h1>


Functions
---------

You can access all the standard Wordpress functions (as above) using the `{{function_name variable1 variable2}}` syntax.

You can also create your own functions and call them from within your template.

###For logic

<small>single.php</small>

	<?php
	
	the_post();
	
	function was_this_posted_today(){
	  return ( date('Yz') == get_the_time('Yz') ) ? true : false;
	}
	
	echo MustachePress::render('single');

<small>single.mustache</small>

	<h1> {{the_title}} </h1>
	
	{{{the_content}}}
	
	{{#was_this_posted_today}}
	  Posted today!
	{{/was_this_posted_today}}

###For output

<small>single.php</small>

	<?php
	
	the_post();
	
	function author_job_title(){
	  return ( get_the_author() == 'Remi' ) ? 'Admin' : 'Contributor';
	}
	
	echo MustachePress::render('single');

<small>single.mustache</small>

	<h1> {{the_title}} </h1>
	
	{{{the_content}}}
	
	<p>This post was written by {{the_author}} - {{author_job_title}}</p>


Data
----
You can pass in data just as you would in the base [Mustache.php](https://github.com/bobthecow/mustache.php) engine.

###Array
<small>single.php</small>

	<?php
	
	$data_to_render = array(
	  'template_engine' => 'mustache.php',
	  'colors' => array(
	    array('color'=>'red'),
	    array('color'=>'green'),
	    array('color'=>'blue')
	  )
	);
	
	echo MustachePress::render('single',$data_to_render);


###Object
<small>single.php</small>

	<?php
	
	class SinglePost {
	  public $template_engine = 'mustache.php';
	
	  public function colors() {
	    return array(
	      array('color'=>'red'),
	      array('color'=>'green'),
	      array('color'=>'blue')
	    );
	  }
	}
	
	$data_to_render = new SinglePost;
	
	echo MustachePress::render('single', $data_to_render);

###Example template
<small>single.mustache</small>

	<p>we are rendering with {{template_engine}}</p>
	
	three colors
	<ul>
	  {{#colors}}
	    <li>{{color}}</li>
	  {{/colors}}
	</ul>


Using The Loop
--------------

There is one reserved word `posts_loop` that invokes the standard Wordpress loop (The Loop).

A standard use of The Loop

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	  <h2><?php the_title() ?></h2>
	  <?php the_content() ?>
	
	<?php endwhile; else : ?>
	
	  Sorry no posts
	
	<?php endif; ?>



MustachePress version

	{{#posts_loop}}
	
	  <h2>{{the_title}}</h2>
	  {{{the_content}}}
	
	{{/posts_loop}}
	{{^posts_loop}}
	
	  Sorry no posts
	
	{{/posts_loop}}


Template location
-----------------
By default mustachePress will look for all templates (including partials) in:

`wordpress_template_directory/views`

if that does not exist it will revert to

`wordpress_template_directory`

You can change this in settings.


Settings
--------
You can change any of the settings for the base [Mustache.php](https://github.com/bobthecow/mustache.php) engine like so

<small>functions.php</small>

	MustachePress::settings(array(
	  'loader' => new Mustache_Loader_FilesystemLoader( '/my/custom/path' ),
	  'partials_loader' => new Mustache_Loader_FilesystemLoader( '/my/custom/path' )
	));

For a complete list of options look at the [Constructor options](https://github.com/bobthecow/mustache.php/wiki#constructor-options) for Mustache.php

###Note
MustachePress has the [BLOCKS pragma](https://github.com/bobthecow/mustache.php/wiki/BLOCKS-pragma) enabled by default. This is because it is a convenient way of creating a site-wide layout template. this can of corse be turned off by changing the `pragmas` setting.

<br><br><br><br><br>

