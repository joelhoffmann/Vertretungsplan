<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  .marquee {
    max-width: 100vw;
    /* iOS braucht das */
    white-space: nowrap;
    overflow: hidden;
    /* hier evtl. noch font-size, color usw. */
  }

  .marquee span {
    display: inline-block;
    padding-left: 105%;
    /* die zusätzlichen 5% erzeugen einen verzögerten Start und vermeiden so ein Ruckeln auf langsamen Seiten */
    animation: marquee 20s linear infinite;
  }

  /* Optional: mouseover (oder Tipp auf dem Touchscreen) pausiert die Laufschrift */
  .marquee span:hover {
    animation-play-state: paused
  }

  /* Make it move */
  @keyframes marquee {
    0% {
      transform: translateX(0);
    }

    100% {
      transform: translateX(-100%);
    }
  }
</style>

<body>
  <div id="marquee" class="marquee"><span>Demo 2: Auch dies ist Laufschrift - aber diesmal valides HTML und CSS, und ruckelfrei auch im Firefox.</span></div>

</body>

</html>