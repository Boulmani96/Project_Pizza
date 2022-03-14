<?php declare(strict_types=1);
session_start();
require_once './Page.php';

class Kunde extends Page
{
    protected function __construct(){
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    protected function generateView():void{
        $this->generatePageHeader('Kunde','Seite.css');
        $ordered_article = $this->getViewData();
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
			<h1>Kunde</h1>
		</header>
EOT;
        $j = 1;
        if(count($ordered_article) > 0 && isset($_SESSION["BestellugnID"])) {
            for ($row = 0; $row < count($ordered_article); $row++) {
                $orderingID = htmlspecialchars($ordered_article[$row][0]);
                $articleID = htmlspecialchars($ordered_article[$row][1]);
                $status = htmlspecialchars($ordered_article[$row][2]);
                $Pizza = "";
                switch ($articleID) {
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
                $group = "group" . $j;
                //var_dump($group);
                $legend = "Bestellung " . $orderingID . " - Pizza " . $Pizza;
                $legend = htmlspecialchars($legend);
                $this->insert_ordered_article("fieldset", $legend, $group, (int)$status);
                $j++;
            }
        }
        echo <<<EOT
        </section>
EOT;
        $this->generatePageFooter();
    }

    protected function getViewData():array
    {
        $ordered_article = array(array());
        if (isset($_SESSION["BestellugnID"])) {
            $orderingID = $_SESSION["BestellugnID"];
            //var_dump($orderingID);
            $sqlselect = "Select * from ordered_article where ordering_id='" . $orderingID . "'";
            $result = $this->database->query($sqlselect);
            $i = 0;
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $orderingID = $row["ordering_id"];
                    $articleID = $row["article_id"];
                    $status = $row["status"];
                    $ordered_article[$i][0] = $orderingID;
                    $ordered_article[$i][1] = $articleID;
                    $ordered_article[$i][2] = $status;
                    $i++;
                }
                $result->free();
            }
        }
        return $ordered_article;
    }

    private function insert_ordered_article(string $fieldset, string $legend, string $group, int $status){
        switch ($status){
            case 0:
                echo "<fieldset class='$fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
                     <input type='radio' name=$group id='bestellen_radio' value='Bestellen' checked></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
				<input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen'><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
                     <input type='radio' name=$group id='fertig_radio' value='Fertig'></p>";

                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$group id='unterwegs_radio' value='Unterwegs'></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
                     <input type='radio' name=$group id='geliefert_radio' value='Geliefert'></p>";
                echo "</fieldset>";
                break;
            case 1:
                echo "<fieldset class='$fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
                <input type='radio' name=$group id='bestellen_radio' value='Bestellen' ></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
                    <input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen' checked><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
                <input type='radio' name=$group id='fertig_radio' value='Fertig'></p>";

                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$group id='unterwegs_radio' value='Unterwegs'></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
                     <input type='radio' name=$group id='geliefert_radio' value='Geliefert'></p>";
                echo "</fieldset>";
                break;
            case 2:
                echo "<fieldset class='$fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
            <input type='radio' name=$group id='bestellen_radio' value='Bestellen' ></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
				<input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen'><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
            <input type='radio' name=$group id='fertig_radio' value='Fertig' checked></p>";

                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$group id='unterwegs_radio' value='Unterwegs'></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
                     <input type='radio' name=$group id='geliefert_radio' value='Geliefert'></p>";
                echo "</fieldset>";
                break;

            case 3:
                echo "<fieldset class='$fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
            <input type='radio' name=$group id='bestellen_radio' value='Bestellen' ></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
				<input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen'><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
            <input type='radio' name=$group id='fertig_radio' value='Fertig' checked></p>";

                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$group id='unterwegs_radio' value='Unterwegs' checked></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
                     <input type='radio' name=$group id='geliefert_radio' value='Geliefert'></p>";
                echo "</fieldset>";
                break;

            case 4:
                echo "<fieldset class='$fieldset'>";
                echo "<legend>$legend</legend>";
                echo "<p><label for='Bestellen'>Bestellen</label>
            <input type='radio' name=$group id='bestellen_radio' value='Bestellen' ></p>";

                echo "<p><label for='Im Ofen'>Im Ofen</label>
				<input type='radio' name=$group id='Im_Ofen_radio' value='Im Ofen'><br></p>";

                echo "<p><label for='Fertig'>Fertig</label>
            <input type='radio' name=$group id='fertig_radio' value='Fertig'></p>";

                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$group id='unterwegs_radio' value='Unterwegs'></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
                     <input type='radio' name=$group id='geliefert_radio' value='Geliefert' checked></p>";
                echo "</fieldset>";
                break;
            default:
                break;
        }
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData(); // TODO: Change the autogenerated stub
    }

    public static function main():void{
        $Kunde = new Kunde();
        $Kunde->processReceivedData();
        $Kunde->generateView();
    }
}
Kunde::main();