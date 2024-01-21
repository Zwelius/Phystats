function searchFunction() {
    var search = document.getElementById("search");
    var filter = search.value.toUpperCase();
    var table = document.getElementById("table");
    var row = table.getElementsByTagName("tr");
    for (i = 0; i < row.length; i++) {
        var td = row[i].getElementsByTagName("td")[0];
        if (td) {
            var txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                row[i].style.display = "";
            } else {
                row[i].style.display = "none";
            }
        }
    }
}
