<?php
class Gridbox_model extends TL_Model 
{
  public function get_gridbox_objects($grid_section, $grid_parent_full_id = '')
	{
		$this->load->model('component_model');
		$components = $this->component_model->
			get_session_components($grid_section, $grid_parent_full_id);
		
		$in_sidebar_menu_grid = $grid_parent_full_id === '' ?: FALSE;
		$component_title_var_ref = $grid_section === 'question' ? "question" : "{$grid_section}_title";
		$component_type_var_name = "{$grid_section}_type";
		$gridbox_objects = array();
		$gridbox_params = array();
		
		foreach ($components as $index => $component)
		{
			$gridbox_params['full_id'] = $component->get_full_id();
			$gridbox_params['section'] = $grid_section;
			$gridbox_params['in_sidebar_menu_grid'] = $in_sidebar_menu_grid;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = $component->$component_title_var_ref;
			
			if ($in_sidebar_menu_grid)
			{
				$gridbox_params['parent_label'] = 
					$grid_section === 'school' ? '' : $component->parent_label;
				$gridbox_params['parent_title'] = 
					$grid_section === 'school' ? '' : $component->get_parent_title(self::$user);
			}
			
			$gridbox_params['child_label'] = $grid_section === 'question' ? '' : $component->child_label;
			$gridbox_params['child_count'] 
				= $grid_section === 'question' ? '' : $component->get_child_count();
			$gridbox_params['subquestions'] = NULL;
			$gridbox_params['source_type'] = $component->$component_type_var_name;
			$gridbox_params['comment_count'] = $component->get_comment_count(self::$user);
			
			$gridbox_objects[] = new Gridbox($gridbox_params);
		}
		
		return $gridbox_objects;
	}
}