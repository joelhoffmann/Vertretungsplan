function scrolling($input, $switch, $delay, $speed) {
    var speed = parseInt($speed);

    if ($switch == 0) {
        setTimeout(function() {
            document.getElementById($input).scrollTop += speed;
        }, $delay);
    } else if ($switch == 1) {
        setTimeout(function() {
            document.getElementById($input).scrollTop -= speed;
        }, $delay);
    }

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