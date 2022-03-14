let request = new XMLHttpRequest();
function myFunction(element) { // fordert die Daten asynchron an
    "use strict";
    let orderingID = element.name;
    let status = element.value;
    request.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            console.log(request.responseText);
        }
    };
    request.open("POST", "Fahrer.php",true); // URL für HTTP-GET
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send("orderingID="+orderingID+"&status="+status); // Request abschicken
}