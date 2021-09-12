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

/*
höhe des inhalts > div größe 
größere Box ist der Master, andere muss auf den größeren warten
.scrollheight gibt die höhe an.

solange nach unten bis unten angekommen -> warten auf zweiten slider

wenn beide unten 

delay

solange nach oben bis oben angekommen -> warten auf zweiten slider


*/