var imgs = $(".image");
var feed = "data/feed.php?images_to_get=" + imgs.length;

function pigram(){
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
	 	method: "GET",
	 	success: function(JsonFeed){
	 		//assign images to the layout
	 		$.each(JsonFeed,function(key,val){
  	 		//Use larger images for key images
        if($("#image"+key).parent().hasClass('image-lg') == true) {
          val.url = 'http://instagram.com/p/'+val.instagram_shortcode+'/media/?size=l';
        }
        $("#image"+key).attr('src', val.url);
        $("#image"+key).attr('instagram_shortcode', val.instagram_shortcode);
	 		});
	 	},
	 	complete: function(){
	 		setTimeout(function() {
		 		$("img").each(function(){ 
					var image = $(this); 
					if(image.context.naturalWidth == 0 || image.readyState == 'uninitialized'){
						$(this).attr('src',timeoutImage);
						//deactivateImage($(this).attr('instagram_shortcode'));
					}
				});
			}, loadingTimeout);
	 	},
	 	error: function(xhr, ajaxOptions, thrownError){
		 	console.error(xhr.status);
		 	console.error(thrownError);
	 	}
	 });
}

function deactivateImage(instagram_shortcode) {
  $.get("data/deactivate.php?instagram_shortcode="+instagram_shortcode);
}

//randomise image array
function shuffle(a){
  for(var j, x, i = a.length; i; j = (Math.random() * i) | 0, x = a[--i], a[i] = a[j], a[j] = x);
  return a;
}

//animation callback to start next fade-in
function nextItemFade(items){
  setTimeout(function(){
    //fade-in the first element in the collection
    items.eq(0).fadeTo(fadeDuration, 1, function(){
      //recurse, but without the first element
      nextItemFade(items.slice(1));
    }).delay(brightDuration).fadeTo(fadeDuration, minFade);
  },nextDelay)
  //randomise and restart the animations after cycling through every image
  if(items.length==0) {
    setTimeout(twinkle, brightDuration + fadeDuration);
  }
}

function twinkle(){
  shuffle(imgs);
  nextItemFade(imgs);
}

$(document).ready(function(){
  pigram();
  setInterval(pigram, refreshTimer);
  $(".image").fadeTo(fadeDuration, minFade);
  twinkle();
});