<h1>
  <?php
  $this->load->model('user_model');
  $user = $_SESSION["user"];
  echo "Hi $user->username";
  ?>
</h1>
<h2>
  <?php
  $this->load->helper('url');
  echo anchor('home/logout', 'Log out', 'title="Logging out now"');
  echo "</br></br><pre>";
  echo var_dump($user);
  echo "</pre>";
  ?>
</h2>