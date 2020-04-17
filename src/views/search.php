<h1>Search for "<?php echo $search; ?>"</h1>
<div class="results">
	<?php foreach ($response as $result): ?>	
    	<div class="result">
    		<div class="search_info">
        		<h3 class="search_name">
        			<a href="<?php echo BASE_URL."profile/open/".$result['id']; ?>"><?php echo $result['name']; ?></a>
    			</h3>
    			<div class="search_option">
    				<?php if ($result['isFriend'] == "0"): ?>
    					<button class="btn btn-outline-primary" onclick="addFriend(this,<?php echo $result['id']; ?>)">+</button>
    				<?php else: ?>
    					<button class="btn btn-outline-danger" onclick="removeFriend(this,<?php echo $result['id']; ?>)">-</button>
					<?php endif; ?>
    			</div>
			</div>
    		<div class="search_bio">
    			<h6>Biography</h6>
    			<div class="content"><?php echo $result['bio']; ?></div>
    		</div>
    	</div>
	<?php endforeach; ?>
	<ul class="pagination pagination-sm justify-content-center">
		<li class="page-item <?php echo $page == 1 ? "disabled" : "" ?>">
			<a href="<?php echo $currentURL."&p=".intval($page-1); ?>" class="page-link">Previous</a>
		</li>
		
		<?php for($i=1; $i<=$totalPages; $i++): ?>
			<li class="page-item <?php echo $i == $page? "active" : "" ?>">
				<a href="<?php echo $currentURL."&p=$i"; ?>" class="page-link"><?php echo $i; ?></a>
			</li>
		<?php endfor; ?>
		
		<li class="page-item <?php echo $page == $totalPages ? "disabled" : "" ?>"><a href="<?php echo $currentURL."&p=".intval($page+1); ?>" class="page-link">Next</a></li>
	</ul>
</div>