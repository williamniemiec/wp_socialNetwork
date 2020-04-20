<h1>Profile</h1>

<!-- Shows edit button if it is the profile of the current user -->
<?php if ($isOwner): ?>
	<a class="btn btn-outline-primary btn-block" href="<?php echo BASE_URL; ?>profile/edit">Edit</a><br />
<?php endif; ?>

<div class="form-group">
		<strong>Name</strong>
		<input id="name" type="text" class="form-control-plaintext" value="<?php echo $data['name']; ?>" disabled="disabled" />
	</div>
	
	<div class="form-group genre">
		<strong>Genre</strong><br />
		<label><input type="radio" value="0" <?php echo $data['genre'] == '0' ? 'checked="checked"' : ''; ?> disabled="disabled" />Female</label>
		<label><input type="radio" value="1" <?php echo $data['genre'] == '1' ? 'checked="checked"' : ''; ?> disabled="disabled" />Male</label>
	</div>
	
	<div class="form-group">
		<strong>Biography</strong><br />
		<textarea id="bio" class="form-control-plaintext" disabled="disabled"><?php echo $data['bio']; ?></textarea>
	</div>
	
	<div class="form-group">
		<strong>Email</strong>
		<input id="email" class="form-control-plaintext" disabled="disabled" value="<?php echo $data['email']; ?>" />
	</div>
