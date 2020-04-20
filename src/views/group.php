<!-- Title + total of members -->
<h1><?php echo $groupName; ?> (<?php echo $totalMembers == 1 ? "$totalMembers member" : "$totalMembers members"; ?>)</h1>

<div class="row">
    <!-- Center area -->
	<div class="col-sm-8">
		<h4>Posts</h4>
		
		<!-- Post input -->
		<div class="post_area">
			<h5>What are you thinking?</h5>
			<form method="POST" enctype="multipart/form-data">
				<textarea class="form-control" name="message"></textarea><br />
				<input class="form-control" type="file" name="image" accept="image/*" /><br />
				<input class="btn btn-primary btn-block" type="submit" value="Post" />
			</form>	
		</div>
    	
    	<!-- Posts -->
    	<?php foreach($posts as $p) {
    	    $this->loadView("postView", $p);
    	} ?>
    	
    	<!-- Pagination -->
    	<ul class="pagination pagination-sm justify-content-center">
    		<li class="page-item <?php echo $page == 1 ? "disabled" : "" ?>">
    			<a href="<?php echo $currentURL."?p=".intval($page-1); ?>" class="page-link">Previous</a>
    		</li>
    		
    		<?php for($i=1; $i<=$totalPages; $i++): ?>
    			<li class="page-item <?php echo $i == $page? "active" : "" ?>">
    				<a href="<?php echo $currentURL."?p=$i"; ?>" class="page-link"><?php echo $i; ?></a>
    			</li>
    		<?php endfor; ?>
    		
    		<li class="page-item <?php echo $page == $totalPages ? "disabled" : "" ?>"><a href="<?php echo $currentURL."?p=".intval($page+1); ?>" class="page-link">Next</a></li>
    	</ul>
	</div>
	
	<!-- Right area -->
	<div class="col-sm-4">
		<!-- Members of the group -->
		<div class="widget">
			<h4>Members</h4>
			<div class="content">
				<?php foreach($members as $member): ?>
        			<div class="member">
            			<a href=<?php echo BASE_URL."profile/open/".$member['id_member']; ?>><div class="member_name"><?php echo $member['name']; ?></div></a>
            		</div>
        		<?php endforeach; ?>
    		</div>
		</div>
	</div>
</div>