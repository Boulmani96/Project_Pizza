<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
$host = "localhost";
/********************************************/
// This code switches from the local installation (XAMPP) to the docker installation
if (gethostbyname('mariadb') != "mariadb") { // mariadb is known?
	$host = "mariadb";
}
$database = "pizzaservice";
$user = "public";
$pwd = "public";