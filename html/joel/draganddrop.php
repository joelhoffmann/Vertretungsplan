<body>
    
  <span id="submit-lbl" name="submit" ><a href="#"></a></span>
</body>

<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:600&display=swap');

#submit-lbl{
  position: relative;
  display: inline-flex;
  width: 180px;
  height: 55px;
  margin: 0 15px;
  perspective: 1000px;
}

#submit-lbl a{
  font-size: 19px;
  letter-spacing: 1px;
  transform-style: preserve-3d;
  transform: translateZ(-25px);
  transition: transform .25s;
  font-family: 'Montserrat', sans-serif;
  
}

#submit-lbl a:before,

#submit-lbl a:after{
  position: absolute;
  content: "Upload";
  height: 55px;
  width: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 5px solid black;
  box-sizing: border-box;
  border-radius: 5px;
}

#submit-lbl a:before{
  color: #fff;
  background: #000;
  transform: rotateY(0deg) translateZ(25px);
}

#submit-lbl a:after{
  color: #000;
  transform: rotateX(90deg) translateZ(25px);
}

#submit-lbl a:hover{
  transform: translateZ(-25px) rotateX(-90deg);
}


</style>