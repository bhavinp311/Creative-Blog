<?php

/**
 * All common functions for layouts
 * For Post Author, Categories, Tags, Comment Count, and Social Share etc.
 */
/**
 * Function that returns post author
 * 
 * @since 1.0
 * 
 * @param type string  $author_avatar Icon or Avatar
 * 
 * @return type string $posted_by     Author HTML
 * 
 */
if (!function_exists('cbdb_posted_by')) {

    function cbdb_posted_by($author_avatar = '', $author_by = '') {
        $posted_by = '';
        $posted_by .= '<div class="cbdb-meta">';
        if (!empty($author_by)) {
            $posted_by .= esc_html__($author_by . ' ', CBDB_TEXTDOMAIN);
        }
        $posted_by .= '<span class="cbdb-byauthor">';
        if ($author_avatar == 'icon') {
            $posted_by .= '<i class="fas fa-user-alt" aria-hidden="true"></i>';
        }
        if ($author_avatar == 'avatar') {
            $posted_by .= get_avatar(get_the_author_meta('ID'), 40);
        }
        $posted_by .= '<span class="screen-reader-text">' . esc_html__('Posted by', CBDB_TEXTDOMAIN) . '</span>
                        <span class="author vcard">
                            <a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>
                        </span>
                </span></div>';
        return $posted_by;
    }

}

/**
 * Function that returns post title HTML tag
 * 
 * @since 1.0
 * 
 * @param type string  $post_title_tag          Post title HTML tag
 * @param type string  $post_title_link         If post title link is enabled
 * @param type string  $post_title_open_link    Post title open link
 * @param type string  $custom_title_class_name Custom post title class
 * 
 * @return type string $post_title_html         Post title HTML tag
 * 
 */
if (!function_exists('cbdb_post_title_tag')) {

    function cbdb_post_title_tag($post_title_tag = 'h2', $post_title_link = 'yes', $post_title_open_link = '_self', $custom_title_class_name = '') {
        $post_title_html = '';
        $post_title_html .= '<' . $post_title_tag . ' class="cbdb-title ';
        if (isset($post_title_link) && $post_title_link == 'no') {
            $post_title_html .= esc_attr($custom_title_class_name) . '">';
        } else {
            $post_title_html .= '">';
        }
        // If post title link enabled
        if (isset($post_title_link) && $post_title_link == 'yes') {
            $post_title_html .= '<a href="' . esc_url(get_the_permalink()) . '" target="' . esc_attr($post_title_open_link) . '" class="' . esc_attr($custom_title_class_name) . '">';
        }
        $post_title_html .= get_the_title();
        // If post title link enabled
        if (isset($post_title_link) && $post_title_link == 'yes') {
            $post_title_html .= '</a>';
        }
        $post_title_html .= '</' . $post_title_tag . '>';
        return $post_title_html;
    }

}

/**
 * Function that returns placeholder post image
 * 
 * @since 1.0
 * 
 * @param type string  $image_size  Post image size
 * 
 * @return type string $posted_date Post date HTML
 * 
 */
if (!function_exists('cbdb_get_placeholder_post_image')) {

    function cbdb_get_placeholder_post_image($image_size) {
        $placeholder_post_image = '';
        if (is_array($image_size) && !empty($image_size)) {
            $placeholder_post_image_url = esc_url(CBDB_URL . 'assets/images/post-placeholder.jpg');
            $width_height = 'width="' . $image_size[0] . '" height="' . $image_size[1] . '"';
        } else {
            if ($image_size == 'thumbnail') {
                $placeholder_post_image_url = esc_url(CBDB_URL . 'assets/images/post-placeholder-150x150.jpg');
                $width_height = 'width="150" height="150"';
            } elseif ($image_size == 'medium') {
                $width_height = 'width="300" height="300"';
                $placeholder_post_image_url = esc_url(CBDB_URL . 'assets/images/post-placeholder-300x300.jpg');
            } elseif ($image_size == 'medium_large') {
                $width_height = 'width="768" height="300"';
                $placeholder_post_image_url = esc_url(CBDB_URL . 'assets/images/post-placeholder-768x300.jpg');
            } elseif ($image_size == 'large') {
                $width_height = 'width="1024" height="1024"';
                $placeholder_post_image_url = esc_url(CBDB_URL . 'assets/images/post-placeholder-1024x1024.jpg');
            } else {
                $width_height = 'width="1200" height="800"';
                $placeholder_post_image_url = esc_url(CBDB_URL . 'assets/images/post-placeholder.jpg');
            }
        }
        $placeholder_post_image = '<img ' . $width_height . ' src="' . $placeholder_post_image_url . '" alt="Placeholder Post Image">';
        return $placeholder_post_image;
    }

}

