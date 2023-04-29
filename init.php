<?php
/*
Plugin Name: Disable Slug Edit for Non Admin
Description: Disables the slug editing capability for the Non Admin user role.
Version: 1.0
Author: Ryan Aby
*/

function restrict_slug_editing_for_non_admins( $data, $postarr ) {
    if (!is_numeric($postarr['ID'])) {
        wp_die( __( 'You are not allowed to edit the post slug.', 'yml' ) );
    }

    $post = get_post($postarr['ID']);
    $original_slug = $post->post_name;

    if ( ! current_user_can( 'manage_options' ) ) {
        if ( ($postarr['post_type'] == 'post' || $postarr['post_type'] == 'page') && $postarr['post_name'] != $original_slug ) {
            wp_die( __( 'You are not allowed to edit the post slug.', 'yml' ) );
        }
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'restrict_slug_editing_for_non_admins', 10, 2 );

?>
