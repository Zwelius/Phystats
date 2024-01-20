function searchFunction(){
    var search = document.getElementById("search");
    var filter = search.value.toUpperCase();
    var table = document.getElementsByClassName("rounded-corners");
    var row = table.getElementByTagName("tr");
    for (var i = 0; i < row.length; i++) {
        var name = row[i].getElementById('names')[0];
        var text = name.textContent || name.innerText;
        if (text.toUpperCase().indexOf(filter) > -1) {
            row[i].style.display = "";
        }else{
            row[i].style.display = "none";
        }
        
    }
}
