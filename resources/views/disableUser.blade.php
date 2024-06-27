{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRM</title>
    <style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
@import url('https://fonts.googleapis.com/css?family=Catamaran:400,800');
.error-container {
  text-align: center;
  font-size: 800;
  margin: 20px 15px;
}180px;
  font-family: 'Catamaran', sans-serif;
  font-weight: 
.error-container > span {
  display: inline-block;
  line-height: 0.7;
  position: relative;
  color: #FFB485;
}
.error-container > span {
  display: inline-block;
  position: relative;
  vertical-align: middle;
}
.error-container > span:nth-of-type(1) {
  color: #D1F2A5;
  animation: colordancing 4s infinite;
}
.error-container > span:nth-of-type(3) {
  color: #F56991;
  animation: colordancing2 4s infinite;
}
.error-container > span:nth-of-type(2) {
  width: 120px;
  height: 120px;
  border-radius: 999px;
}
.error-container > span:nth-of-type(2):before,
.error-container > span:nth-of-type(2):after {
	border-radius: 0%;
	content:"";
	position: absolute;
	top: 0; left: 0;
	width: inherit; height: inherit;
  border-radius: 999px;
	box-shadow: inset 30px 0 0 rgba(209, 242, 165, 0.4),
				inset 0 30px 0 rgba(239, 250, 180, 0.4),
				inset -30px 0 0 rgba(255, 196, 140, 0.4),	
				inset 0 -30px 0 rgba(245, 105, 145, 0.4);
  animation: shadowsdancing 4s infinite;
}
.error-container > span:nth-of-type(2):before {
	-webkit-transform: rotate(45deg);
	   -moz-transform: rotate(45deg);
			transform: rotate(45deg);
}

.screen-reader-text {
    position: absolute;
    top: -9999em;
    left: -9999em;
}
@keyframes shadowsdancing {
  0% {
    box-shadow: inset 30px 0 0 rgba(209, 242, 165, 0.4),
				inset 0 30px 0 rgba(239, 250, 180, 0.4),
				inset -30px 0 0 rgba(255, 196, 140, 0.4),	
				inset 0 -30px 0 rgba(245, 105, 145, 0.4);
  }
  25% {
    box-shadow: inset 30px 0 0 rgba(245, 105, 145, 0.4),
				inset 0 30px 0 rgba(209, 242, 165, 0.4),
				inset -30px 0 0 rgba(239, 250, 180, 0.4),	
				inset 0 -30px 0 rgba(255, 196, 140, 0.4);
  }
  50% {
     box-shadow: inset 30px 0 0 rgba(255, 196, 140, 0.4),
				inset 0 30px 0 rgba(245, 105, 145, 0.4),
				inset -30px 0 0 rgba(209, 242, 165, 0.4),	
				inset 0 -30px 0 rgba(239, 250, 180, 0.4);
  }
  75% {
   box-shadow: inset 30px 0 0 rgba(239, 250, 180, 0.4),
				inset 0 30px 0 rgba(255, 196, 140, 0.4),
				inset -30px 0 0 rgba(245, 105, 145, 0.4),	
				inset 0 -30px 0 rgba(209, 242, 165, 0.4);
  }
  100% {
    box-shadow: inset 30px 0 0 rgba(209, 242, 165, 0.4),
				inset 0 30px 0 rgba(239, 250, 180, 0.4),
				inset -30px 0 0 rgba(255, 196, 140, 0.4),	
				inset 0 -30px 0 rgba(245, 105, 145, 0.4);
  }
}
@keyframes colordancing {
  0% {
    color: #D1F2A5;
  }
  25% {
    color: #F56991;
  }
  50% {
    color: #FFC48C;
  }
  75% {
    color: #EFFAB4;
  }
  100% {
    color: #D1F2A5;
  }
}
@keyframes colordancing2 {
  0% {
    color: #FFC48C;
  }
  25% {
    color: #EFFAB4;
  }
  50% {
    color: #D1F2A5;
  }
  75% {
    color: #F56991;
  }
  100% {
    color: #FFC48C;
  }
}

/* demo stuff */
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body {
  background-color: #416475;
  /* margin-bottom: 50px; */
}
html, button, input, select, textarea {
    font-family: 'Montserrat', Helvetica, sans-serif;
    color: #92a4ad;
}
h1 {
  text-align: center;
  margin: 30px 15px;
}
.zoom-area { 
  max-width: 490px;
  margin: 30px auto 30px;
  font-size: 19px;
  text-align: center;
}
.link-container {
  text-align: center;
}
a.more-link {
  text-transform: uppercase;
  font-size: 13px;
    background-color: #0ba5f1;
    padding: 10px 15px;
    border-radius: 0;
    color: #090a0a;
    display: inline-block;
    margin-right: 5px;
    margin-bottom: 5px;
    line-height: 1.5;
    text-decoration: none;
  margin-top: 50px;
  letter-spacing: 1px;
  cursor: pointer !important;
}
a.more-link:hover{
    color: rgb(52, 51, 51);
    background-color: #ccdfe8;
}
    </style>
</head>
<body style="display:flex;justify-content:center;align-items:center;flex-direction:column;margin-top:10vh;">
    <h1>Access Denied</h1>
        <p style="text-align:center">Your account has been disabled.</p>
    <div class="link-container">
      <a href="/" class="more-link">Go to Home Page</a>
    </div>
</body>
</html>


