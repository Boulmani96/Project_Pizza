<?php declare(strict_types=1);
require_once './Page.php';

class Baecker extends Page{

	protected function __construct(){
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    protected function generateView():void{
	    $ordered_article = $this->getViewData();
    	$this->generatePageHeader('Bäcker','Seite.css');
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
	  <section class="Bestellung">
		<header>
			<h1>Bäcker</h1>
		</header>
        <form id="myForm" action="Baecker.php" accept-charset="utf-8" method="POST">
EOT;
        $j = 1;
        for($row = 0; $row < count($ordered_article); $row++){
                $ordered_article_id = htmlspecialchars($ordered_article[$row][0]);
                $orderingID = htmlspecialchars($ordered_article[$row][1]);
                $articleID = htmlspecialchars($ordered_article[$row][2]);
                $status = htmlspecialchars($ordered_article[$row][3]);
                $Pizza="";
                switch ($articleID){
                    case 1:
                        $Pizza = "Salami";
                        break;
                    case 2:
                        $Pizza = "Hawaii";
                        break;
                    case 3:
                        $Pizza = "Margherita";
                        break;
                    default:
                        break;
                }

                $group = $ordered_article_id;
                $legend = "Bestellung ".$orderingID." - Pizza ".$Pizza;
                $legend = htmlspecialchars($legend);
                $this->insert_ordered_article($legend,$group,(int)$status);
                $j++;
        }

        echo <<<EOT
        </form>
        </section>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="Baecker.js"></script>
EOT;
    	$this->generatePageFooter();
    }

    protected function getViewData():array{
        $ordered_article = array(array());
        $sqlselect = "Select * from ordered_article where status='0' or status='1'";
        $result = $this->database->query($sqlselect);
        $i = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $ordered_article_id = $row["ordered_article_id"];
                $orderingID = $row["ordering_id"];
                $articleID = $row["article_id"];
                $status = $row["status"];

                $ordered_article[$i][0] = $ordered_article_id;
                $ordered_article[$i][1] = $orderingID;
                $ordered_article[$i][2] = $articleID;
                $ordered_article[$i][3] = $status;
                $i++;
            }
            $result->free();
        }
        return $ordered_article;
    }

    private function insert_ordered_article($legend, $group, $status){
	    switch ($status){
            case 0:
                echo "<fieldset class='fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
                     <input type='radio' name=$group id='bestellen_radio' value='Bestellen' onclick='myFunction(this)' checked></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
				<input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen' onclick='myFunction(this)'><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
            <input type='radio' name=$group id='fertig_radio' value='Fertig' onclick='myFunction(this)'></p>";
                echo "</fieldset>";
                break;
            case 1:
                echo "<fieldset class='fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
                <input type='radio' name=$group id='bestellen_radio' value='Bestellen' onclick='myFunction(this)'></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
                    <input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen' onclick='myFunction(this)' checked><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
                <input type='radio' name=$group id='fertig_radio' value='Fertig' onclick='myFunction(this)'></p>";
                echo "</fieldset>";
            break;
            case 2:
                echo "<fieldset class='fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
            <input type='radio' name=$group id='bestellen_radio' value='Bestellen' onclick='myFunction(this)'></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
				<input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen' onclick='myFunction(this)'><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
            <input type='radio' name=$group id='fertig_radio' value='Fertig' onclick='myFunction(this)' checked></p>";
                echo "</fieldset>";
            break;
            default:
                break;
        }
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData(); // TODO: Change the autogenerated stub
        if (isset($_POST['ordered_article_id']) && isset($_POST['status'])) {
            $status = -1;
            $ordered_article_id = $this->database->real_escape_string($_POST['ordered_article_id']); //ordered_article
            $value = $this->database->real_escape_string($_POST['status']);
            switch ($value){
                case 'Bestellen':
                    $status = 0;
                    break;
                case 'Im Ofen':
                    $status = 1;
                    break;
                case 'Fertig':
                    $status = 2;
                    break;
                default:
                    break;
            }
            if($status != -1) {
                $sql = "update ordered_article SET STATUS = ('$status') WHERE ordered_article_id = ('$ordered_article_id')";
                $this->database->query($sql);
            }
        }
    }

    public static function main():void{
        try {
	    $Baecker = new Baecker();
        $Baecker->processReceivedData();
        $Baecker->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Baecker::main();

