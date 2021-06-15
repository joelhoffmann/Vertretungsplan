function showDiv(id) {
    for (var i = 1; i < 5; i++) {
        document.getElementById(i).style.display = "none";
    }
    document.getElementById(id).style.display = "block";
}

function test() {
    document.getElementById('ttt').innerHTML = "input";
    //$('#tetete').load('settings.php #tetete', function() {});
    document.getElementById('#tetete').load('settings.php #tetete', function() {});
}

function change() {
    document.getElementById('box1').innerHTML = "geändert";
    $('#myDiv').load('settings.php' + ' #myDiv');
}

function reload() {
    //var container = document.getElementById("myDiv");
    //var content = "container.innerHTML";
    //container.innerHTML = content;
    $('#myDiv').load('settings.php #myDiv');
}