function pigram() {

	var imgs = $(".image").length;
	var feed = "data/feed.php?images_to_get=" + imgs;

	if ($("#image0").length == 0) {
		var cnt = 0;
		$(".image").each(function(){
			$("img",this).attr('id', "image"+cnt);
			cnt++;
		});		
	}

	$.ajax({
	 	url: feed,
	 	data: {},
	 	dataType: "json",
	 	type: "GET",
	 	success: function(JsonFeed){
	 		
	 		//assign images to the layout
	 		$.each(JsonFeed,function(key,val){
	 			$("#image"+key).attr('src', val.url);
	 			$("#image"+key).attr('data-instagram_id', val.instagram_id);
	 		});	
	 		
	 	},
	 	complete: function(){
	 	
	 		//after 1 second see if any images have not loaded and deactivate them
	 		setTimeout(function() {
		 		$("img").each(function(){ 
					var image = $(this); 
					if(image.context.naturalWidth == 0 || image.readyState == 'uninitialized'){
						$(this).attr('src','images/no_image.svg');
						deactivateImage($(this).attr('data-instagram_id'));
					}
				});
			}, 1000); 	
	 				 	
	 	},
	 	error: function(xhr, ajaxOptions, thrownError){
		 	console.error(xhr.status);
		 	console.error(thrownError);
	 	}
	 });

}

function deactivateImage(instagram_id) {
	
	var url = "data/deactivate.php?instagram_id="+instagram_id;
	
	$.ajax({
	 	url: url,
	 	type: "GET"
	 });	
}

$(document).ready(function(){
	
	pigram();
	
});