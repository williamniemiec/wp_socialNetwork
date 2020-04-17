<h1>HOME</h1>

<div class="row">
	<div class="col-sm-8">
		<h4>Feed</h4>
		
		<div class="post_area">
			<h5>What are you thinking?</h5>
			<form method="POST" enctype="multipart/form-data">
				<textarea class="form-control" name="message"></textarea><br />
				<input class="form-control" type="file" name="image" accept="image/*" /><br />
				<input class="btn btn-primary btn-block" type="submit" value="Post" />
			</form>	
		</div>
    	
    	<?php foreach($feed as $f): ?>
    		<div class="post">
    			<div class="post_info">
    				<h6><?php echo $f['name']; ?></h6>
    				<small><?php echo date("H:i \- m/d/Y", strtotime($f['date_creation'])); ?></small>
    			</div>
    			<div class="post_content">
            		<?php if (!empty($f['url'])): ?>
            			<div class="image">
            				<img class="img img-thumbnail img-responsive" src="<?php echo BASE_URL."assets/images/posts/".$f['url']; ?>" />
            			</div>
        			<?php endif; ?>
        			<div class="content"><?php echo $f['text']; ?></div>
            		<button class="btn btn-danger" onclick="removePost(this,<?php echo $f['id']; ?>)">Remove</button>
        		</div>
    		</div>
    		
		<?php endforeach; ?>
	</div>
	
	
	<div class="col-sm-4">
		<?php if (!empty($friendshipRequests)): ?>
    		<div class="widget">
    			<h4>Friend requests</h4>
    			<div class="content">
    				<?php foreach ($friendshipRequests as $friend): ?>
            			<div class="friendRequest">
                			<div class="request_name"><?php echo $friend['name']; ?></div>
                			<div class="request_action">
                				<button class="btn btn-outline-success" onclick="acceptFriend(this,<?php echo $friend['id']; ?>)">Accept</button>
                				<button class="btn btn-outline-danger" onclick="rejectFriend(this,<?php echo $friend['id']; ?>)">Reject</button>
                			</div>
                		</div>
            		<?php endforeach; ?>
        		</div>
    		</div>
		<?php endif; ?>
		
    	<div class="widget">
    		<h4>Friend suggestions</h4>
    		<div class="content">
    			<?php foreach ($friendSuggestions as $suggestion): ?>
            		<div class="suggestion">
            			<div class="suggestion_name"><?php echo $suggestion['name']; ?></div>
            			<div class="suggestion_action">
            				<button class="btn btn-outline-primary" onclick="addFriend(this,<?php echo $suggestion['id']; ?>)">+</button>
        				</div>
            		</div>
    			<?php endforeach; ?>
    		</div>
    	</div>
    	
    	<div class="widget">
    		<h4>Friends (<?php echo count($friends); ?>)</h4>
    		<div class="content friends">
    			<?php foreach ($friends as $friend): ?>
            		<div class="friend">
            			<div class="friend_name"><?php echo $friend['name']; ?></div>
            			<div class="friend_action">
            				<button class="btn btn-outline-danger" onclick="removeFriend(this,<?php echo $friend['id']; ?>)">-</button>
        				</div>
            		</div>
    			<?php endforeach; ?>
    		</div>
    	</div>
	</div>
</div>