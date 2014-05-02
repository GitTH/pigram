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
	 		
	 		console.log("success");
	 		
	 		$.each(JsonFeed,function(key,val){
	 			$("#image"+key).attr('src', val);
	 			console.log(key + " " + val);
	 		});	
	 		
	 	},
	 	complete: function(){		 	
	 				 	
	 	},
	 	error: function(xhr, ajaxOptions, thrownError){
		 	//console.error(xhr.status);
		 	//console.error(thrownError);
	 	}
	 });

}

$(document).ready(function(){
	
	pigram();
	
});