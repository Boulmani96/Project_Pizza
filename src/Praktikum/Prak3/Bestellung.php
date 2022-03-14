<?php declare(strict_types=1);
session_start();
require_once './Page.php';
class Bestellung extends Page{

	protected function __construct(){
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function generateView():void{
    	$this->generatePageHeader('Bestellseite', 'Bestellseite.css');
    	echo <<<EOT
    		<nav>
			<label class="logo">Alfredo</label>
			    <ul>
			      <li><a href="Bestellung.php">Bestellung</a></li>
			      <li><a href="Kunde.php">Kunde</a></li>
			      <li><a href="Baecker.php">Bäcker</a></li>
			      <li><a href="Fahrer.php">Fahrer</a></li>
			    </ul>
			</div>
	  </nav>
	  <section>
	  	<h2 class="title">Speisekarte</h2>
	  	<div class="row">
	  		<div class="column">
				<input type="image" src="Margherita.jpg" id="4.00" name="Margherita" alt="" width="100px" height=auto 
					tabindex="-1" onclick="onClick(this)">
				<h3>Margherita</h3> 
				<h3> 4.00 €</h3>
			</div>
			<div class="column">
				<input type="image" src="salami.jpg" id="4.50" name="Salami" alt="" width="100px" height=auto 
				    tabindex="-1" onclick="onClick(this)">
				<h3>Salami</h3> 
				<h3> 4.50 €</h3>
			</div>
			<div class="column">
				<input type="image" src="Hawaii.jpg" id="5.50" name="Hawaii" alt="" width="100px" height=auto
				        tabindex="-1" onclick="onClick(this)">
				<h3>Hawaii</h3> 
				<h3> 5.50 €</h3>
			</div>
		</div>
		<form action="Bestellung.php" accept-charset="utf-8" method="POST">
			<h2 class="Warenkorb">Warenkorb<span class="shopping_cart"><i class="material-icons">shopping_cart</i><span>
			</h2>
			<select class="mySelect" id="mySelect" name="mySelect[]" size="4" tabindex="-1" multiple required>
			
			</select>
			<div class="Preis">
				Gesamt Preis: <span id="gesamtpreis" name="gesamtpreis">0</span> €
			</div>
			<div class="input-container">
			    <span class="delivery_dining"><i class="material-icons" style="font-size: 30px;">delivery_dining</i></span>
			    <input class="input-field" type="text" name="Adresse" id="Adresse" placeholder="Ihre Adresse" tabindex="1" required>
 			</div>
 			<div class="myButtons">
				<input type="button" name="reset" value="Alle Löschen" tabindex="2" onclick="AllLoesche()"/>
				<input type="button" name="DeleteSelection" value="Auswahl löschen" tabindex="3" onclick="AuswahlLoeschen()"/>
				<input type="submit" name="submit" value="Bestellen" tabindex="4" onclick="Check()"/>
			</div>
		</form>
	  </section>
	  <script src="Bestellseite.js"></script>
EOT;
    	$this->generatePageFooter();
    }

	protected function processReceivedData():void 
    {
        $onceonly = false;
        if(count($_POST)){
            parent::processReceivedData();
            if (isset($_POST['mySelect']) && isset($_POST['Adresse'])) {
                $adress = $_POST['Adresse'];
                $mySelect = $_POST['mySelect'];

                $ordering_time= date("Y-m-d H:i:s");

                foreach ($mySelect as $selectedOption){
                    $theSelect ='';
                    switch ($selectedOption) {
                        case 'Salami':
                            $theSelect = 'Salami';
                            break;
                        case 'Hawaii':
                            $theSelect = 'Hawaii';
                            break;
                        case 'Margherita':
                            $theSelect = 'Margherita';
                            break;
                        default:
                            break;
                    }
                    $sqlselect1 = "SELECT article_id from article where name='".$theSelect."'";
                    $result = $this->database->query($sqlselect1);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $article_id = $row["article_id"];
                    }
                    if($onceonly == false){
                        $SQLabfrage = "INSERT INTO ordering VALUES (NULL,'$adress','$ordering_time')";
                        $this->database->query($SQLabfrage);

                        $ordering_id = $this->database->insert_id; //Get the increment ordering_id
                       //SESSION
                        $_SESSION["BestellugnID"] = $ordering_id;
                        $onceonly = true;
                    }

                    $SQLabfrage2 = "INSERT INTO ordered_article VALUES (NULL,'$ordering_id','$article_id',0)";
                    $this->database->query($SQLabfrage2);
                }
            }
            header("HTTP/1.1 303 See Other");
            header("Location: ". 'Kunde.php'); //Kunde
            die(); // hierausnahmsweiseok !
        }
    }

    public static function main():void
    {
        try {
            $page = new Bestellung();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Bestellung::main();  //Aufruf der static main Funktion
