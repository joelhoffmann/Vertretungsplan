<?php
$start = strtotime('12:01');
$end = strtotime('13:16');
$minutes = ($start - $end) / 60;
echo "The difference in minutes is $minutes minutes.";