/**
 * Fade loading GIF when page loaded
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 24 Jun 2017
 */
$(window).on('load', function() {
	$(".se-pre-con").fadeOut("slow");
});

/**
 * Bind loading GIF to AJAX events
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 24 Jun 2017
 */
$(document).ready(onLoadFunction)
.on('ajaxStart', function(){
    $('.se-pre-con').fadeIn();
})
.on('ajaxStop', function(){
    $('.se-pre-con').fadeOut('slow');
});

/**
 * Initialisation
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
function onLoadFunction() {        
    
}

/**
 * Prevent default form action and submit with JS
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 25 Jun 2017
 */
$('#add-song-form').on('submit',function(e) {
	e.preventDefault();
	submitAddSongForm()
	.done(function() {
        refreshSuggestedSongs().done(function() {
            onLoadFunction();
        });
	});
});

/**
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 26 Jun 2017
 */
function submitAddSongForm() {
	return $.ajax({
		url: '/application/addSong',
		type: "POST",
		data: $('#add-song-form').serialize(),
		success: function(data, textStatus, jXHR) {
            $("#suggested-songs-table").html(data);
		},
		error: function(jXHR, textStatus, errorThrown) {
			if (jXHR.status == 401) {
				$("#add-song-form").html(jXHR.responseText);
			} else {
				failureRedirect();
			}
		}
	});
}
