<?php

class Database extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function create($table_name = '') {
    // later, add a passcode to prevent unauthorised database creation
    $this->load->config('database');
    $this->load->view('templates/header.php');
    // if table_name not specified, then create all tables
    if (empty($table_name)) {
      $db_tables = $this->config->config;
      foreach ($db_tables as $name => $structure)
        Database::create_table($name, $structure);
    } else
      Database::create_table($table_name, $this->config->item($table_name));
    $this->load->view('templates/footer.php');
  }

  public function delete($table_name = '') {
    $this->load->config('database');
    $this->load->view('templates/header.php');
    // if table_name not specified, then delete all tables
    if (empty($table_name)) {
      // retrieve array of table names and their structure in reverse order
      // so we drop tables in descending order of foreign key references
      // can't delete a table while it's referenced by another
      $db_tables = array_reverse($this->config->config);
      foreach ($db_tables as $name => $structure)
        Database::drop_table($name);
    } else
      Database::create_table($table_name, $this->config->item($table_name));
    $this->load->view('templates/footer.php');
  }

  private function create_table($name, $query) {
    $query_successful = $this->db->query(
        "CREATE TABLE IF NOT EXISTS $name($query) ENGINE InnoDB");
    if ($query_successful) {
      $data['name'] = $name;
      $this->load->view('setup/text_table_created', $data);
    } else
      show_error("Can't create table '$name'");
  }

  private function drop_table($name) {
    $query_successful = $this->db->query("DROP TABLE IF EXISTS $name");
    if ($query_successful) {
      $data['name'] = $name;
      $this->load->view('setup/text_table_dropped', $data);
    } else
      show_error("Can't drop table '$name'");
  }
}