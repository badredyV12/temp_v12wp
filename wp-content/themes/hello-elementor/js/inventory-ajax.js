jQuery(document).ready(function($) {
    $('#search-input').on('keyup', function() {
        var searchTerm = $(this).val();
        $.ajax({
            url: inventory_ajax.ajax_url,
            type: 'post',
            data: {
                action: 'inventory_search',
                search_term: searchTerm
            },
            success: function(response) {
                $('#vehicle-list').html(response);
            }
        });
    });
});
