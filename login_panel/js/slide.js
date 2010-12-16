$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("fast");
	
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("fast");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});		
	
	$('.notification span').click(function() {
	   jQuery(this).parents('.notification').fadeOut(800);
	});
	
	
	$('.notification').hover(function() {
    jQuery(this).css('cursor','pointer');
  }, function() {
    jQuery(this).css('cursor','auto');
  }); // Close notifications
});