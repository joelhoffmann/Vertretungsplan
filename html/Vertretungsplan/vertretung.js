$time = 600;
$speed = 1;

var myVar = setInterval(function() {
    myScroller("scrollarea");
    myScroller("scrollarea2");

}, 2);

$counter = 0;
$switch = 0;

function myScroller($input) {
    if (document.getElementById($input).scrollTop + document.getElementById($input).clientHeight >= document.getElementById($input).scrollHeight) {
        if ($counter < $time) {
            $counter++;
        } else {
            $counter = 0;
            $switch = 1;
            document.getElementById($input).scrollTop -= $speed;
        }
    } else {
        if ($switch == 1) {
            document.getElementById($input).scrollTop -= $speed;
            if (document.getElementById($input).scrollTop == 0) {
                if ($counter < $time) {
                    $counter++;
                } else {
                    $counter = 0;
                    $switch = 0;
                    document.getElementById($input).scrollTop += $speed;
                }
            }
        } else {
            document.getElementById($input).scrollTop += $speed;
        }
    }
}