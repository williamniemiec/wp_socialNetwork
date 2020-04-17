<html>
	<head>
		<title>Login</title>
		<link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/bootstrap.min.css' />
		<link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/style.css' />
		<style>

		</style>
	</head>
	
	<body>
		<nav class="navbar bg-dark">
			<div class="container">
				<ul class="navbar-nav navbar-left">
					<li><a href="<?php echo BASE_URL; ?>" class="nav-item nav-link">Social network</a></li>
				</ul>
				<ul class="navbar-nav navbar-right ">
					<li class="nav-item"><a href="<?php echo BASE_URL; ?>login/login" class="nav-link">Login</a></li>
					<li class="nav-item"><a href="<?php echo BASE_URL; ?>login/register" class="nav-link">Register</a></li>
				</ul>
			</div>
		</nav>
		<div class="container">
			<h1>Register</h1>
			
			<?php if (!empty($notice)): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo $notice; ?>
				</div>
			<?php endif; ?>
			
			<form method="POST">
    			<div class="form-group">
    				<label for="name">Name</label>
    				<input id="name" type="text" name="name" class="form-control" />
    			</div>
    			
    			<div class="form-group genre">
        			<label>Genre</label><br />
    				<label><input type="radio" name="genre" value="0" checked="checked" />Female</label>
    				<label><input type="radio" name="genre" value="1" />Male</label>
    			</div>
    			
    			<div class="form-group">
    				<label for="email">Email</label>
    				<input id="email" type="email" name="email" class="form-control" />
    			</div>
    			
    			<div class="form-group">
    				<label for="password">Password</label>
    				<input id="password" type="password" name="password" class="form-control" />
    			</div>
    			
    			<input type="submit" class="btn btn-outline-primary btn-block" value="Register" />
			</form>
		</div>
	
		<!-- Scripts -->
		<script src='<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js'></script>
		<script src='<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js'></script>
	</body>
</html>