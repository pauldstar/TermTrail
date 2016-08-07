<?php
include 'utils.php';

$site = new csite();

$index_page = new cpage("Welcome to my site!");
$content = "Welcome to my personal web site!";
$index_page->setContent($content);

$site->addHeader("header.html");
$site->setPage($index_page);
$site->addFooter("footer.html");
$site->render();