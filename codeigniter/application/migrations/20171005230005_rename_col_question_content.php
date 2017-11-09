<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_rename_col_question_content extends CI_Migration
{
	public function up()
	{
		$fields = array('content' => array('name' => 'question', 'type' => 'TEXT NOT NULL'));
		$this->dbforge->modify_column('question', $fields);
	}

	public 	function down()
	{
		$fields = array('question' => array('name' => 'content', 'type' => 'TEXT NOT NULL'));
		$this->dbforge->modify_column('question', $fields);
	}
}