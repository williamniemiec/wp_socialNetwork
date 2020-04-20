function addFriend(obj,id) 
{
	//alert(id);
	$(obj).closest('.suggestion').fadeOut();
	
	$.ajax({
		type:"POST",
		url:BASE_URL+"ajax/add_friend",
		data: {id: id},
	});
}

function removeFriend(obj,id)
{
	//alert(id);
	$(obj).closest('.friend').fadeOut();
	
	$.ajax({
		type:"POST",
		url:BASE_URL+"ajax/remove_friend",
		data:{id:id}
	});
}

function acceptFriend(obj,id)
{
	var friendName = $(obj).closest(".friendRequest").find(".request_name").html();
	
	// Removes request
	$(obj).closest(".friendRequest").fadeOut();
	
	// Adds friend
	var friendInfo = `<div class="friend"><div class="friend_name">${friendName}</div>`;
	friendInfo += `<div class="friend_action"><button class="btn btn-outline-danger" onclick="removeFriend(this,${id})">-</button></div></div>`;
	
	$(".friends").hide().prepend(friendInfo).fadeIn();
	
	
	$.ajax({
		type:"POST",
		url:BASE_URL+"ajax/accept_friend",
		data:{id:id}
	});
}

function removePost(obj,id)
{
	$(obj).closest(".post").fadeOut();
	
	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/remove_post",
		data:{id: id}
	});
}

function likePost(obj,id)
{
	var totalLikes = parseInt($(obj).attr("data-totalLikes"));
	
	totalLikes += 1;
	$(obj).attr("onclick", `unlikePost(this,${id})`);
	$(obj).html(`(${totalLikes}) Unlike`);
	$(obj).attr("data-totalLikes", totalLikes);
	
	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/like_post",
		data:{id:id}
	});
}

function unlikePost(obj,id)
{
	var totalLikes = parseInt($(obj).attr("data-totalLikes"));
	
	totalLikes -= 1;
	$(obj).attr("onclick", `likePost(this,${id})`);
	$(obj).html(`(${totalLikes}) Like`);
	$(obj).attr("data-totalLikes", totalLikes);
	
	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/unlike_post",
		data:{id:id}
	});
}

function commentPost(obj)
{
	$(obj).closest(".post").find(".comments").toggle("fast");
}

function sendComment(obj,id)
{
	var name = $(obj).closest("body").find(".profile_name").html();
	var text = $(obj).closest(".comment_form").find("textarea").val();
	var date = new Date();
	
	// Formats date in this format: HH:MM - MM/DD/YYYY
	date = ('0' + date.getHours()).slice(-2) + ":"
	+ ('0' + date.getMinutes()).slice(-2) + " - "
	+ ('0' + (date.getMonth()+1)).slice(-2) + '/'
	+ ('0' + date.getDate()).slice(-2) + '/'
    + date.getFullYear();
	
	
	
	$.ajax({
		type:"POST",
		url:BASE_URL+"ajax/add_comment_post",
		data:{id_post:id, text:text},
		success:function(data) {
			// Generates html from the added comment
			var comment = `
				<div class="comment">
					<div class="comment_info">
						<div class="comment_userInfo">
							<h6>${name}</h6>
							<small>${date}</small>
						</div>
						<button class="btn btn-danger pull-right" onclick="deleteComment(this,${data})">X</button>
					</div>
					<div class="content">${text}</div>
				</div>
			`;
			
			$(obj).closest(".comment_form").append(comment);
			
			// Updates comment counter
			var button = $(obj).closest(".post_content").find(".btn_comment");
			var totalComments = parseInt(button.attr("data-totalComments"));
			totalComments += 1;
			button.html(`(${totalComments}) Comment`);
			button.attr("data-totalComments", totalComments);
		}
	});
}

function deleteComment(obj,id)
{
	var button = $(obj).closest(".post_content").find(".btn_comment");
	var totalComments = parseInt(button.attr("data-totalComments"));
	totalComments -= 1;
	button.html(`(${totalComments}) Comment`);
	button.attr("data-totalComments", totalComments);
	
	$(obj).closest(".comment").fadeOut("fast");
	
	$.ajax({
		type:"POST",
		url:BASE_URL+"ajax/delete_comment_post",
		data:{id_comment:id}
	});
}

function createGroup(obj)
{
	var title = $(obj).closest(".modal-body").find("input[name='group-title']").val();

	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/create_group",
		data:{title:title},
		success:function(id) {			
			$(obj).closest("#create_group").modal("toggle");
			
			var html_group = `
				<div class="group">
        			<div class="group_name">${title}</div>
        			<div class="group_action">
        				<button class="btn btn-outline-danger" onclick="deleteGroup(this,${id})">Delete</button>
    				</div>
        		</div>
			`;
			
			$(obj).closest(".widget").find("button[data-toggle='modal']").after(html_group);
		}
	});
}

function exitGroup(obj,id_group)
{
	var html_btn = `<button class="btn btn-outline-primary" onclick="enterGroup(this,${id_group})">Enter</button>`;
		
	$(obj).hide("fast");
	$(obj).closest(".action").append(html_btn);
	
	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/exit_group",
		data:{id_group:id_group},
	});
}

function deleteGroup(obj,id_group)
{
	$(obj).closest(".group").fadeOut("fast");
	
	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/delete_group",
		data:{id_group:id_group},
	});
}

function enterGroup(obj,id_group)
{
	var html_btn = `<button class="btn btn-outline-warning" onclick="exitGroup(this,${id_group})">Exit</button>`;
	
	$(obj).hide("fast");
	$(obj).closest(".action").append(html_btn);
	
	$.ajax({
		type:'POST',
		url:BASE_URL+"ajax/join_group",
		data:{id_group:id_group},
	});
}