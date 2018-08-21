<?php
class Component_model extends TL_Model 
{
	public function update_component_grid_positions(
		$component_type, $component_full_id, $from_index, $to_index)
	{
		if ($component_type !== 'chapter' && $component_type !== 'question')
			throw new Exception('The component model function "update_component_grid_positions" can only be used on Chapter and Question components.');
		
		$query_successful = self::update_db_component_grid_positions(
			$component_type, $component_full_id, $from_index, $to_index);
		
		if ($query_successful)
		{
			self::update_session_component_grid_positions(
				$component_type, $component_full_id, $from_index, $to_index);
			return TRUE;
		}
		
		return FALSE;
	}
	
	private function update_session_component_grid_positions(
		$component_type, $component_full_id, $from_index, $to_index)
	{
		$session_components = self::get_session_components($component_type, $component_full_id, TRUE);
		
		$from_position = $from_index + 1;
		$to_position = $to_index + 1;
		
		if ($from_index < $to_index)
		{
			foreach ($session_components as $component)
			{
			  if ($component->grid_position >= $from_position && 
						$component->grid_position <= $to_position)
				{
					if ($component->grid_position == $from_position) 
						$component->grid_position = $to_position;
					else $component->grid_position -= 1;
				}
			}
		}
		if ($from_index > $to_index)
		{
			foreach ($session_components as $component)
			{
			  if ($component->grid_position <= $from_position && 
						$component->grid_position >= $to_position)
				{
					if ($component->grid_position == $from_position) 
						$component->grid_position = $to_position;
					else $component->grid_position += 1;
				}
			}
		}
	}
	
	private function update_db_component_grid_positions(
		$component_type, $component_full_id, $from_index, $to_index)
	{
		$composition_position_full_id = array
		(
			'owner_id' => self::$user->user_id,
			'school_id' => $component_full_id['school_id'],
			'course_id' => $component_full_id['course_id'],
			'bank_id' => $component_full_id['bank_id'],
			'grid_position' => ''
		);
		
		if ($component_type == 'question') 
			$composition_position_full_id['chapter_id'] = $component_full_id['chapter_id'];

		$update_batch_query = '';
		
		while ($from_index < $to_index)
		{ // dragged down the grid
			$from_index++;
			$composition_position_full_id['grid_position'] = $from_index + 1;
			$this->db->set('grid_position', $from_index);
			$this->db->where($composition_position_full_id);
			$update_batch_query .= "{$this->db->get_compiled_update($component_type)}; ";
		}
		while ($from_index > $to_index)
		{ // dragged up the grid
			$composition_position_full_id['grid_position'] = $from_index;
			$this->db->set('grid_position', $from_index+1);
			$this->db->where($composition_position_full_id);
			$update_batch_query .= "{$this->db->get_compiled_update($component_type)}; ";
			$from_index--;
		}
		$component_full_id['owner_id'] = self::$user->user_id;
		$this->db->set('grid_position', $to_index+1);
		$this->db->where($component_full_id);
		$update_batch_query .= "{$this->db->get_compiled_update($component_type)};";
		
		return mysqli_multi_query($this->db->conn_id, $update_batch_query);
	}
	
	public function get_session_components(
		$component_type, $component_full_id = '', $update_session_components_mode = FALSE)
  {
		if ($update_session_components_mode === TRUE && 
			($component_type !== 'chapter' && $component_type !== 'question'))
			throw new Exception('The "$update_session_components_mode" in the model function "get_session_components" can only be set TRUE for Chapter and Question components.');

			if (empty($component_full_id)) return self::get_all_of_session_component_type($component_type);

		$components = NULL;
		
		if ($update_session_components_mode) 
		{
			switch ($component_type)
			{
				case 'chapter':
					$components =& self::$user->schools[$component_full_id['school_id']-1]->
						courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
						chapters;
					break;
				case 'question':	
					$components =& self::$user->schools[$component_full_id['school_id']-1]->
						courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
						chapters[$component_full_id['chapter_id']-1]->questions;
			}
			
			return $components;
		}

		switch ($component_type)
		{
			case 'course':
				$components = self::$user->schools[$component_full_id['school_id']-1]->courses;
				break;
			case 'bank':
				$components = self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks; 
				break;
			case 'chapter':
				$components = self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
					chapters;
				usort($components, array('Component_model', 'compare_component_grid_positions'));
				break;
			case 'question': 
				$components = self::$user->
					schools[$component_full_id['school_id']-1]->courses[$component_full_id['course_id']-1]->
					banks[$component_full_id['bank_id']-1]->chapters[$component_full_id['chapter_id']-1]->
					questions;
				usort($components, array('Component_model', 'compare_component_grid_positions'));
		}
		
		return $components;
  }
	
