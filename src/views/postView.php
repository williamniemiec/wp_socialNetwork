<div class="post">
	<div class="post_info">
		<div class="post_userInfo">
    		<h6>
    			<a href="<?php echo BASE_URL."profile/open/".$id_user; ?>"><?php echo $name; ?></a>
			</h6>
    		<small><?php echo date("H:i \- m/d/Y", strtotime($date_creation)); ?></small>
    		<?php echo $groupName? "<small class='group_name'>".$groupName."</small>" : "" ?><h6>
		</div>
		<?php if ($id_user == $_SESSION['fb_login']): ?>
			<button class="btn btn-danger pull-right" onclick="removePost(this,<?php echo $id; ?>)">X</button>
		<?php endif; ?>
	</div>
	
	<div class="post_content">
		<?php if (!empty($url)): ?>
			<div class="image">
				<img class="img img-thumbnail img-responsive" src="<?php echo BASE_URL."assets/images/posts/".$url; ?>" />
			</div>
		<?php endif; ?>
		<div class="content"><?php echo $text; ?></div>
		<div class="btn-group">
			<?php if ($liked): ?>
				<button class="btn btn-primary" data-totalLikes="<?php echo $totalLikes; ?>" onclick="unlikePost(this,<?php echo $id; ?>)">
					(<?php echo $totalLikes; ?>) Unlike
				</button>
			<?php else: ?>
				<button class="btn btn-primary" data-totalLikes="<?php echo $totalLikes; ?>" onclick="likePost(this,<?php echo $id; ?>)">
					(<?php echo $totalLikes; ?>) Like
				</button>
			<?php endif; ?>
			<button class="btn btn-success btn_comment" data-totalComments="<?php echo count($comments); ?>" onclick="commentPost(this)">
				(<?php echo count($comments); ?>) Comment
			</button>
		</div>
		
		<div class="comments">
			<div class="comment_form">
				<textarea class="form-control" name="comment"></textarea>
				<button class="btn btn-primary btn-block" onclick="sendComment(this,<?php echo $id; ?>)">Comment</button>
			</div>	
			
			<?php foreach ($comments as $comment): ?>
    			<div class="comment">
    				<div class="comment_info">
    					<div class="comment_userInfo">
    						<h6><?php echo $comment['name']; ?></h6>
        					<small><?php echo date("H:i \- m/d/Y", strtotime($comment['date_creation'])); ?></small>
    					</div>
    					<?php if ($comment['id_user'] == $_SESSION['fb_login']): ?>
                			<button class="btn btn-danger pull-right" onclick="deleteComment(this,<?php echo $comment['id']; ?>)">X</button>
                		<?php endif; ?>
    				</div>
    				<div class="content"><?php echo $comment['text']; ?></div>
    			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>