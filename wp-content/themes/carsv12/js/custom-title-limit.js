jQuery(document).ready(function($) {
    $('.limited-title').each(function() {
        var maxLength = 30; // Set your desired character limit here
        var text = $(this).text();
        if (text.length > maxLength) {
            var trimmedText = text.substring(0, maxLength) + '...';
            $(this).text(trimmedText);
        }
    });
});
