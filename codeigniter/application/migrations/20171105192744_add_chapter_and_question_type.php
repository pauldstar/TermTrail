<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_chapter_and_question_type extends CI_Migration
{
	public function up()
	{
		$fields = array('chapter_type' => 
			array('type' => 'CHAR(6) NOT NULL', 'after' => 'chapter_position'));
		$this->dbforge->add_column('chapter', $fields);
		
		$fields = array('question_type' => 
			array('type' => 'CHAR(6) NOT NULL', 'after' => 'question_position'));
		$this->dbforge->add_column('question', $fields);
	}

	public 	function down()
	{
		$this->dbforge->drop_column('chapter', 'chapter_type');
		$this->dbforge->drop_column('question', 'question_type');
	}
}