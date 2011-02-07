
// remap jQuery to $
(function($){

 





 



})(this.jQuery);



// usage: log('inside coolFunc',this,arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console){
    console.log( Array.prototype.slice.call(arguments) );
  }
};



// catch all document.write() calls
(function(doc){
  var write = doc.write;
  doc.write = function(q){ 
    log('document.write(): ',arguments); 
    if (/docwriteregexwhitelist/.test(q)) write.apply(doc,arguments);  
  };
})(document);


//carousel
$(document).ready(function() {	
var counter = $("#carouseldiv div.box").length;
	try {
		var oHandlerHorizontal = $("#carouseldiv").msCarousel({boxClass:'div.box', width:960, height:163, scrollSpeed:500, autoSlide:6000}).data("msCarousel");
		$("#play").click(function() {
			oHandlerHorizontal.play();
			$("#play").hide();
			$("#pause").show();
		});
		$("#pause").click(function() {
			oHandlerHorizontal.pause();		
			$("#play").show();
			$("#pause").hide();			
		});
		
	} catch(e) {
		alert(e);
		alert(e.message);
	}
	
})