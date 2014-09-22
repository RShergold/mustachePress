<?php

class MPPostsIterator implements Iterator {
  private $position,
    $WP_Query;

  public function __construct($WP_Query = false) {
    $this->position = 0;
    $this->WP_Query = $WP_Query;
  }

  function rewind() {
    if ($this->WP_Query){
      $this->WP_Query->rewind_posts();
    } else {
      rewind_posts();
    }
    $this->position = 0;
  }

  function current() {
    return ($this->WP_Query) ? $this->WP_Query->the_post() : the_post();
  }

  function key() {
    return $this->position;
  }

  function next() {
    $this->position++;
  }

  function valid() {
    if (!$this->WP_Query) {

      return have_posts();

    } elseif ($this->WP_Query->have_posts()){

      return true;

    } else {

      wp_reset_postdata();
      return false;

    }
  }


}