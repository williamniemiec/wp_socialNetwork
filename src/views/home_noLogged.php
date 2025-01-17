<html>
	<head>
		<title>Login</title>
		<link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/bootstrap.min.css' />
		<link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/home.css' />
        <link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/navbar.css' />
		<link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/style.css' />
	</head>
	
	<body>
		<nav class="navbar">
			<div class="container">
				<ul class="navbar-nav navbar-left">
					<li><a href="<?php echo BASE_URL; ?>" class="nav-item nav-link">Social network</a></li>
				</ul>
				<ul id="actions_noLogged" class="navbar-nav navbar-right">
					<li class="nav-item"><a href="<?php echo BASE_URL; ?>login/login" class="nav-link">Login</a></li>
					<li class="nav-item"><a href="<?php echo BASE_URL; ?>login/register" class="nav-link">Register</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="container">
			<h1 class="home_title">Welcome!</h1>
			<h4 class="home_description">The best social network</h4>
		</div>
	
		<!-- Scripts -->
		<script src='<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js'></script>
		<script src='<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js'></script>
	</body>
</html>