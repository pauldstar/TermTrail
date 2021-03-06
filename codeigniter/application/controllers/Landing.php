<?php
class Landing extends CI_Controller 
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
		$this->load->helper('html');
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
      $this->load->view('templates/header', $data);
      $this->load->view('landing/login');
      $this->load->view('templates/footer');
    }
    else
    {
      $this->load->model('user_model');
      $session_started = $this->user_model->set_session_user();
      if ($session_started) redirect('dashboard');
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
      $this->load->view('templates/header', $data);
      $this->load->view('landing/signup');
      $this->load->view('templates/footer');
    }
    else
    {
      $_SESSION['user'] = $this->user_model->set_and_get_user();
      redirect('dashboard');
    }
  }
}