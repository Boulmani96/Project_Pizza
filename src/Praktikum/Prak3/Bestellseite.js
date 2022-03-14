
let gesamtpreis = 0;
function onClick(element) {
   gesamtpreis += Number(element.id);
   let x = document.getElementById("mySelect");

   let option = document.createElement("option");
   option.text = element.name;
   console.log("name: ",element.name);
   option.selected = true;
   x.add(option);

   document.getElementById("gesamtpreis").innerHTML = gesamtpreis;
}

function AllLoesche(){
	document.getElementById("mySelect").innerHTML = "";
	document.getElementById("gesamtpreis").innerHTML = 0;
	gesamtpreis = 0;
}

function AuswahlLoeschen(){
    let selected  = document.getElementById('mySelect');
   // console.log("lenght: ",selected.length);
    for (let i = selected.length-1; i >= 0; i--)
    {
        if (selected.options[i].selected) {
            //console.log(selected.options[i].value);
            console.log("value: ",selected.options[i].text);
            switch (selected.options[i].text){
                case "Salami":
                    gesamtpreis+=-4.50;
                    break;
                case "Margherita":
                    gesamtpreis+=-4.00;
                    break;
                case "Hawaii":
                    gesamtpreis+=-5.50;
                    break;
                default:
                    break;
            }
            document.getElementById("gesamtpreis").innerHTML = gesamtpreis;
            document.getElementById('mySelect').remove(i);
        }
    }
}

function Check(){
    let selected  = document.getElementById('mySelect');
    for (let i = selected.length-1; i >= 0; i--)
    {
        if(!selected.options[i].selected){
            selected.options[i].selected = true;
        }
    }
}