<?php

class Member extends CI_Controller {
  public $user = null;

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    // object classes are needed to serialise the objects stored in session
    $this->load->file(APPPATH . 'objects/User.php'); 
    $this->load->file(APPPATH . 'objects/Course.php');
    $this->load->file(APPPATH . 'objects/Trail.php');
    $this->load->file(APPPATH . 'objects/Chapter.php');
    $this->load->file(APPPATH . 'objects/Term.php');
    $this->load->file(APPPATH . 'objects/Term_Comment.php');
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
}