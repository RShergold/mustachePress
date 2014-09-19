<?php

class MPPostsIterator implements Iterator {
  private $position;

  public function __construct() {
    $this->position = 0;
  }

  function rewind() {
    rewind_posts();
    $this->position = 0;
  }

  function current() {
    return the_post();
  }

  function key() {
    return $this->position;
  }

  function next() {
    $this->position++;
  }

  function valid() {
    return have_posts();
  }
}