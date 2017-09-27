<?php
class Gridbox_model extends MY_Model 
{
  public function get_gridbox_objects($section, $full_parent_id = '')
	{
		$this->load->model("{$section}_model", 'item_model');
		$func_get_session_items = "get_session_{$section}s";
		$items = $section === 'school' ? 
			self::$user->schools : $this->item_model->$func_get_session_items($full_parent_id);
		
		$is_universal = $full_parent_id === '' ?: FALSE;
		$var_item_title = $section === 'question' ? "content" : "{$section}_title";
		$var_item_type = "{$section}_type";
		$gridbox_objects = array();
		$params = array();
		
		foreach ($items as $index => $item)
		{
			$params['full_id'] = $item->get_full_id();
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
			
			$gridbox_objects[] = new Gridbox($params);
		}
		
		return $gridbox_objects;
	}
}