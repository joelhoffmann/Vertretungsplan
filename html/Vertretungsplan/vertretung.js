var a = 0;

function showDiv() {
    if (a == 0) {
        document.getElementById('0').style.display = "block";
        if (document.getElementById('1')) {
            document.getElementById('1').style.display = "none";
        }
        a++;
    } else if (a == 1) {
        if (document.getElementById('1')) {
            document.getElementById('1').style.display = "block";
        }
        document.getElementById('0').style.display = "none";
        a--;
    }
}

function test(dauer) {
    document.getElementById('0').style.display = "block";
    setInterval(showDiv, dauer);
}