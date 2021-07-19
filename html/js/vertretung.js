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