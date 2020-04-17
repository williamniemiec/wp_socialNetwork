<!doctype html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <script src='<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js'></script>
        <link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/bootstrap.min.css' />
        <link rel='stylesheet' href='<?php echo BASE_URL; ?>assets/css/style.css' />
        <link href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet' />
        <style>
            
        </style>
    </head>

    <body>
    	<nav class="navbar bg-dark">
			<div class="container">
				<ul class="nav navbar-left">
					<li class="brand"><a href="<?php echo BASE_URL; ?>" class="nav-item nav-link">Social network</a></li>
				</ul>
				
				<form method="GET" action="<?php echo BASE_URL; ?>search">
    				<div class="search">
    					<input type="text" name="q" class="form-control" placeholder="Search" />
    					<button class="btn btn-primary"><span class="fa fa-search"></span></button>	
    				</div>
				</form>
				
				<ul class="nav navbar-right">
					<li class="dropdown">
						<a class="btn btn-link dropdown-toggle profile_name" data-toggle="dropdown">
							<?php echo $name; ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-right ">
							<li class="dropdown-item"><a href="<?php echo BASE_URL; ?>profile">Profile</a></li>
    						<li class="dropdown-item"><a href="<?php echo BASE_URL; ?>profile/edit">Edit profile</a></li>
    						<li class="dropdown-item"><a href="<?php echo BASE_URL; ?>login/logout">Logout</a></li>						
						</ul>
					</li>
					<!--  
					<li class="nav-item nav-link"><?php echo $name; ?></li>
					<li class="nav-item"><a href="<?php echo BASE_URL; ?>login/logout" class="nav-link">Logout</a></li>
					-->
				</ul>
			</div>
		</nav>
    
        <!-- Scripts -->
        
        <script src='<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js'></script>
        <script>var BASE_URL = "<?php echo BASE_URL; ?>"</script>
        <script src='<?php echo BASE_URL; ?>assets/js/script.js'></script>
		
		<div class="container">
        	<?php $this->loadView($viewName, $viewData); ?>
        </div>
    </body>
</html>