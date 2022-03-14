let gesamtPreis = 0;
function onClick(element) {
    "use strict";
   gesamtPreis += Number(element.id);
   let x = document.getElementById("mySelect");

   let option = document.createElement("option");
   option.text = element.name;
   //console.log("name: ",element.name);
   option.selected = true;
   x.add(option);
   document.getElementById("gesamtpreis").innerHTML = gesamtPreis;
}

function AllLoesche(){
    "use strict";
	document.getElementById("mySelect").innerHTML = "";
	document.getElementById("gesamtpreis").innerHTML = 0;
	gesamtPreis = 0;
}

function AuswahlLoeschen(){
    "use strict";
    let selected  = document.getElementById('mySelect');
    for (let i = selected.length-1; i >= 0; i--)
    {
        if (selected.options[i].selected) {
            switch (selected.options[i].text){
                case "Salami":
                    gesamtPreis+=-4.50;
                    break;
                case "Margherita":
                    gesamtPreis+=-4.00;
                    break;
                case "Hawaii":
                    gesamtPreis+=-5.50;
                    break;
                case "Vegetaria":
                    gesamtPreis+=-12.5;
                    break;
                case "Spinat-Hühnchen":
                    gesamtPreis+=-11.99;
                    break;
                default:
                    break;
            }
            document.getElementById("gesamtpreis").innerHTML = gesamtPreis;
            document.getElementById('mySelect').remove(i);
        }
    }
}

function stateHandle(){
    "use strict";
    document.getElementById('submit').disabled = !(document.getElementById('Adresse').value.length > 0
        && document.getElementById('mySelect').length > 0);
}

function Check(){
    "use strict";
    let selected  = document.getElementById('mySelect');
    for (let i = selected.length-1; i >= 0; i--)
    {
        if(!selected.options[i].selected){
            selected.options[i].selected = true;
        }
    }
}