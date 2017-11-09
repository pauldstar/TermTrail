<?php
class Database_model extends CI_Model
{
  public function __construct()
	{
	  parent::__construct();
		$this->load->database();
    $this->load->config('db_tables', TRUE);
	}
}