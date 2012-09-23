$(function() {
	hideMessages();
});

function hideMessages() {
	$('#messages .message').each(function() {
		var self = this;
		setTimeout(function() {
			$(self).slideUp('fast', function() {
				$(self).remove();
			});
		}, 8000);
	});
}
