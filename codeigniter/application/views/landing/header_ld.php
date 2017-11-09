<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<!-- The above 3 meta tags *must* come first in the head -->
<!-- any other head content must come *after* these tags -->
<title>TermTrail</title>
    <?php
      $this->load->helper('html');
      echo link_tag('favicon.ico', 'shortcut icon', 'image/ico');
      // fonts
      echo link_tag('https://fonts.googleapis.com/css?family=Montserrat:400,700', 
          'stylesheet', 'text/css');
      // bootstrap css
      echo link_tag('bootstrap3/css/bootstrap.min.css', 'stylesheet');
      // my css
      ?>
    <!-- HT5 shim and Respond.js for IE8 support of HT5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
    <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
    <?php
      $this->load->helper('url');
      // jquery (necessary for bootstrap's javascript plugins)
      echo "<script src=" . base_url('jquery/jquery3/jquery-3.1.1.min.js') . "></script>";
      // include all compiled plugins (below), or include individual files as needed
      echo "<script src=" . base_url('bootstrap3/js/bootstrap.min.js') . "></script>";
      ?>
  </head>
  <body>