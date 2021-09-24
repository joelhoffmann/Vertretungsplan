function showDiv(id) {
    for (var i = 1; i < 5; i++) {
        document.getElementById(i).style.display = "none";
    }
    document.getElementById(id).style.display = "block";
}