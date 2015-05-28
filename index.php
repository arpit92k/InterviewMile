
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="./imgs/favicon.ico">
	<title>InterviewX</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet"
		href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- Custom styles for this page-->
	<link href="./styles/main.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php
		include_once 'addins/fbLogin/fbLogin.php';
		include_once 'addins/googleLogin/googleLogin.php'; 
	?>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<ul class="navbar-text navbar-left">
				<a href="#" class="navbar-link">interviewX</a>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">Signed in as</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Guest<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<center>
								<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true"></div>
							</center>
						</li>
						<li>
							<center>
								<div class="g-signin2"></div>
							</center>
						</li>
					</ul></li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<div class="starter-template">
			<h1>Content will be here</h1>
			<div id="status">
			</div>
		</div>
	</div>
	<!-- /.container -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>