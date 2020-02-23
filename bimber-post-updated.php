<?php
/**
 * @formatter:off
 * Plugin Name: Post Last Updated for Bimber
 * Plugin URI: https://daan.dev/wordpress/post-last-updated
 * Description: Display 'Last Updated' date along with 'Date Published' in WordPress.
 * Version: 1.0.0
 * Author: Daan van den Bergh
 * Author URI: https://daan.dev
 * License: GPL2v2 or later
 * Text Domain: bimber-post-updated
 * @formatter:on
 */

function daan_add_last_updated_date_time($html, $args)
{
    global $post;

    $post_id = get_queried_object_id();

    // Make sure to only apply this filter on the current post, and not 'recent posts' widgets, etc.
    if ($post_id != $post->ID) {
        return $html;
    }

    $updated_html = sprintf(
        '<time class="entry-date" datetime="%s" itemprop="dateModified">%s</time>',
        esc_attr(get_the_modified_date( 'Y-m-d' )),
        esc_html(the_modified_date(get_option('date_format'), '(' . __('Updated', 'bimber-post-updated') . ': ', ')', false))
    );

    return $html . $updated_html;
}

add_filter('bimber_entry_date_html', 'daan_add_last_updated_date_time', null, 2);
