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
        $myarticles = $this->getViewData();
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
EOT;
        if(!empty($myarticles)) {
            for ($row = 0; $row < count($myarticles); $row++) {
                if (isset($myarticles[$row][0]) && isset($myarticles[$row][1])
                    && isset($myarticles[$row][2]) && isset($myarticles[$row][3])) {
                        $article_ID = $myarticles[$row][0];
                        $name = $myarticles[$row][1];
                        $picture = $myarticles[$row][2];
                        $price = $myarticles[$row][3];

                        $this->insert_article($name, $picture, $price);
                }
            }
        }
        echo <<<EOT
        </div>
        <form action="Bestellung.php" accept-charset="utf-8" method="POST">
			<h2 class="Warenkorb">Warenkorb<span class="shopping_cart"><i class="material-icons">shopping_cart</i><span>
			</h2>
			<select class="mySelect" id="mySelect" name="mySelect[]" size="4" tabindex="-1" multiple required>
			
			</select>
			<div class="Preis">
				Gesamt Preis: <span id="gesamtpreis">0</span> €
			</div>
			<div class="input-container">
			    <span class="delivery_dining"><i class="material-icons" style="font-size: 30px;">delivery_dining</i></span>
			    <input class="input-field" type="text" name="Adresse" id="Adresse" placeholder="Ihre Adresse" tabindex="1" required 
			    onkeyup="stateHandle()">
 			</div>
 			<div class="myButtons">
				<input type="button" name="reset" value="Alle Löschen" tabindex="2" onclick="AllLoesche()"/>
				<input type="button" name="DeleteSelection" value="Auswahl löschen" tabindex="3" onclick="AuswahlLoeschen()"/>
				<input type="submit" name="submit" id="submit" value="Bestellen" tabindex="4" onclick="Check()" disabled/>
			</div>
		</form>
	  </section>
	  <script src="Bestellseite.js"></script>
EOT;
    	$this->generatePageFooter();
    }

    private function insert_article($name, $picture, $price){
	  	echo "<div class='column'>";
	  	echo "<input type='image' src=$picture id=$price name=$name alt='' tabindex='-1' onclick='onClick(this)'>";
		echo "<h3>$name</h3>";
		echo "<h3>$price €</h3>";
        echo "</div>";
    }

    protected function getViewData():array{
        $myArticles = array(array());
        $sqlSelect = "Select * from article";
        $result = $this->database->query($sqlSelect);
        if (!$result) throw new Exception("Fehler in Abfrage: ".$this->database->error);
        $i = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //var_dump($row);
                $myArticles[$i][0] = $row["article_id"];
                $myArticles[$i][1] = $row["name"];
                $myArticles[$i][2] = $row["picture"];
                $myArticles[$i][3] = $row["price"];
                $i++;
            }
            $result->free();
        }
        return $myArticles;
    }

	protected function processReceivedData():void 
    {
        $onceOnly = false;
        if(count($_POST)){
            parent::processReceivedData();
            if (isset($_POST['mySelect']) && isset($_POST['Adresse'])) {
                $address = $_POST['Adresse'];
                $mySelect = $_POST['mySelect'];

                $ordering_time = date("Y-m-d H:i:s");

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
                        case 'Vegetaria':
                            $theSelect = 'Vegetaria';
                            break;
                        case 'Spinat-Hühnchen':
                            $theSelect = 'Spinat-Hühnchen';
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
                    if($onceOnly == false){
                        $SQLabfrage = "INSERT INTO ordering VALUES (NULL,'$address','$ordering_time')";
                        $this->database->query($SQLabfrage);

                        $ordering_id = $this->database->insert_id; //Get the increment ordering_id
                       //SESSION
                        $_SESSION["BestellugnID"] = $ordering_id;
                        $onceOnly = true;
                    }

                    $SQLabfrage2 = "INSERT INTO ordered_article VALUES (NULL,'$ordering_id','$article_id',0)";
                    $this->database->query($SQLabfrage2);
                }
            }
            header("HTTP/1.1 303 See Other");
            header("Location:Kunde.php"); //Kunde
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
