<?php // UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class DBException extends Exception
{
}

class News extends Page
{
    private $JSON;
    protected function __construct()
    {
        parent::__construct();
        $this->JSON = false;
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData():array
    {
        $myNews = array(array());
        $sqlselect = "Select * from news order by timestamp";
        $result = $this->db->query($sqlselect);
        if (!$result) throw new Exception("Fehler in Abfrage: ".$this->db->error);
        $i = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //var_dump($row);
                $myNews[$i][0] = $row["timestamp"];
                $myNews[$i][1] = $row["title"];
                $myNews[$i][2] = $row["text"];
                $i++;
            }
            $result->free();
        }
        return $myNews;
    }

    protected function generateView()
    {
        if($this->JSON){
            $this->generateJSONView();
        }else{
            $this->generateHTMLView();
        }
    }

    protected function generateHTMLView()
    {
       // $myNews = $this->getViewData();
        $this->generatePageHeader("News");
        echo <<<EOT
            <body onload="pollNews()">
                <header>
                     <img src="logo.png" alt="Logo">
                     <h1 id="headerZeitung">Meine Zeitung</h1>
                </header>
                <nav>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="">Mediathek</a></li>
                        <li><a href="">Politik</a></li>
                        <li><a href="">Sport</a></li>
                    </ul>
                </nav>
                    <section>
                        <h1>News-Ticker</h1>
                        <div id="myNews">
                        
                        </div>
                        <form action="news.php" accept-charset="UTF-8" method="post">
                            <h3>Ihre News</h3>
                            <p><input type="text" id="TheTitel" name="TheTitel" placeholder="Titel Ihrer News" required></p>
                            <p><input type="text" id="TheNews" name="TheNews" placeholder="Ihre News" required></p>
                            <p><input type="submit" name="submit" id="submit" value="Absenden" onclick=""/></p>
                        </form>
                </section>
                <footer>
                    <h5>&copy; Fachbereich Informatik</h5>
                </footer>
        </body>
EOT;
        $this->generatePageFooter();
    }

   /* private function insertNews($title, $text){
        echo "<article>";
        echo "<h3>$title</h3>";
        echo "<p>$text</p>";
        echo "</article>";
    }*/

    protected function generateJSONView()
    {
        header("Content-Type: application/json; charset=UTF-8");
        $myNews = $this->getViewData();
        echo json_encode($myNews);
    }

    protected function processReceivedData()
    {
        $timestamp = '';
        if(isset($_GET["JSON"])){
            $this->JSON = true;
        }
        if (count($_POST)){
            parent::processReceivedData();
            if(isset($_POST["TheTitel"]) && isset($_POST["TheNews"])){
                $TheTitel = $this->db->real_escape_string($_POST["TheTitel"]);
                $TheNews = $this->db->real_escape_string($_POST["TheNews"]);
                //$timestamp = $this->getLocalizedDate($timestamp); //3c
                //$timestamp = date("d.m.Y H:i:s");
                $timestamp = date("Y-m-d H:i:s");
                $sqlInsert = "insert into news Values(NULL, '$timestamp', '$TheTitel', '$TheNews')";
                $this->db->query($sqlInsert);
            }
            header("HTTP/1.1 303 See Other");
            header("Location:news.php");
            die();
       }
    }

    protected function getLocalizedDate($date)
    {
        // date_default_timezone_set('Europe/Berlin'); =>  Wird in Page.php Oben deklariert
        $date = date("d.m.Y H:i:s");
        return $date;
    }

    public static function main()
    {
        try {
            $page = new News();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

News::main();

