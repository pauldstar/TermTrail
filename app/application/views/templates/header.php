<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>TermTrail
<?php
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  echo "($user->username)";
}
?>
</title>
<?php
$this->load->helper('html');
echo link_tag('favicon.ico', 'shortcut icon', 'image/ico');
?>
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700'
	rel='stylesheet' type='text/css'>
<!-- Bootstrap CSS -->
<link href='css/bootstrap.min.css' rel='stylesheet'>
<!-- My CSS -->
<link href='css/my_style.css' rel='stylesheet'>
<!-- HT5 shim and Respond.js for IE8 support of HT5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
      <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script
	src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'>
</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='js/bootstrap.min.js'></script>

</head>
<body>