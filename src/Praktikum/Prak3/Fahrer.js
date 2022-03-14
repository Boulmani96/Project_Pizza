function myFunction(element) {
    let ordered_article_id = element.name;
    let status = element.value;
    console.log(ordered_article_id+" "+status);
    $.ajax({
        type : "POST",  //type of method
        url  : "Fahrer.php",  //your page
        data : { ordered_article_id : ordered_article_id, status : status},// passing the values
        success: function(){
            console.log("Success");
            document.getElementById("myForm").submit();
        }
    });
}