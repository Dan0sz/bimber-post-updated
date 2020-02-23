<?php
/**
 * @formatter:off
 * Plugin Name: Post Last Updated for Bimber
 * Plugin URI: https://daan.dev/wordpress/post-last-updated
 * Description: Display 'Last Updated' date along with 'Date Published' in WordPress.
 * Version: 1.0.1
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

    $modified_datetime  = get_post_datetime($post->ID, 'modified');
    $published_datetime = get_post_datetime($post->ID);

    if ($modified_datetime <= $published_datetime) {
        return $html;
    }

    $updated_string          = __('Updated', 'bimber-post-updated');
    $before                  = '(' . $updated_string . ': ';
    $after                   = ')';
    $modified_ymd            = $modified_datetime->format('Y-m-d');
    $modified_human_readable = $modified_datetime->format(get_option('date_format'));

    $updated_html = $before . sprintf(
            '<time class="entry-date" datetime="%s" itemprop="dateModified">%s</time>',
            esc_attr($modified_ymd),
            esc_attr($modified_human_readable)
        ) . $after;

    return $html . $updated_html;
}

add_filter('bimber_entry_date_html', 'daan_add_last_updated_date_time', null, 2);
