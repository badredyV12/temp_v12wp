<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    // Define an array of color replacements
    var colorReplacements = [
        { targetColor: '#1eb0fc', replacementColor: '#3D854A' }, // bleu 
		
        // Add more color replacements as needed
    ];

    // Function to replace a color in CSS text
    function replaceColorInCSS(cssText, targetColor, replacementColor) {
        return cssText.replace(new RegExp(targetColor, 'g'), replacementColor);
    }

    // Iterate through all elements with inline styles
    $('*').each(function() {
        var inlineStyle = $(this).attr('style');
        if (inlineStyle) {
            for (var i = 0; i < colorReplacements.length; i++) {
                var replacement = colorReplacements[i];
                inlineStyle = replaceColorInCSS(inlineStyle, replacement.targetColor, replacement.replacementColor);
            }
            $(this).attr('style', inlineStyle);
        }
    });

    // Iterate through all external stylesheets
    $('link[rel="stylesheet"]').each(function() {
        var stylesheetUrl = $(this).attr('href');
        $.ajax({
            url: stylesheetUrl,
            dataType: 'text',
            success: function(cssText) {
                for (var i = 0; i < colorReplacements.length; i++) {
                    var replacement = colorReplacements[i];
                    cssText = replaceColorInCSS(cssText, replacement.targetColor, replacement.replacementColor);
                }
                var styleTag = $('<style>').text(cssText);
                $('head').append(styleTag);
            }
        });
    });
});


</script>
<!-- end Simple Custom CSS and JS -->
