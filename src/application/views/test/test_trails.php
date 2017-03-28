<h1>
<?php
echo "TRAILS";
?>
</h1>
<h2>
  <?php
  $this->load->helper('url');
  echo anchor('logout', 'Log out', 'title="Logging out now"');
  echo "</br></br><pre>";
  echo var_dump($trails);
  echo "</pre>";
  ?>
</h2>