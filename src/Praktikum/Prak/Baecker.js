/*function myFunction(element) {
    let ordered_article_id = element.name;
    let status = element.value;
    console.log(ordered_article_id+" "+status);
    $.ajax({
        type : "POST",  //type of method
        url  : "Baecker.php",  //your page
        data : { ordered_article_id : ordered_article_id, status : status},// passing the values
        success: function(){
           console.log("Success");
           document.getElementById("myForm").submit();
        }
    });
}*/
// request als globale Variable anlegen (haesslich, aber bequem)
let request = new XMLHttpRequest();
function myFunction(element) { // fordert die Daten asynchron an
    "use strict";
    let ordered_article_id = element.name;
    let status = element.value;
    request.onreadystatechange = function (){
      if(this.readyState == 4 && this.status == 200){
          console.log(request.responseText);
      }
    };
    request.open("POST", "Baecker.php",true); // URL für HTTP-GET
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send("ordered_article_id="+ordered_article_id+"&status="+status); // Request abschicken
}
