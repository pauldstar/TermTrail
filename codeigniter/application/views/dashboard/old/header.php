<?php
  $this->load->helper('html');
  $this->load->helper('url');
  ?>
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
    <?=link_tag('favicon.ico', 'shortcut icon', 'image/ico')?>
    <!-- fonts -->
    <?=link_tag('https://fonts.googleapis.com/css?family=Montserrat:400,700', 'stylesheet', 'text/css')?>
    <?=link_tag('https://fonts.googleapis.com/css?family=Lato:400,700,900', 'stylesheet', 'text/css')?>
    <!-- css -->
    <?=link_tag('bootstrap3/css/bootstrap.min.css', 'stylesheet')?>
    <?=link_tag('tt_style.css', 'stylesheet')?>
    <!-- HT5 shim and Respond.js for IE8 support of HT5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
    <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
    <?php
      // jquery (necessary for bootstrap's javascript plugins)
      echo "<script src=" . base_url('jquery3/jquery-3.1.1.min.js') . "></script>";
      // include all compiled plugins (below), or include individual files as needed
      echo "<script src=" . base_url('bootstrap3/js/bootstrap.min.js') . "></script>";
      ?>
  </head>
  <body class='bg-light-colour'>
    <nav class="navbar navbar-default bg-light-colour navbar-fixed-top">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
          <li class="active">
            <a id='side-menu-toggle' href="#">
            <?php echo '<img src='.base_url('images/menu_icon.png').' alt="Menu"/>'; ?>
            </a>
          </li>
          <li>
            <a href="#">
            <?php echo '<img src='.base_url('images/inbox_icon_no_notification.png').' alt="Inbox"/>'; ?>
            </a>
          </li>
        </ul>
        <a id='navbar-logo' class='dark-colour' href="#">TermTrail</a>
        <div id='navbar-search-bar-div'>
          <a class='dark-colour' href="#"><span class='glyphicon glyphicon-search'></span></a>
          <!-- <img src='<?php echo base_url('images/search_icon.png'); ?>' alt="search"/> -->
        </div>
      </div>
    </nav>
    <div id="navbar-shadow">
      <!--navbar shadow (hangs behind the navbar)-->
    </div>