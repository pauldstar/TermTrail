<?php
class Dashboard extends CI_Controller 
{
  private static $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('user_model');
    self::$user = $this->user_model->get_user();
		if (empty(self::$user)) redirect('login');
  }

  public function dashboard()
  {
		$this->load->helper('url');
		$this->load->helper('html');
    $this->load->view('dashboard/header');
    $this->load->view('dashboard/navbar');
    $this->load->view('dashboard/sidebar');
    $this->load->view('dashboard/toolbar');
    $this->load->view('dashboard/page-content');
    $this->load->view('dashboard/popup');
    $this->load->view('dashboard/scripts');
    $this->load->view('dashboard/footer');
  }

	public function ajax_get_grid($section, $parent_id = '')
	{
		$this->load->model('gridbox_model');
		$gridbox_objects = $this->gridbox_model->get_gridbox_objects($section, $parent_id = '');
		
		foreach ($gridbox_objects as $gridbox)
		{
			$data['gridbox'] = $gridbox;
			$grid[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($grid);
	}
	
  public function logout()
  {
    $session_ended = $this->user_model->end_user_session();
		if ($session_ended) redirect('login');
		else show_error("You aren't logged in anyway mate!");
  }
}