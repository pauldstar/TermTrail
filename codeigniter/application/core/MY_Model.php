<?php
class MY_Model extends CI_Model 
{
  protected static $user;
	
	public function __construct()
  {
    parent::__construct();
    $this->load->database();
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH.'objects/User.php';
    require_once APPPATH.'objects/School.php';
    require_once APPPATH.'objects/Course.php';
    require_once APPPATH.'objects/Bank.php';
    require_once APPPATH.'objects/Revision.php';
    require_once APPPATH.'objects/Chapter.php';
    require_once APPPATH.'objects/Question.php';
    require_once APPPATH.'objects/Question_comment.php';
    require_once APPPATH.'objects/Gridbox.php';
		$this->load->library('session');
		self::$user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
  }
}