<h1>
<?php
$user = $_SESSION["user"];
echo "Hi $user->username";
?>
</h1>
<h2>
  <?php
  $this->load->helper('url');
  echo anchor('logout', 'Log out', 'title="Logging out now"');
  echo "</br></br><pre>";
  echo var_dump($user);
  echo "</pre>";
  ?>
</h2>