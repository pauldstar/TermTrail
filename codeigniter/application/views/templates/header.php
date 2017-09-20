<?php
  $this->load->helper('html');
  $this->load->helper('url');
	$user = $_SESSION['user'];
  ?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
	<title>TermTrail (<?=$user->username?>)</title>
	<link href="<?=base_url('favicon.ico')?>" rel="shortcut icon" type="image/x-icon">
</head>
<body>