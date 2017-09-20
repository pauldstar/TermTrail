<?php

class Database extends CI_Controller 
{
  public function __construct() 
	{
    parent::__construct();
    $this->load->database();
    $this->load->config('db_tables', TRUE);
    $this->load->library('session');
  }

  public function create_db() 
	{
    $this->load->view('templates/header.php');
    $db_tables = $this->config->item('db_tables');
		foreach ($db_tables as $name => $structure) Database::create_table($name, $structure);
    $this->load->view('templates/footer.php');
  }

  public function drop_db($drop_until_table = '') 
	{ //drop tables in descending order of foreign key dependencies
    $this->load->view('templates/header.php');
    $db_tables = array_reverse($this->config->item('db_tables'));
		foreach ($db_tables as $name => $structure)
		{
			Database::drop_table($name);
			if ($name === $drop_until_table) break;
		}
    $this->load->view('templates/footer.php');
  }

  private function create_table($name, $query) 
	{
    $query_successful = $this->db->query("CREATE TABLE IF NOT EXISTS $name($query) ENGINE InnoDB");
    if ($query_successful) 
		{
      $data['name'] = $name;
      $this->load->view('setup/text_table_created', $data);
    } 
		else show_error("Can't create table '$name'");
  }

  private function drop_table($name) 
	{
    $query_successful = $this->db->query("DROP TABLE IF EXISTS $name");
    if ($query_successful) 
		{
      $data['name'] = $name;
      $this->load->view('setup/text_table_dropped', $data);
    } 
		else show_error("Can't drop table '$name'");
  }
}