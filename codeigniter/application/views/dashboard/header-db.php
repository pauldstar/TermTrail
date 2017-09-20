<?php
  $this->load->helper('html');
  $this->load->helper('url');
	$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com -->
<!--  Last Published: Fri Aug 25 2017 16:28:30 GMT+0000 (UTC)  -->
<html lang="en" data-wf-page="58d571d89f4cc9dc0580c1a9" data-wf-site="58d571d89f4cc9dc0580c1a8">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Webflow" name="generator">
  <!-- The first 3 meta tags *must* come first in the head -->
  <!-- any other head content must come *after* these tags -->
	<link href="<?=base_url('favicon.ico')?>" rel="shortcut icon" type="image/x-icon">
	<link href="<?=base_url('tt/tt-dashboard.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('bootstrap3/css/bootstrap.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('webflow/dashboard/css/webflow.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('webflow/dashboard/css/normalize.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('webflow/dashboard/css/tt-webflow.css')?>" rel="stylesheet" type="text/css">
  <title>TermTrail (<?=$user->username?>)</title>
</head>
<body class="body">