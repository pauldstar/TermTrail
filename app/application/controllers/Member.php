<?php

class Member extends CI_Controller {
  public $user;

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    require_once APPPATH . 'objects/Revision.php';
    require_once APPPATH . 'objects/Chapter.php';
    require_once APPPATH . 'objects/Term.php';
    require_once APPPATH . 'objects/Term_comment.php';
    $this->load->library('session');
    if (isset($_SESSION['user']))
      $this->user = $_SESSION['user'];
    else redirect('login');
  }

  public function member() {
    $this->load->view('templates/header');
    $this->load->view('home/member');
    $this->load->view('templates/footer');
  }
  
  public function logout() {
    $_SESSION = array();
    $session_running = session_id() != "" || isset($_COOKIE[session_name()]);
    if ($session_running) {
      setcookie(session_name(), '', time() - 2592000, '/');
      session_destroy();
      header("Location: " . base_url('index.php/login'));
    } else
      show_error("You aren't logged in anyway mate!");
  }
}