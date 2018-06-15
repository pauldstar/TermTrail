<?php
class Gridbox_model extends MY_Model 
{
  public function get_gridbox_objects($section, $grid_parent_full_id = '')
	{
		$this->load->model("{$section}_model", 'item_model');
		$get_session_items_func_name = "get_session_{$section}s";
		$items = $section === 'school' ? 
			self::$user->schools : $this->item_model->$get_session_items_func_name($grid_parent_full_id);
		
		$is_universal = $grid_parent_full_id === '' ?: FALSE;
		$item_title_var_name = $section === 'question' ? "question" : "{$section}_title";
		$item_type_var_name = "{$section}_type";
		$gridbox_objects = array();
		$gridbox_params = array();
		
		foreach ($items as $index => $item)
		{
			$gridbox_params['full_id'] = $item->get_full_id();
			$gridbox_params['section'] = $section;
			$gridbox_params['is_universal'] = $is_universal;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = $item->$item_title_var_name;
			
			if ($is_universal)
			{
				$gridbox_params['parent_label'] = $section === 'school' ? '' : $item->parent_label;
				$gridbox_params['parent_title'] = 
					$section === 'school' ? '' : $item->get_parent_title(self::$user);
			}
			
			$gridbox_params['child_label'] = $section === 'question' ? '' : $item->child_label;
			$gridbox_params['child_count'] = $section === 'question' ? '' : $item->get_child_count();
			$gridbox_params['subquestions'] = NULL;
			$gridbox_params['source_type'] = $item->$item_type_var_name;
			$gridbox_params['comment_count'] = $item->get_comment_count(self::$user);
			
			$gridbox_objects[] = new Gridbox($gridbox_params);
		}
		
		return $gridbox_objects;
	}
}