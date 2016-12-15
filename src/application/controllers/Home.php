<?php

class Home extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
  }

  public function login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    // check user details validity, before allowing access
    if ($this->form_validation->run() === FALSE) {
      $data['login_title'] = 'Login';
      $this->load->view('templates/header', $data);
      $this->load->view('home/login');
      $this->load->view('templates/footer');
    } else {
      $this->load->model('user_model');
      $this->user_model->get_main_user();
      if (isset($_SESSION['user']))
        redirect('member');
      else show_error("Invalid Username/Password");
    }
  }

  public function signup() {
    $this->load->library('form_validation');
    $this->load->model('user_model');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    // check user details validity, before allowing access
    if ($this->form_validation->run() === FALSE) {
      $data['signup_title'] = 'Sign Up';
      $this->load->view('templates/header', $data);
      $this->load->view('home/signup');
      $this->load->view('templates/footer');
    } else {
      $_SESSION['user'] = $this->user_model->set_and_get_user();
      redirect('member');
    }
  }
}