<?php

// Callback function for the webhook endpoint
function vehicle_webhook_callback($request) {
    try {
        // Get query parameters from the request (vehicle ID)
        $id = $request->get_param('id');
        // Check if 'id' is provided in the query parameters
        if (empty($id)) {
            return new WP_Error('missing_id', 'Missing id', array('status' => 400));
        }
    
        // Query for posts based on the custom field 'id'
        $args = array(
            'post_type' => 'vehicles',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => 'id',
                    'value' => $id,
                    'compare' => '='
                ),
            ),
        );
    
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                wp_delete_post(get_the_ID(), true);
            }
            wp_reset_postdata();
    
            $response = array(
                'message' => "The vehicle $id deleted successfully.",
            );
    
            return rest_ensure_response($response);
        } else {
            $response = array(
                'message' => "The vehicle $id not found.",
            );
    
            return rest_ensure_response($response);
        }
    } catch (Exception $e) {
        return new WP_Error('error', $e->getMessage() , array('status' => 500));
    }
}
