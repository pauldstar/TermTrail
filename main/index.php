<?php
include 'utils.php';

$site = new csite();

// this is a function specific to this site!
initialise_site($site);

$index_page = new cpage("Welcome to my site!");
$content = "Welcome to my personal web site!";
$index_page->setContent($content);

$site->setPage($index_page);
$site->addHeader("layout/header.html");
$site->addFooter("layout/footer.html");

$site->render();