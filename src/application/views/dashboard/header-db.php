<?php
  $this->load->helper('html');
  $this->load->helper('url');
  ?>
<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com -->
<!--  Last Published: Fri Aug 25 2017 16:28:30 GMT+0000 (UTC)  -->
<html lang='en' data-wf-page="58d571d89f4cc9dc0580c1a9" data-wf-site="58d571d89f4cc9dc0580c1a8">
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <meta content="Webflow" name="generator">
  <!-- The above 3 meta tags *must* come first in the head -->
  <!-- any other head content must come *after* these tags -->
	<link href="<?=base_url('favicon.ico')?>" rel="shortcut icon" type="image/x-icon">
  <title>TermTrail
    <?php
        $user = $_SESSION['user'];
        echo "($user->username)";
    ?>
  </title>
  <!-- css -->
	<link href="<?=base_url('tt/tt-dashboard.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('bootstrap3/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('webflow/css/normalize.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('webflow/css/webflow.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('webflow/css/tt-webflow.css')?>" rel="stylesheet" type="text/css">
</head>
<body class="body">