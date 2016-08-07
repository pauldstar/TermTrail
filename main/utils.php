<?php
// prevents having to constantly include files
// using an anonymous function
spl_autoload_register(function ($class) {
  include "$class.php";
});