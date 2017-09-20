<?php

class Landing extends CI_Controller {

  public function __construct()
  {
    parent::__construct()
    $this->load->helper('url');
    $this->load->library('session');
  }

  public function login()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    // check user details validity, before allowing access
    if ($this->form_validation->run() === FALSE)
    {
      $data['login_title'] = 'Login';
      $this->load->view('landing/header_ld', $data);
      $this->load->view('landing/login');
      $this->load->view('landing/footer_ld');
    }
    else
    {
      $this->load->model('user_model');
      self::$user_model->setup_user_session();
      if (isset($_SESSION['user'])) redirect('test_body');
      else show_error("Invalid Username/Password");
    }
  }

  public function signup()
  {
    $this->load->library('form_validation');
    $this->load->model('user_model');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    // check user details validity, before allowing access
    if ($this->form_validation->run() === FALSE)
    {
      $data['signup_title'] = 'Sign Up';
      $this->load->view('landing/header_ld', $data);
      $this->load->view('landing/signup');
      $this->load->view('landing/footer_ld');
    }
    else
    {
      $_SESSION['user'] = self::$user_model->set_and_get_user();
      redirect('dashboard');
    }
  }
}