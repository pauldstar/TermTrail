<?php
class Gridbox_model extends TL_Model 
{
  public function get_gridbox_objects(
		$grid_section, $grid_source, $grid_data_objects, $grid_parent_full_id = '')
	{
		switch ($grid_section)
		{
			case 'user': return self::get_user_gridbox_objects($grid_data_objects);
			
			default: return self::get_component_gridbox_objects(
				$grid_section, $grid_source, $grid_data_objects, $grid_parent_full_id);
		}
	}
	
	private function get_user_gridbox_objects($user_objects)
	{
		$gridbox_objects = array();
		$gridbox_params = array();
		
		foreach ($user_objects as $index => $user)
		{
			$gridbox_params['section'] = 'user';
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['username'] = $user->username;
			$gridbox_params['grid_source'] = 'universal';
			
			$gridbox_objects[] = new Gridbox($gridbox_params);
		}
		
		return $gridbox_objects;
	}
	
	private function get_component_gridbox_objects(
		$grid_section, $grid_source, $component_objects, $grid_parent_full_id = '')
	{
		$evoked_from_sidebar_menu = $grid_parent_full_id === '' ?: FALSE;
		
		$component_title_var_ref = $grid_section === 'question' ? 
			'question' : "{$grid_section}_title";
		
		$component_type_var_ref = "{$grid_section}_type";
		
		$gridbox_objects = array();
		$gridbox_params = array();
		
		foreach ($component_objects as $index => $component)
		{
			$gridbox_params['full_id'] = $component->get_full_id();
			$gridbox_params['section'] = $grid_section;
			$gridbox_params['evoked_from_sidebar_menu'] = $evoked_from_sidebar_menu;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = $component->$component_title_var_ref;
			$gridbox_params['grid_source'] = $grid_source;
			
			switch($grid_source)
			{
				case 'local':
				{
					if ($evoked_from_sidebar_menu)
					{
						$gridbox_params['parent_label'] = $grid_section === 'school' ? 
							'' : $component->parent_label;
						$gridbox_params['parent_title'] = $grid_section === 'school' ? 
							'' : $component->get_parent_title(self::$user);
					}
					
					$gridbox_params['child_label'] = $grid_section === 'question' ? 
						'' : $component->child_label;
					$gridbox_params['child_count'] = $grid_section === 'question' ? 
						'' : $component->get_child_count();
					
					$gridbox_params['subquestions'] = NULL;
					$gridbox_params['source_type'] = $component->$component_type_var_ref;
					$gridbox_params['comment_count'] = 
						$component->get_comment_count(self::$user);
					
					$gridbox_objects[] = new Gridbox($gridbox_params);
					break;
				}
				
				case 'universal':
				{
					$gridbox_params['parent_label'] = '';
					$gridbox_params['parent_title'] = '';
					$gridbox_params['child_label'] = '';
					$gridbox_params['child_count'] = 0;
					$gridbox_params['subquestions'] = NULL;
					$gridbox_params['source_type'] = $component->$component_type_var_ref;
					$gridbox_params['comment_count'] = 0;
					
					$gridbox_objects[] = new Gridbox($gridbox_params);
				}
			}
		}
		
		return $gridbox_objects;
	}
}