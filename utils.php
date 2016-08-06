<?php
// prevents having to constantly include files
function __autoload($class) {
	include "$class.php";
}

function initialise_site(csite $site) {
	$site->addHeader("header.php");
	$site->addFooter("footer.php");
}