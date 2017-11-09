<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_table_constraints extends CI_Migration
{
	public function up()
	{
		$this->db->query("ALTER TABLE user ADD CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private'))");
		$this->db->query("ALTER TABLE user ADD CONSTRAINT has_notification_constraint CHECK(has_notification IN ('Y', 'N'))");
		
		$this->db->query("ALTER TABLE school ADD CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private'))");
		$this->db->query("ALTER TABLE school ADD CONSTRAINT school_type_constraint CHECK(school_type IN ('origin', 'import'))");
		$this->db->query("ALTER TABLE school ADD CONSTRAINT education_level_constraint CHECK(education_level IN ('primary', 'secondary', 'tertiary'))");
		
		$this->db->query("ALTER TABLE course ADD CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private'))");
		$this->db->query("ALTER TABLE course ADD CONSTRAINT course_type_constraint CHECK(course_type IN ('origin', 'import'))");
		
		$this->db->query("ALTER TABLE bank ADD CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private'))");
		$this->db->query("ALTER TABLE bank ADD CONSTRAINT mode_constraint CHECK(mode IN ('building', 'revision'))");
		$this->db->query("ALTER TABLE bank ADD CONSTRAINT bank_type_constraint CHECK(bank_type IN ('origin', 'import'))");
		
		$this->db->query("ALTER TABLE chapter ADD CONSTRAINT chapter_type_constraint CHECK(chapter_type IN ('origin', 'import'))");
		
		$this->db->query("ALTER TABLE question ADD CONSTRAINT revision_state_constraint CHECK(revision_state IN ('pending', 'done'))");
		$this->db->query("ALTER TABLE question ADD CONSTRAINT question_type_constraint CHECK(question_type IN ('origin', 'import'))");
	}

	public 	function down()
	{
		$this->db->query("ALTER TABLE users DROP CHECK scope_constraint");
		$this->db->query("ALTER TABLE users DROP CHECK has_notification_constraint");
		
		$this->db->query("ALTER TABLE school DROP CHECK scope_constraint");
		$this->db->query("ALTER TABLE school DROP CHECK school_type_constraint");
		$this->db->query("ALTER TABLE school DROP CHECK education_level_constraint");
		
		$this->db->query("ALTER TABLE course DROP CHECK scope_constraint");
		$this->db->query("ALTER TABLE course DROP CHECK course_type_constraint");
		
		$this->db->query("ALTER TABLE bank DROP CHECK scope_constraint");
		$this->db->query("ALTER TABLE bank DROP CHECK mode_constraint");
		$this->db->query("ALTER TABLE bank DROP CHECK bank_type_constraint");
		
		$this->db->query("ALTER TABLE chapter DROP CHECK chapter_type_constraint");
		
		$this->db->query("ALTER TABLE question DROP CHECK revision_state_constraint");
		$this->db->query("ALTER TABLE question DROP CHECK question_type_constraint");
	}
}