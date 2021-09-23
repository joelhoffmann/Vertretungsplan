function scroll($speed, $delay) {
    if (document.getElementById("scrollarea1").scrollHeight > document.getElementById("scrollarea2").scrollHeight) {
        //scrollarea1 master
        scroll_einheit("scrollarea1", "scrollarea2", $speed, $delay);

    } else {
        scroll_einheit("scrollarea2", "scrollarea1", $speed, $delay);
    }
}

function scroll_einheit($master, $client, $speed, $delay) {
    $switch = 0;
    var links = setInterval(function() {
        if (document.getElementById($master).scrollTop + document.getElementById($master).clientHeight >= document.getElementById($master).scrollHeight) {
            setTimeout(function() {
                $switch = 1;
            }, 2000);
        } else if (document.getElementById($master).scrollTop <= 0) {
            setTimeout(function() {
                $switch = 0;
            }, $delay);
        }
        if ($switch == 0) {
            document.getElementById($master).scrollTop += $speed;
            document.getElementById($client).scrollTop += $speed;
        }
        if ($switch == 1) {
            document.getElementById($master).scrollTop -= $speed;
            document.getElementById($client).scrollTop -= $speed;
        }
    }, 0);
}

function startTime() {
    var today = new Date();
    var hours = today.getHours();
    var minutes = today.getMinutes();
    minutes = checkTime(minutes);
    document.getElementById('Uhrzeit').innerHTML =
        hours + ":" + minutes;
    var t = setTimeout(startTime, 1000);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
}

function nextDay(diff) { //Prints out date to header
    var today = new Date();
    var date = String(today.getDate() + (parseInt(diff)) + 1) + '.' + (String(today.getMonth() + 1)).padStart(2, '0') + '.' + String(today.getFullYear()).substr(-2);
    document.getElementById('naechsterTag').innerHTML = "Nächster Tag, " + date;


}

function switchbetween(delay) {
    setInterval(function() {
        if (document.getElementById('1').style.display == "block") {
            document.getElementById('1').style.display = "none";
            document.getElementById('2').style.display = "block";
        } else {
            document.getElementById('1').style.display = "block";
            document.getElementById('2').style.display = "none";
        }

    }, delay);

}

function showNewsSwitch(max, delay) {
    $max = max;
    $min = 10;
    $counter = 10;
    document.getElementById($min).style.display = "block";

    setInterval(function() {
        if ($counter == max) {
            $counter = $min;
        }
        for (var i = $min; i < max; i++) {
            document.getElementById(i).style.display = "none";
        }
        document.getElementById($counter).style.display = "block";
        $counter++;
    }, delay);


}