<?php
class csite {
  private $header;
  private $footer;
  private $page;
  private $content_folder;

  public function __construct() {
    $this->content_folder = "content";
  }

  public function __destruct() {
    // clean up here
  }
  
  // converts the various disparate parts into a working HTML file
  public function render() {
    include $this->header;
    $this->page->render();
    include $this->footer;
  }
  
  // takes string containing file name of header file
  public function addHeader($file) {
    $this->header = "$this->content_folder/$file";
  }
  
  // takes string containing file name of footer file
  public function addFooter($file) {
    $this->footer = "$this->content_folder/$file";
  }

  public function setPage(cpage $page) {
    $this->page = $page;
  }
}