	private function compare_component_grid_positions($comp_a, $comp_b)
	{
		return ($comp_a->grid_position < $comp_b->grid_position) ? -1 : 1;
	}
	
	private function get_all_of_session_component_type($component_type)
	{
		$components = array();
		
		switch ($component_type)
		{
			case 'school':
				$components = self::$user->schools;
				break;
			case 'course':
				foreach (self::$user->schools as $school)
					foreach ($school->courses as $course) 
						$components[] = $course;
				break;
			case 'bank':
				foreach (self::$user->schools as $school)
					foreach ($school->courses as $course) 
						foreach ($course->banks as $bank)
							$components[] = $bank;
				break;
			case 'chapter':
				foreach (self::$user->schools as $school)
					foreach ($school->courses as $course) 
						foreach ($course->banks as $bank)
							foreach ($bank->chapters as $chapter)
								$components[] = $chapter;
				break;
			case 'question':
				foreach (self::$user->schools as $school)
					foreach ($school->courses as $course) 
						foreach ($course->banks as $bank)
							foreach ($bank->chapters as $chapter)
								foreach ($chapter->questions as $question)
									$components[] = $question;
		}
		
		return $components;
	}
	
	public function set_session_components($component_type = 'school')
	{
		$components = self::get_db_components($component_type, self::$user->user_id);
		
		if ( ! $components) return;

		foreach ($components as $component) 
		{
			switch ($component_type)
			{
				case 'school':
					self::$user->schools[] = $component;
					break;
				case 'course':
					self::$user->schools[$component->school_id-1]->courses[] = $component;
					break;
				case 'bank':
					self::$user->schools[$component->school_id-1]->courses[$component->course_id-1]->
						banks[] = $component;
					break;
				case 'chapter':
					self::$user->schools[$component->school_id-1]->courses[$component->course_id-1]->
						banks[$component->bank_id-1]->chapters[] = $component;
					break;
				case 'question':
					self::$user->schools[$component->school_id-1]->courses[$component->course_id-1]->
						banks[$component->bank_id-1]->chapters[$component->chapter_id-1]->
						questions[] = $component;
			}
		}
		
		self::set_child_component_session_components($component_type);
	}
	
	private function set_child_component_session_components($parent_component_type)
	{
		switch ($parent_component_type)
		{
			case 'school': 
				self::set_session_components('course'); 
				break;
			case 'course': 
				self::set_session_components('bank'); 
				break;
			case 'bank': 
				self::set_session_components('chapter'); 
				break;
			case 'chapter': 
				self::set_session_components('question');
		}
	}
	
	public function get_child_component_db_components(
		$child_component_type, $parent_component_full_id)
	{
		$query = $this->db->get_where($child_component_type, $parent_component_full_id);
    if ( ! $query) return NULL;
		$components = array();
		$component_object_ref = ucfirst($component_type);
		foreach ($query->result_array() as $row) $components[] = new $component_object_ref($row);
		return $components;
	}
	
