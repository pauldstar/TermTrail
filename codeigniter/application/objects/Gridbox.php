<?php

class Gridbox
{
	public $section; // schools, courses, banks, chapters, questions
	public $section_type; // universal, specific
	public $heading;
	public $parent_label; 
	public $parent_name; 
	public $child_label;
	public $child_count; 
	public $source_type; // origin, import
	public $comment_count;
	public $subquestions = array(); // for questions only

  public function __construct()
  {
    $this->section = $params['section'];
		$this->section_type = $params['section_type'];
				$this->heading = $params['heading'];
				$this->comment_count = $params['comment_count'];
		switch ($params['section'])
		{
			case 'questions':
				$this->subquestions = $params['subquestions'];
				break;
			default:
				$this->child_label = $params['child_label'];
				$this->child_count = $params['child_count'];
				$this->source_type = $params['source_type'];
		}
		if ($this->section_type == 'general')
		{
			$this->parent_label = $params['parent_label']; 
			$this->parent_name = $params['parent_name'];
		}
  }
}