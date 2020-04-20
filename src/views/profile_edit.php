<h1>Profile</h1>	

<!-- Shows error message if there is one -->
<?php if (!empty($error)): ?>
	<div class="alert alert-danger" role="alert">
		Error saving edits
	</div>
<?php endif; ?>

<form method="POST">
	<div class="form-group">
		<label for="name">Name</label>
		<input id="name" type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>" />
	</div>
	
	<div class="form-group genre">
		<label>Genre</label><br />
		<label><input type="radio" name="genre" value="0" <?php echo $data['genre'] == '0' ? 'checked="checked"' : ''; ?> />Female</label>
		<label><input type="radio" name="genre" value="1" <?php echo $data['genre'] == '1' ? 'checked="checked"' : ''; ?> />Male</label>
	</div>
	
	<div class="form-group">
		<label for="bio">Biography</label><br />
		<textarea id="bio" name="bio" class="form-control"><?php echo $data['bio']; ?></textarea>
	</div>
	
	<div class="form-group">
		<label for="email">Email</label>
		<input id="email" class="form-control" disabled="disabled" value="<?php echo $data['email']; ?>" />
	</div>
	
	<div class="form-group">
		<label for="password">Password</label>
		<input id="password" type="password" name="password" class="form-control" />
	</div>
	
	<input type="submit" class="btn btn-outline-primary btn-block" value="Save" />
</form>