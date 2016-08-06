<?php
include 'stdlib.php';

$site = new csite();

// this is a function specific to this site!
initialise_site($site);

$page = new cpage("Welcome to my site!");
$site->setPage($page);

$content = "Welcome to my personal web site!";
$page->setContent($content);

$site->render();