	public function get_single_session_component($component_type, $component_full_id)
  {
		switch ($component_type)
		{
			case 'school':
				return self::$user->schools[$component_full_id['school_id']-1];
			case 'course':
				return self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1];
			case 'bank':
				return self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]; 
			case 'chapter':
				return self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
					chapters[$component_full_id['chapter_id']-1];
			case 'question':
				return self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
					chapters[$component_full_id['chapter_id']-1]->
					questions[$component_full_id['question_id']-1];
		}
  }
	
  public function get_db_components($component_type, $user_id = '')
  {
		$query_string = empty($user_id) ? "SELECT * FROM {$component_type}" :
			"SELECT * FROM {$component_type} WHERE owner_id='{$user_id}'";
    $query_result = $this->db->query($query_string);
		
    if ( ! isset($query_result)) return NULL;
		$components = array();
		$component_object_ref = ucfirst($component_type);
		foreach ($query_result->result_array() as $row) $components[] = new $component_object_ref($row);
		return $components;
  }
	
  public function set_and_get_component($component_type, $component_full_id)
  {
		$new_component_id = self::get_new_component_id($component_type, $component_full_id);
    $component_params = self::get_component_insert_db_params($component_type, $new_component_id);
		$query_successful = $this->db->insert($component_type, $component_params);
    if ( ! $query_successful) return NULL;
		$component_object_ref = ucfirst($component_type);
		return new $component_object_ref($component_params);
  }
	
	private function get_new_component_id($component_type)
	{
		switch ($component_type)
		{
			case 'school': 
				return 1 + sizeof(self::$user->schools);
				
			case 'course': 
				return 1 + sizeof(self::$user->schools[$component_full_id['school_id']-1]->courses);
				
			case 'bank': 
				return 1 + sizeof(self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks);
				
			case 'chapter': 
				return 1 + sizeof(self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
					chapters);
				
			case 'question':
				return 1 + sizeof(self::$user->schools[$component_full_id['school_id']-1]->
					courses[$component_full_id['course_id']-1]->banks[$component_full_id['bank_id']-1]->
					chapters[$component_full_id['chapter_id']-1]->questions);
		}
	}
	
	private function get_component_insert_db_params($component_type, $new_component_id)
	{
    $current_time = date_timestamp_get(date_create());
		
		switch($component_type)
		{
			case 'school': 
				return array
				( 
					'owner_id' => self::$user->user_id,
					'school_id' => $new_component_id,
					'school_title' => $this->input->post('school_title'),
					'scope' => $this->input->post('scope'),
					'school_type' => $this->input->post('school_type'),
					'education_level' => $this->input->post('education_level'),
					'time_added' => $current_time,
					'school_view_count' => 0
				);
			
			case 'course': 
				return array
				(
					'owner_id' => self::$user->user_id,
					'school_id' => $this->input->post('school_id'),
					'course_id' => $new_component_id,
					'course_title' => $this->input->post('course_title'),
					'scope' => $this->input->post('scope'),
					'course_type' => $this->input->post('course_type'),
					'category' => $this->input->post('category'),
					'time_added' => $current_time,
					'course_view_count' => 0
				);
			
			case 'bank':
				return array
				( 
					'owner_id' => self::$user->user_id,
					'school_id' => $this->input->post('school_id'), 
					'course_id' => $this->input->post('course_id'), 
					'bank_id' => $new_component_id,
					'bank_title' => $this->input->post('bank_title'),
					'scope' => $this->input->post('scope'),
					'time_added' => $current_time,
					'bank_type' => $this->input->post('bank_type'),
					'mode' => 'building',
					'bank_view_count' => 0
				);
			
			case 'chapter':
				return array
				( 
					'owner_id' => self::$user->user_id,
					'school_id' => $this->input->post('school_id'),
					'course_id' => $this->input->post('course_id'), 
					'bank_id' => $this->input->post('bank_id'), 
					'chapter_id' => $new_component_id, 
					'chapter_title' => $this->input->post('chapter_title'), 
					'grid_position' => $new_component_id
				);
			
			case 'question':
				return array
				(
					'owner_id' => self::$user->user_id, 
					'school_id' => $this->input->post('school_id'), 
					'course_id' => $this->input->post('course_id'), 
					'bank_id' => $this->input->post('bank_id'), 
					'chapter_id' => $this->input->post('chapter_id'), 
					'question_id' => $new_component_id, 
					'author_id' => $this->input->post('author_id'), 
					'grid_position' => $new_component_id,
					'question' => $this->input->post('question'), 
					'answer' => $this->input->post('answer'), 
					'hint' => $this->input->post('hint'), 
					'last_edit_time' => $current_time,
					'revision_state' => 'pending',
					'confidence_score' => 0
				);
		}
	}
}