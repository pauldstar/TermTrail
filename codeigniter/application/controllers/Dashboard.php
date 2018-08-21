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
		
		$data['user'] = self::$user;
		$data['page_title'] = 'dashboard';
		
    $this->load->view('dashboard/header', $data);
    $this->load->view('dashboard/navbar', $data);
    $this->load->view('dashboard/sidebar');
    $this->load->view('dashboard/toolbar');
    $this->load->view('dashboard/page-content');
    $this->load->view('dashboard/popup');
    $this->load->view('dashboard/scripts', $data);
    $this->load->view('dashboard/footer');
  }

	public function ajax_get_grid_views($grid_section, $grid_source)
	{
		$grid_parent_full_id = Dashboard::get_gridbox_full_id();
		
		$grid_data_objects = NULL;
		
		switch ($grid_source)
		{
			case 'local':
				$this->load->model('component_model');
				$grid_data_objects = $this->component_model->
					get_session_components($grid_section, $grid_parent_full_id);
				break;
			
			case 'universal':
				switch($grid_section)
				{
					case 'user':
						$this->load->model('user_model');
						$grid_data_objects = $this->user_model->get_all_users();
						break;
					
					default:
						$this->load->model('component_model');
						$grid_data_objects = $this->component_model->get_db_components($grid_section);
				}
		}
		
		$this->load->model('gridbox_model');
		$gridbox_objects = $this->gridbox_model->
			get_gridbox_objects($grid_section, $grid_source, $grid_data_objects, $grid_parent_full_id);
		$grid_views = array();
		
		foreach ($gridbox_objects as $gridbox)
		{
			$data['gridbox'] = $gridbox;
			$grid_views[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($grid_views);
	}
	
	private function get_gridbox_full_id()
	{
		$gridbox_full_id_json = $this->input->post('grid_box_full_json_id');
		$decoded_2d_array = json_decode($gridbox_full_id_json, TRUE);
		return empty($decoded_2d_array) ? '' : $decoded_2d_array[0];
	}
	
	public function ajax_get_question_tab_popup_view()
	{
		$grid_parent_full_id = Dashboard::get_gridbox_full_id();
		
		$this->load->model('component_model');
		$data['question'] = $this->component_model->
			get_single_session_component('question', $grid_parent_full_id);
		$popupView = $this->load->view('dashboard/popup-question-tabs', $data, TRUE);
		
		echo json_encode($popupView);
	}
	
	public function ajax_move_gridbox($grid_section, $from_index, $to_index)
	{
		$gridbox_full_id = Dashboard::get_gridbox_full_id();
		
		$this->load->model('component_model');
		$update_is_successsful = $this->component_model->
			update_component_grid_positions($grid_section, $gridbox_full_id, $from_index, $to_index);
		
		echo json_encode($update_is_successsful);
	}
	
  public function logout()
  {
    $session_ended = $this->user_model->end_user_session();
		if ($session_ended) redirect('login');
		else show_error("You're not logged in anyway mate!");
  }
}