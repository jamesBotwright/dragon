/**
 * Fade spinner when loaded
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
$(window).on('load', function() {
	$(".se-pre-con").fadeOut("slow");
});

/**
 * Bind loading GIF to AJAX events
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
$(document).ready(onLoadFunction)
.on('ajaxStart', function(){
    $('.se-pre-con').fadeIn();
})
.on('ajaxStop', function(){
    $('.se-pre-con').fadeOut('slow');
});
