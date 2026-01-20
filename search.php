<?php

/**
 * The template for displaying search results pages
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-2">
            <h1 class="velocity-title">
                <?php printf(esc_html__('Search Results for: %s', 'justg'), '<span>' . esc_html(get_search_query()) . '</span>'); ?>
            </h1>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php velocity_post_loop(); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part('loop-templates/content', 'none'); ?>
            <?php endif; ?>
            <?php if (function_exists('justg_pagination')) { justg_pagination(); } ?>
        </div>
        <div class="col-md-4 pt-2">
            <?php get_sidebar('main'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
