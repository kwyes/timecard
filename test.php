
  <style media="screen">
  html,
body {
width: 100%;
height: 100%;
margin: 0;
padding: 0;
}
body {
display: flex;
justify-content: center;
align-items: center;
background-color: #EA4961;
}
.loader {
color: #fff;
font-family: Consolas, Menlo, Monaco, monospace;
font-weight: bold;
font-size: 30vh;
opacity: 0.8;
}
.loader span {
display: inline-block;
-webkit-animation: pulse 0.4s alternate infinite ease-in-out;
        animation: pulse 0.4s alternate infinite ease-in-out;
}
.loader span:nth-child(odd) {
-webkit-animation-delay: 0.4s;
        animation-delay: 0.4s;
}
@-webkit-keyframes pulse {
to {
  -webkit-transform: scale(0.8);
          transform: scale(0.8);
  opacity: 0.5;
}
}
@keyframes pulse {
to {
  -webkit-transform: scale(0.8);
          transform: scale(0.8);
  opacity: 0.5;
}
}

.ftr{
  text-align: center;
  width: 100%;
  position: absolute;
  bottom: 70px;
}

  </style>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->

  <!DOCTYPE html>
  <html lang="en" >

  <head>
    <meta charset="UTF-8">
    <title>Code Loader</title>



        <link rel="stylesheet" href="css/style.css">


  </head>

  <body>

    <div class="loader">
    <span>{</span><span>SignIn</span><span>}</span>
  </div>

    <div class="ftr">Design by <a href="http://www.csshint.com/">www.csshint.com</a></div>

  </body>

  </html>
