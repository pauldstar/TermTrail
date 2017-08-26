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
  <?=link_tag('favicon.ico', 'shortcut icon', 'image/ico')?>
  <title>TermTrail
    <?php
      if (isset($_SESSION['user']))
      {
        $user = $_SESSION['user'];
        echo "($user->username)";
      }
    ?>
  </title>
  <!-- css -->
  <?=link_tag('tt_style.css', 'stylesheet', 'text/css')?>
  <?=link_tag('bootstrap3/css/bootstrap.min.css', 'stylesheet', 'text/css')?>
  <?=link_tag('webflow/css/normalize.css', 'stylesheet', 'text/css')?>
  <?=link_tag('webflow/css/webflow.css', 'stylesheet', 'text/css')?>
  <?=link_tag('webflow/css/tt-webflow.css', 'stylesheet', 'text/css')?>
  <!-- HT5 shim and Respond.js for IE8 support of HT5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
  <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js'></script>
  <![endif]-->
  <!-- jquery (necessary for bootstrap's javascript plugins) -->
  <script src='<?=base_url("jquery3/jquery-3.1.1.min.js")?>'></script>;
  <!-- include all compiled plugins (below), or include individual files as needed -->
  <script src='<?=base_url("bootstrap3/js/bootstrap.min.js")?>'></script>;
	<!-- fonts -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">
    WebFont.load({
    	google: {
    		families: [
    			"Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic",
    			"Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic",
    			"Francois One:regular:latin-ext,vietnamese,latin","Arimo:regular,italic,700,700italic"
    		]
    	}
    });
  </script>
  <script type="text/javascript">
    ! function(o, c)
    {
    	var n = c.documentElement,
    		t = " w-mod-";
    	n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
    }(window, document);
  </script>
</head>
<body class="body">