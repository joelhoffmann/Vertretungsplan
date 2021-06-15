<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        .border {
            margin: 10px;
            height: 300px;
            width: 200px;
            border: 1px solid #000;
            overflow: hidden;
        }
    </style>
    <script type="text/javascript">
        var myVar = setInterval(function() {
            myScroller()

        }, 50);

        function myScroller() {
            if (document.getElementById("scrollarea").scrollTop + document.getElementById("scrollarea").clientHeight == document.getElementById("scrollarea").scrollHeight) {
                document.getElementById("scrollarea").scrollTop = 0;
            } else {
                document.getElementById("scrollarea").scrollTop += 1;
            }
        }
    </script>
    <div class="border" id="scrollarea">
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.
        Zwei flinke Boxer jagen die quirlige Eva und ihren Mops durch Sylt. Franz jagt im komplett verwahrlosten Taxi quer durch Bayern.variant_and
    </div>
</body>

</html>