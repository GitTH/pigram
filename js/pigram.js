var imgs = $(".image");
var feed = "data/feed.php?images_to_get=" + imgs.length;
//basic config section
var minFade = 0.45; //minimum desired opacity of images (0 to 1)
var fadeDuration = 500; //time taken by fade effect (milliseconds)
var fadeDelay = 10000; //time each image will be at 100% opacity (milliseconds)
var loadingTimeout = 7000; //time until images that have not loaded are disabled (milliseconds)
var refreshTimer = 180000; //time until feed refreshes (milliseconds)
var twinkleTimer = (feed * fadeDuration) + fadeDelay;

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
	 	type: "GET",
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
						$(this).attr('src','images/no_image.svg');
						//deactivateImage($(this).attr('data-instagram_shortcode'));
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
	var url = "data/deactivate.php?instagram_shortcode="+instagram_shortcode;
	
	$.ajax({
	 	url: url,
	 	type: "GET"
	 });	
}

//randomise image array
function shuffle(a){
  for(var j, x, i = a.length; i; j = (Math.random() * i) | 0, x = a[--i], a[i] = a[j], a[j] = x);
  return a;
}

//animation callback to start next fade-in
function nextItemFade(items){
  //fade-in the first element in the collection
  items.eq(0).fadeTo(fadeDuration, 1, function(){
    //recurse, but without the first element
    nextItemFade(items.slice(1));
  }).delay(fadeDelay).fadeTo(fadeDuration, minFade);
}

function twinkle(){
  $(".image").fadeTo(fadeDuration, minFade);
  shuffle(imgs);
  nextItemFade(imgs);
}

$(document).ready(function(){
  pigram();
  setInterval(pigram, refreshTimer);
  setInterval(twinkle, twinkleTimer);
  twinkle();
});