/**
 * Function that returns post date
 * 
 * @since 1.0
 * 
 * @param type string  $post_date_link   If post date link is enabled
 * @param type string  $post_date_format Post date format
 * @param type string  $date_on          Post date keyword like 'On'
 * @param type bool    $date_icon        Post date icon is enabled
 * @param type string  $date_class       Post date class
 * 
 * @return type string $posted_date      Post date HTML
 * 
 */
if (!function_exists('cbdb_post_date')) {

    function cbdb_post_date($post_date_link, $post_date_format = '', $date_on = '', $date_icon = false, $date_class = '') {
        $posted_date = '';
        $posted_date .= '<div class="cbdb-date ' . esc_attr($date_class) . '">';
        if ($date_icon) {
            $posted_date .= '<i class="fas fa-calendar-alt" aria-hidden="true"></i>';
        }
        if (!empty($date_on)) {
            $posted_date .= esc_html__($date_on . ' ', CBDB_TEXTDOMAIN);
        }
        // If post date link enabled
        if (isset($post_date_link) && $post_date_link == 'yes') {
            $posted_date .= '<a href="' . esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))) . '">';
        }
        $posted_date .= get_the_date($post_date_format);
        // If post date link enabled
        if (isset($post_date_link) && $post_date_link == 'yes') {
            $posted_date .= '</a>';
        }
        $posted_date .= '</div>';
        return $posted_date;
    }

}

/**
 * Function that returns post categories
 * 
 * @since 1.0
 * 
 * @param type int     $post_id       The post ID
 * @param type string  $post_cat_link If post category link is enabled
 * @param type string  $cat_separator Post category separator
 * @param type bool    $cat_icon      Post category icon
 * 
 * @return type string $all_cats      Post categories HTML
 * 
 */
if (!function_exists('cbdb_posted_categories')) {

    function cbdb_posted_categories($post_id = '', $post_cat_link = '', $cat_separator = '', $cat_icon = false) {
        // Returns all cat items
        $all_cats = '';
        $post_type = get_post_type($post_id);
        $taxonomies = get_object_taxonomies($post_type);
        // Set category index
        $catIndex = 0;
        if ($post_type == 'product') {
            $catIndex = 2;
        }

        // Check if category exists
        if ($taxonomies && is_array($taxonomies) && count($taxonomies) > 0) {
            $terms = wp_get_post_terms($post_id, $taxonomies[$catIndex], array("fields" => "all"));
            // Check if terms exists
            if ($terms) {
                if ($cat_icon) {
                    $all_cats .= '<i class="fa fa-list-alt" aria-hidden="true"></i>';
                }
                // Loop through each terms
                foreach ($terms as $term) {
                    // The $term is an object, so we don't need to specify the $taxonomy
                    $term_link = get_term_link($term);
                    // If there was an error, continue to the next term
                    if (is_wp_error($term_link)) {
                        continue;
                    }
                    // If post cat link yes
                    if ($post_cat_link == 'yes') {
                        $all_cats .= '<a href="' . esc_url($term_link) . '">';
                    }
                    $all_cats .= esc_html__($term->name, CBDB_TEXTDOMAIN);
                    // If post cat link yes
                    if ($post_cat_link == 'yes') {
                        $all_cats .= '</a>';
                    }
                    if (!empty($cat_separator)) {
                        if (str_contains($cat_separator, ',')) {
                            $all_cats .= "{$cat_separator} ";
                        } else {
                            $all_cats .= " {$cat_separator} ";
                        }
                    }
                }
                // Remove separator from end of the string
                $all_cats = rtrim($all_cats, " {$cat_separator} ");
                $all_cats = '<div class="cbdb-category">' . $all_cats . '</div>';
            }
        }
        return $all_cats;
    }

}

/**
 * Function that returns post tags
 * 
 * @since 1.0
 * 
 * @param type int     $post_id       The post ID
 * @param type string  $post_tag_link If post tag link is enabled
 * @param type string  $tag_separator Post tag separator
 * @param type bool    $tag_icon      Post tag icon
 * 
 * @return type string $all_tags      Post tags HTML
 * 
 */
