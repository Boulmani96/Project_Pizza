<?php declare(strict_types=1);
date_default_timezone_set('Europe/Berlin');
abstract class Page {
	protected MySQLi $database;

	protected function __construct(){
		error_reporting(E_ALL);
		require_once "pwd.php";
        $this->database = new MySQLi($host,$user,$pwd,$database);
		// check connection to database
        if (mysqli_connect_errno()) {
            throw new Exception("Keine Verbindung zur Datenbank: " . mysqli_connect_error());
        }
        // set character encoding to UTF-8
        if (!$this->database->set_charset("utf8")) {
            throw new Exception("Fehler beim Laden des Zeichensatzes UTF-8: " . $this->database->error);
        }
	}

	protected function __destruct(){
		$this->database->close();
	}

	protected function generatePageHeader(string $title='', string $cssName=''):void{
		$title = htmlspecialchars($title);
		// define MIME type of response (*before* all HTML):
        header("Content-type: text/html; charset=UTF-8");

        // output HTML header
        echo <<<EOT
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Original+Surfer&family=Zen+Dots&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href=$cssName>
	<title>$title</title>
</head>
<body>

EOT;
	}
	protected function generatePageFooter():void
    {
        echo <<<EOT
</body>
</html>

EOT;
    }

    protected function processReceivedData():void
    {

    }
}


?>