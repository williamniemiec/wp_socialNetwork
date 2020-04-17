<h1>Profile</h1>
<?php if ($isOwner): ?>
	<a class="btn btn-outline-primary btn-block" href="<?php echo BASE_URL; ?>profile/edit">Edit</a><br />
<?php endif; ?>

<div class="form-group">
		<label for="name">Name</label>
		<input id="name" type="text" class="form-control" value="<?php echo $data['name']; ?>" disabled="disabled" />
	</div>
	
	<div class="form-group genre">
		<label>Genre</label><br />
		<label><input type="radio" value="0" <?php echo $data['genre'] == '0' ? 'checked="checked"' : ''; ?> disabled="disabled" />Female</label>
		<label><input type="radio" value="1" <?php echo $data['genre'] == '1' ? 'checked="checked"' : ''; ?> disabled="disabled" />Male</label>
	</div>
	
	<div class="form-group">
		<label for="bio">Biography</label><br />
		<textarea id="bio" class="form-control" disabled="disabled"><?php echo $data['bio']; ?></textarea>
	</div>
	
	<div class="form-group">
		<label for="email">Email</label>
		<input id="email" class="form-control" disabled="disabled" value="<?php echo $data['email']; ?>" />
	</div>
