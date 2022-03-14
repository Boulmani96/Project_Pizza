let request = new XMLHttpRequest();

function requestData() { // fordert die Daten asynchron an
    "use strict";
    request.open("GET", "news.php?JSON=1"); // URL für HTTP-GET
    request.onreadystatechange = processData; //Callback-Handler zuordnen
    request.send(null); // Request abschicken
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null)
                processNews(request.responseText); // Daten verarbeiten
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

// Ende des gegebenen Codes


function pollNews() {
    "use strict";
    //console.log("pollNews");
    requestData();
    setInterval(requestData(), 8000);
}

function processNews(data) { // Aufgabe 4d
    "use strict";
    let x = JSON.parse(data);
    for(var i = 0; i < x.length; i++){
       // console.log(x);
        let row = {timestamp:x[i][0], title:x[i][1], text:x[i][2]};
        //console.log(row);
        let article = createDOM(row);
        document.getElementById("myNews").appendChild(article);
    }
}

function createDOM(row) {
    "use strict";
    console.log(row["title"],row["timestamp"],row["text"]);
    let newsEntry = document.createElement("article");
    let title = document.createElement("H3");
    let textNodeTitle = document.createTextNode(row["title"]);
    title.appendChild(textNodeTitle);
    let time = document.createElement("P");
    time.className = "timestamp";
    let textNodeTime = document.createTextNode(row["timestamp"]);
    time.appendChild(textNodeTime);
    let text = document.createElement("P");
    let textNodeText = document.createTextNode(row["text"]);

    text.appendChild(textNodeText);
    newsEntry.appendChild(title);
    newsEntry.appendChild(time);
    newsEntry.appendChild(text);
    return newsEntry;
}
