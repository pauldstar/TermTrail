<?php
class Timer {
  var $classname = "Timer";
  var $start = 0;
  var $stop = 0;
  var $elapsed = 0;
  
  // Constructor
  public function __construct($start = true) {
    if ($start)
      $this->start();
  }
  
  // Start counting time
  public function start() {
    $this->start = $this->_gettime();
  }
  
  // Stop counting time
  public function stop() {
    $this->stop = $this->_gettime();
    $this->elapsed = $this->_compute();
  }
  
  // Get Elapsed Time
  public function elapsed() {
    if (! $elapsed)
      $this->stop();
    
    return $this->elapsed;
  }
  
  // Get Elapsed Time
  public function reset() {
    $this->start = 0;
    $this->stop = 0;
    $this->elapsed = 0;
  }
  
  // Get Current Time
  private function _gettime() {
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    return $mtime [1] + $mtime [0];
  }
  
  // Compute elapsed time
  private function _compute() {
    return $this->stop - $this->start;
  }
}