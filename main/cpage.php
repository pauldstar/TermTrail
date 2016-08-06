<?php
class cpage {
  private $title;
  private $content;

  public function __construct($title) {
    $this->title = $title;
  }

  public function __destruct() {
    // clean up here
  }
  
  // renders the title and content of the page
  public function render() {
    echo "<H1>{$this->title}</H1>";
    echo $this->content;
  }

  public function setContent($content) {
    $this->content = $content;
  }
}