<h1>
<?php 
$user = $_SESSION["user"];
echo "Hi $user->username</br>";
echo "<pre>";
echo var_dump($user);
echo "</pre>";
?>
</h1>
<h2>
<?php
$this->load->helper('url');
echo anchor('home/logout', 'Log out', 'title="Logging out now"');
?>
</h2>