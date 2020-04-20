<h1>HOME</h1>

<!-- Shows error message if there is one -->
<?php if (!empty($noMember)): ?>
	<div class="alert alert-danger fade show">
		<?php echo $noMember; ?>
		<button class="close" data-dismiss="alert">&times;</button>
	</div>
<?php endif; ?>

<div class="row">
	<!-- Center area -->
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
    	
    	<?php foreach($posts as $p) {
    	    $this->loadView("postView", $p);
    	} ?>
    	
    	<ul class="pagination pagination-sm justify-content-center">
    		<li class="page-item <?php echo $page == 1 ? "disabled" : "" ?>">
    			<a href="<?php echo BASE_URL."?p=".intval($page-1); ?>" class="page-link">Previous</a>
    		</li>
    		
    		<?php for($i=1; $i<=$totalPages; $i++): ?>
    			<li class="page-item <?php echo $i == $page? "active" : "" ?>">
    				<a href="<?php echo BASE_URL."?p=$i"; ?>" class="page-link"><?php echo $i; ?></a>
    			</li>
    		<?php endfor; ?>
    		
    		<li class="page-item <?php echo $page == $totalPages ? "disabled" : "" ?>"><a href="<?php echo BASE_URL."?p=".intval($page+1); ?>" class="page-link">Next</a></li>
    	</ul>
	</div>
	
	<!-- Right area -->
	<div class="col-sm-4">
		<!-- Friendship requests -->
		<?php if (!empty($friendshipRequests)): ?>
    		<div class="widget">
    			<h4>Friend requests</h4>
    			<div class="content">
    				<?php foreach ($friendshipRequests as $friend): ?>
            			<div class="friendRequest">
                			<div class="request_name">
                				<a href="<?php echo BASE_URL."profile/open/".$friend['id']; ?>"><?php echo $friend['name']; ?></a>
            				</div>
                			<div class="request_action">
                				<button class="btn btn-outline-success" onclick="acceptFriend(this,<?php echo $friend['id']; ?>)">Accept</button>
                				<button class="btn btn-outline-danger" onclick="rejectFriend(this,<?php echo $friend['id']; ?>)">Reject</button>
                			</div>
                		</div>
            		<?php endforeach; ?>
        		</div>
    		</div>
		<?php endif; ?>
		
		<!-- Friend suggestions -->
    	<div class="widget">
    		<h4>Friend suggestions</h4>
    		<div class="content">
    			<?php foreach ($friendSuggestions as $suggestion): ?>
            		<div class="suggestion">
            			<div class="suggestion_name">
            				<a href="<?php echo BASE_URL."profile/open/".$suggestion['id']; ?>"><?php echo $suggestion['name']; ?></a>
        				</div>
            			<div class="suggestion_action">
            				<button class="btn btn-outline-primary" onclick="addFriend(this,<?php echo $suggestion['id']; ?>)">+</button>
        				</div>
            		</div>
    			<?php endforeach; ?>
    		</div>
    	</div>
    	
    	<!-- Friends -->
    	<div class="widget">
    		<h4>Friends (<?php echo count($friends); ?>)</h4>
    		<div class="content friends">
    			<?php foreach ($friends as $friend): ?>
            		<div class="friend">
            			<div class="friend_name">
            				<a href="<?php echo BASE_URL."profile/open/".$friend['id']; ?>"><?php echo $friend['name']; ?></a>
        				</div>
            			<div class="friend_action">
            				<button class="btn btn-outline-danger" onclick="removeFriend(this,<?php echo $friend['id']; ?>)">-</button>
        				</div>
            		</div>
    			<?php endforeach; ?>
    		</div>
    	</div>
    	
    	<!-- Groups -->
    	<div class="widget">
    		<h4>Groups</h4>
    		<div class="content">
				<button class="btn btn-outline-primary" data-toggle="modal" data-target="#create_group">Create</button>
				
				<?php foreach ($groups as $group): ?>
            		<div class="group">
            			<div class="name">
            				<a href="<?php echo BASE_URL."groups/open/".$group['id']; ?>"><?php echo $group['title']; ?></a>
        				</div>
            			<div class="action">
            				<?php if ($group['isOwner']): ?>
            					<button class="btn btn-outline-danger" onclick="deleteGroup(this,<?php echo $group['id']; ?>)">Delete</button>
            				<?php endif; ?>
            				
            				<?php if ($group['isMember'] && !$group['isOwner']): ?>
            					<button class="btn btn-outline-warning" onclick="exitGroup(this,<?php echo $group['id']; ?>)">Exit</button>
            				<?php else: if (!$group['isMember'] && !$group['isOwner']): ?>
            					<button class="btn btn-outline-primary" onclick="enterGroup(this,<?php echo $group['id']; ?>)">Enter</button>
            				<?php endif;endif; ?>
        				</div>
            		</div>
        		<?php endforeach; ?>
        		
        		<!-- Create group form -->
				<div id="create_group" class="modal fade">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Create new group</h3>
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<div class="form-group">
										<label for="group-title">Title</label>
										<input id="group-title" type="text" name="group-title" class="form-control" />
									</div>
									<div class="form-group">
										<button class="btn btn-primary btn-block" onclick="createGroup(this)">Create</button>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div><!-- end create group form -->
    		</div>
    	</div><!-- end groups -->
	</div><!-- end right area -->
</div>