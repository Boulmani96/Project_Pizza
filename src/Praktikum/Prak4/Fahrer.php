<?php declare(strict_types=1);
header("Refresh:5");
require_once './Page.php';

class Fahrer extends Page
{
    protected function __construct(){
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    protected function generateView():void{
        $ordered_article = $this->getViewData();
        $this->generatePageHeader('Fahrer','Seite.css');
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
			<h1>Fahrer</h1>
		</header>
        <form id="myForm" action="Fahrer.php" accept-charset="utf-8" method="POST">
EOT;
        if(isset($ordered_article) && !empty($ordered_article)) {
            $myarray = array();
            $myarray[0] = -1;
            for ($row = 0; $row < count($ordered_article); $row++) {
                if(isset($ordered_article[$row][0]) && isset($ordered_article[$row][1])
                    && isset($ordered_article[$row][2]) && isset($ordered_article[$row][3])) {

                    $orderingID = $ordered_article[$row][0];
                    $articleID = $ordered_article[$row][1];
                    $status = $ordered_article[$row][2];
                    $address = $ordered_article[$row][3];

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

                    if($orderingID != $myarray[0]){
                        if($row != 0){
                            if(isset($myarray[0]) && isset($myarray[1]) && isset($myarray[2]) && isset($myarray[3])){
                                $myOrderingID = $myarray[0];
                                $myStatus = $myarray[1];
                                $myAddress = $myarray[2];
                                $myPizzen = "";
                                for ($i = 0; $i < count($myarray[3]); $i++){
                                    if($i != count($myarray[3])-1){
                                        $myPizzen.=$myarray[3][$i].', ';
                                    }else{
                                        $myPizzen.=$myarray[3][$i];
                                    }
                                }
                                $this->insert_ordered_article($myOrderingID, $myPizzen, $myStatus, $myAddress);
                            }
                        }
                        $myarray = array($orderingID,  $status, $address, array());
                    }
                    array_push($myarray[3], $Pizza);
                    if($row == count($ordered_article)-1){
                        if(isset($myarray[0]) && isset($myarray[1]) && isset($myarray[2]) && isset($myarray[3])){
                            $myOrderingID = $myarray[0];
                            $myStatus = $myarray[1];
                            $myAddress = $myarray[2];
                            $myPizzen = "";
                            for ($i = 0; $i < count($myarray[3]); $i++){
                                if($i != count($myarray[3])-1){
                                    $myPizzen.=$myarray[3][$i].', ';
                                }else{
                                    $myPizzen.=$myarray[3][$i];
                                }
                            }
                        }
                        $this->insert_ordered_article($myOrderingID, $myPizzen, $myStatus, $myAddress);
                    }
                }
            }
        }
        echo <<<EOT
        </form>
        </section>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="Fahrer.js"></script>
EOT;
        $this->generatePageFooter();
    }


    protected function getViewData():array{
        $ordered_article = array(array());
        $sqlSelect = "Select o.ordering_id, article_id, status, address
                        from ordered_article o, ordering od
                        where (status='2' OR status='3') AND o.ordering_id = od.ordering_id order by o.ordering_id";
        $result = $this->database->query($sqlSelect);
        $i = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $ordered_article[$i][0] = $row["ordering_id"];
                $ordered_article[$i][1] = $row["article_id"];
                $ordered_article[$i][2] = $row["status"];
                $ordered_article[$i][3] = $row["address"];
                $i++;
            }
            $result->free();
        }
        return $ordered_article;
    }

    private function insert_ordered_article($orderingID, $Pizza, $status, $address){
        switch ($status){
            case 2:
                echo "<fieldset class='fieldset'>";
                echo "<legend>Bestellung $orderingID</legend>";

                echo "<p>$address</p>";
                echo "<p>Pizzen: $Pizza</p>";
                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$orderingID id='Unterwegs_radio' value='Unterwegs' onclick='myFunction(this)'></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
				<input type='radio' name=$orderingID id='Geliefert_radio' value='Geliefert' onclick='myFunction(this)'><br></p>";
                echo "</fieldset>";
                break;
            case 3:
                echo "<fieldset class='fieldset'>";
                echo "<legend>Bestellung $orderingID</legend>";

                echo "<p>$address</p>";
                echo "<p>Pizzen: $Pizza</p>";
                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$orderingID id='Unterwegs_radio' value='Unterwegs' onclick='myFunction(this)' checked></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
				<input type='radio' name=$orderingID id='Geliefert_radio' value='Geliefert' onclick='myFunction(this)'><br></p>";
                echo "</fieldset>";
                break;
            case 4:
                echo "<fieldset class='fieldset'>";
                echo "<legend>Bestellung $orderingID</legend>";

                echo "<p>$address</p>";
                echo "<p>Pizzen: $Pizza</p>";
                echo "<p><label for='Unterwegs'>Unterwegs</label>
                     <input type='radio' name=$orderingID id='Unterwegs_radio' value='Unterwegs' onclick='myFunction(this)'></p>";

                echo "<p><label for='Geliefert'>Geliefert</label>
				<input type='radio' name=$orderingID id='Geliefert_radio' value='Geliefert' onclick='myFunction(this)' checked><br></p>";
                echo "</fieldset>";
                break;
            default:
                break;
        }
    }
    protected function processReceivedData(): void
    {
        parent::processReceivedData(); // TODO: Change the autogenerated stub
        if (isset($_POST['orderingID']) && isset($_POST['status'])) {
            $status = -1;
            $orderingID = $this->database->real_escape_string($_POST['orderingID']);
            $value = $this->database->real_escape_string($_POST['status']);
            switch ($value){
                case 'Unterwegs':
                    $status = 3;
                    break;
                case 'Geliefert':
                    $status = 4;
                    break;
                default:
                    break;
            }
            if($status != -1) {
                $sql = "update ordered_article SET STATUS = ('$status') WHERE ordering_id = ('$orderingID')";
                $this->database->query($sql);
            }
        }
    }

    public static function main():void{
        $driver = new Fahrer();
        $driver->processReceivedData();
        $driver->generateView();
    }
}

Fahrer::main();