if (!function_exists('cbdb_posted_tags')) {

    function cbdb_posted_tags($post_id = '', $post_tag_link = '', $tag_separator = '', $tag_icon = false) {
        // Returns all tag items
        $all_tags = '';
        $post_type = get_post_type($post_id);
        $taxonomies = get_object_taxonomies($post_type);
        // Set tag index
        $tagIndex = 1;
        if ($post_type == 'product') {
            $tagIndex = 3;
        }

        // Check if tag exists
        if ($taxonomies && is_array($taxonomies) && count($taxonomies) > 0) {
            $terms = wp_get_post_terms($post_id, $taxonomies[$tagIndex], array("fields" => "all"));
            // Check if terms exists
            if ($terms) {
                if ($tag_icon) {
                    $all_tags .= '<i class="fas fa-tag" aria-hidden="true"></i>';
                }
                // Loop through each terms
                foreach ($terms as $term) {
                    // The $term is an object, so we don't need to specify the $taxonomy
                    $term_link = get_term_link($term);
                    // If there was an error, continue to the next term
                    if (is_wp_error($term_link)) {
                        continue;
                    }
                    // If post tag link yes
                    if ($post_tag_link == 'yes') {
                        $all_tags .= '<a href="' . esc_url($term_link) . '">';
                    }
                    $all_tags .= esc_html__($term->name, CBDB_TEXTDOMAIN);
                    // If post tag link yes
                    if ($post_tag_link == 'yes') {
                        $all_tags .= '</a>';
                    }
                    if (!empty($tag_separator)) {
                        if (str_contains($tag_separator, ',')) {
                            $all_tags .= "{$tag_separator} ";
                        } else {
                            $all_tags .= " {$tag_separator} ";
                        }
                    }
                }
                // Remove separator from end of the string
                $all_tags = rtrim($all_tags, " {$tag_separator} ");
                $all_tags = '<div class="cbdb-tags">' . $all_tags . '</div>';
            }
        }
        return $all_tags;
    }

}

/**
 * Function that returns comment count
 * 
 * @since 1.0
 * 
 * @param void
 * 
 * @return type string Comment count HTML
 * 
 */
if (!function_exists('cbdb_comment_count')) {

    function cbdb_comment_count() {
        if (!post_password_required() && (comments_open() || get_comments_number())) {
            echo '<div class="cbdb-meta"><span class="cbdb-comments-link">';
            echo '<i class="fas fa-comment" aria-hidden="true"></i>';
            /* translators: %s: Name of current post. Only visible to screen readers. */
            comments_popup_link(sprintf(esc_html__('Leave a comment', CBDB_TEXTDOMAIN) . '<span class="screen-reader-text">' . esc_html__('on %s', CBDB_TEXTDOMAIN) . '</span>', get_the_title()));
            echo '</span></div>';
        }
    }

}

/**
 * Function that returns social share
 * 
 * @since 1.0
 * 
 * @param type string  $social_share_style Social share style (round or square)
 * 
 * @return type string $social_share       Social share HTML
 * 
 */
if (!function_exists('cbdb_social_share')) {

    function cbdb_social_share($social_share_style) {
        $social_share = '';
        $social_share = '<div class="cbdb-social-share">
            <a href="' . esc_url('https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink()) . '" target = "' . esc_attr('_blank') . '">
                <img src="' . esc_url(CBDB_URL . 'assets/images/social/facebook-' . $social_share_style . '.svg') . '" width="30" height="30" alt="' . esc_attr('Facebook-' . $social_share_style, CBDB_TEXTDOMAIN) . '">
            </a>
            <a href="' . esc_url('https://twitter.com/intent/tweet?url=' . get_the_permalink()) . '" target="' . esc_attr('_blank') . '">
                <img src="' . esc_url(CBDB_URL . 'assets/images/social/twitter-' . $social_share_style . '.svg') . '" width="30" height="30" alt="' . esc_attr('Twitter-' . $social_share_style, CBDB_TEXTDOMAIN) . '">
            </a>
            <a href="' . esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink()) . '" target="' . esc_attr('_blank') . '">
                <img src="' . esc_url(CBDB_URL . 'assets/images/social/linkedin-' . $social_share_style . '.svg') . '" width="30" height="30" alt="' . esc_attr('LinkedIn-' . $social_share_style, CBDB_TEXTDOMAIN) . '">
            </a>
        </div>';
        return $social_share;
    }

}