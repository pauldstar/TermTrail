<?php

class Gridbox
{
	public $section; // school, course, bank, chapter, question
	public $section_type; // universal, specific
	public $gridbox_number;
	public $title; // also holds gridbox question
	
	// for gridbox in general section type (except schools) 
	public $parent_label, $parent_name;
	
	// for all sections except questions
	public $child_label, $child_count; 
	
	public $source_type; // origin, import
	public $comment_count;
	
	// for questions only
	public $subquestions;
	
	// for currently accessed item
	public $item_name, $item;

  public function __construct($item_name, $section_type, $item, $item_number)
  {
		$this->item_name = $item_name;
		$this->item = $item;
		$this->section = $item_name;
		$this->section_type = $section_type;
		$this->gridbox_number = $item_number;
		$this->title = self::get_item_title();
		$this->parent_label = self::get_item_parent_label();
		$this->parent_name = self::get_item_parent_name();
		$this->child_label = self::get_item_child_label();
		$this->child_count = self::get_item_child_count();
		$this->source_type = self::get_item_type();
		$this->comment_count = 0;
		
		
			self::$user->schools[$bank->school_id - 1]->courses[$bank->course_id - 1]->course_title;
		
		
		$this->section = $params['section'];
		$this->section_type = $params['section_type'];
		$this->gridbox_number = $params['gridbox_number'];
		$this->title = $params['title'];
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