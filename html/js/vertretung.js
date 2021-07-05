$status = "oben";

function myScroller($input, $time, $speed) {
    if (document.getElementById($input).scrollTop + document.getElementById($input).clientHeight >= document.getElementById($input).scrollHeight) {
        if ($counter < $time) {
            $counter++;
        } else {
            $counter = 0;
            $switch = 1;
            document.getElementById($input).scrollTop -= 1;
        }
    } else {
        if ($switch == 1) {
            document.getElementById($input).scrollTop -= 1;
            if (document.getElementById($input).scrollTop == 0) {
                if ($counter < $time) {
                    $counter++;
                } else {
                    $counter = 0;
                    $switch = 0;
                    document.getElementById($input).scrollTop += 1;
                }
            }
        } else {
            document.getElementById($input).scrollTop += 1;
        }
    }
}

function scrolling($input) {
    //wenns ove isch
    if (document.getElementById($input).scrollTop == 0) {
        console.log("isch ove");
        $status = "oben";
    }

    //wenns unne isch
    else if (document.getElementById($input).scrollTop + document.getElementById($input).clientHeight >= document.getElementById($input).scrollHeight) {
        console.log("isch unne");
        $status = "unten";
    }

    if ($status == "oben") {
        setTimeout(function() {
            if (document.getElementById($input).scrollTop + document.getElementById($input).clientHeight < document.getElementById($input).scrollHeight) {
                console.log("+");
                document.getElementById($input).scrollTop += 1;
            }
        }, 1000);
    } else if ($status == "unten") {
        setTimeout(function() {
            if (document.getElementById($input).scrollTop > 0) {
                console.log("-");
                document.getElementById($input).scrollTop -= 1;
            }

        }, 1000);
    }


}