<?php

class Gridbox
{
	public $full_id;
	public $section; // school, course, bank, chapter, question
	public $grid_source; // local, universal
	public $evoked_from_sidebar_menu;
	public $gridbox_number;
	public $title; // also holds gridbox question
	
	// for gridbox in general section type (except schools) 
	public $parent_label;
	public $parent_title;
	
	// for all sections except questions
	public $child_label;
	public $child_count; 
	
	public $source_type; // origin, import
	public $comment_count;
	
	// for questions only
	public $subquestions;
	
  public function __construct($params)
  {
		$this->section = $params['section'];
		$this->gridbox_number = $params['gridbox_number'];
		$this->grid_source = $params['grid_source'];
		
		switch ($this->section)
		{
			case 'user':
				$this->title = $params['username'];
				break;
			
			default:
				$this->full_id = $params['full_id'];
				$this->evoked_from_sidebar_menu = $params['evoked_from_sidebar_menu'];
				$this->title = $params['title'];
				$this->comment_count = $params['comment_count'];
				$this->source_type = $params['source_type'];
				
				switch ($params['section'])
				{
					case 'question':
						$this->subquestions = $params['subquestions'];
						break;
					default:
						$this->child_label = $params['child_label'];
						$this->child_count = $params['child_count'];
				}
				
				if ($this->evoked_from_sidebar_menu)
				{
					$this->parent_label = $params['parent_label']; 
					$this->parent_title = $params['parent_title'];
				}
		}
  }
}