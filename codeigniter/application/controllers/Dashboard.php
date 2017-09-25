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

  public function landing()
  {
    $this->load->view('landing/header_ld');
    $this->load->view('landing/index_ld');
    $this->load->view('landing/footer_ld');
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
	
  public function logout()
  {
    $session_ended = $this->user_model->end_user_session();
		if ($session_ended) redirect('login');
		else show_error("You aren't logged in anyway mate!");
  }

	public function ajax_get_grid($section, $parent_id = '')
	{
		$this->load->model("{$section}_model", 'item_model');
		$func_get_session_items = "get_session_{$section}s";
		$items = $section === 'school' ? 
			self::$user->schools : $this->item_model->$func_get_session_items($parent_id);
		
		$is_universal = $parent_id === '' ?: FALSE;
		$var_item_title = $section === 'question' ? "content" : "{$section}_title";
		$var_item_type = "{$section}_type";
		$grid = array();
		$params = array();
		
		foreach ($items as $index => $item)
		{
			$params['section'] = $section;
			$params['is_universal'] = $is_universal;
			$params['gridbox_number'] = $index + 1;
			$params['title'] = $item->$var_item_title;
			
			if ($is_universal)
			{
				$params['parent_label'] = $section === 'school' ? '' : $item->parent_label;
				$params['parent_title'] = $section === 'school' ? '' : $item->get_parent_title(self::$user);
			}
			
			$params['child_label'] = $item->child_label;
			$params['child_count'] = $item->get_child_count();
			$params['source_type'] = $item->$var_item_type;
			$params['comment_count'] = $item->get_comment_count(self::$user);
			
			$data['gridbox'] = new Gridbox($params);
			$grid[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($grid);
	}
}