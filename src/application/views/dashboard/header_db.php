<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<!-- The above 3 meta tags *must* come first in the head -->
<!-- any other head content must come *after* these tags -->
<title>TermTrail
      <?php
      if (isset($_SESSION['user']))
      {
        $user = $_SESSION['user'];
        echo "($user->username)";
      }
      ?>
    </title>
    <?php
    $this->load->helper('html');
    echo link_tag('favicon.ico', 'shortcut icon', 'image/ico');
    // fonts
    echo link_tag('https://fonts.googleapis.com/css?family=Montserrat:400,700', 
        'stylesheet', 'text/css');
    // bootstrap css
    echo link_tag('bootstrap3/css/bootstrap.min.css', 'stylesheet');
    // my css
    echo link_tag('application/tt_style.css', 'stylesheet');
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
    echo "<script src=" . base_url('jquery3/jquery-3.1.1.min.js') . "></script>";
    // include all compiled plugins (below), or include individual files as needed
    echo "<script src=" . base_url('bootstrap3/js/bootstrap.min.js') . "></script>";
    ?>
  </head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li class="active">
          <a href="#">
            <?php echo '<img src='.base_url('images/tt_icon_black_with_bars.png').' alt="Menu"/>'; ?>
          </a>
        </li>
        <li>
          <a href="#">
            <?php echo '<img src='.base_url('images/inbox_icon_no_notification.png').' alt="Inbox"/>'; ?>
          </a>
        </li>
      </ul>
      <div class='navbar-header'>
      <a href="#">
        <img alt="TermTrail" src='<?php echo base_url('images/tt_logo_text_black.png'); ?>'>
      </a>
      </div>
      <form class="navbar-form navbar-right">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <!-- <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"
          role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul> -->
    </div>
  </nav>
  <div id="navbar-shadow"><!--navbar shadow (hangs behind the navbar)--></div>