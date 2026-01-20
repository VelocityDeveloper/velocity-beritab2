<?php
/**
 * Kumpulan shortcode yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// [velocity-post-tabs]
function velocity_post_tabs() {
    ob_start();
    $jumlah = 3; ?>

    <ul class="nav nav-tabs velocity-post-tabs row p-0" role="tablist">
        <li class="nav-item pb-0 border-0 col p-0 text-center">
            <a class="nav-link active secondary-font fw-bold rounded-0" id="kategori1-tab" data-bs-toggle="tab" href="#kategori1" role="tab" aria-controls="kategori1" aria-selected="true">
            Popular</a>
        </li>
        <li class="nav-item pb-0 border-0 col p-0 text-center">
            <a class="nav-link secondary-font fw-bold rounded-0" id="kategori2-tab" data-bs-toggle="tab" href="#kategori2" role="tab" aria-controls="kategori2" aria-selected="false">
            Recent</a>
        </li>
        <li class="nav-item pb-0 border-0 col p-0 text-center">
            <a class="nav-link secondary-font fw-bold rounded-0" id="kategori3-tab" data-bs-toggle="tab" href="#kategori3" role="tab" aria-controls="kategori3" aria-selected="false">
            Comment</a>
        </li>
    </ul>
    
    <div class="tab-content py-2 border-start border-end border-bottom" id="myTabContent">

        <!-- Tab Popular -->
        <div class="tab-pane fade show active" id="kategori1" role="tabpanel" aria-labelledby="kategori1-tab">
        <?php 
        $args = array(
            'post_type' => 'post',
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'numberposts' => $jumlah,
        );
        $posts = get_posts($args);
        if ($posts): ?>
            <div class="frame-kategori px-3">
            <?php foreach ($posts as $post):
                setup_postdata($post);
                echo velocity_post_tabs_item($post);
            endforeach; ?>
            </div>
        <?php else:
            _e('<p>Belum ada post.</p>');
        endif;
        wp_reset_postdata(); ?>
        </div>

        <!-- Tab Recent -->
        <div class="tab-pane fade" id="kategori2" role="tabpanel" aria-labelledby="kategori2-tab">
        <?php 
        $args2 = array(
            'post_type' => 'post',
            'numberposts' => $jumlah,
        );
        $posts2 = get_posts($args2);
        if ($posts2): ?>
            <div class="frame-kategori px-3">
            <?php foreach ($posts2 as $post):
                setup_postdata($post);
                echo velocity_post_tabs_item($post);
            endforeach; ?>
            </div>
        <?php else:
            _e('<p>Belum ada post.</p>');
        endif;
        wp_reset_postdata(); ?>
        </div>

        <!-- Tab Comment -->
        <div class="tab-pane fade" id="kategori3" role="tabpanel" aria-labelledby="kategori3-tab">
        <?php 
        $args3 = array(
            'post_type' => 'post',
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'numberposts' => $jumlah,
        );
        $posts3 = get_posts($args3);
        if ($posts3): ?>
            <div class="frame-kategori px-3">
            <?php foreach ($posts3 as $post):
                setup_postdata($post);
                echo velocity_post_tabs_item($post);
            endforeach; ?>
            </div>
        <?php else:
            _e('<p>Belum ada post.</p>');
        endif;
        wp_reset_postdata(); ?>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('velocity-post-tabs', 'velocity_post_tabs');

function velocity_post_tabs_item($post) {
	$title = get_the_title($post->ID);
	$trimmed_title = substr($title, 0, 60) . ' ...';
	$calendar_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-calendar3 align-middle me-1" viewBox="0 0 16 16">
	<path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 4.5h14V14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4.5zM2 3.5V2a1 1 0 0 1 1-1h1v2.5H2zm3-2.5h6v2.5H5V1zm7 0h1a1 1 0 0 1 1 1v1.5h-2V1z"/>
	</svg>';
	$html = '<div class="row m-0 py-2">';
	$html .= '<div class="col-4 col-sm-3 p-0">';
	$html .= velocity_berita_thumbnail_html($post->ID, 200, 200, 'w-100');
	$html .= '</div>';
	$html .= '<div class="col-8 col-sm-9 py-1">';
	$html .= '<div class="vtitle"><a class="text-dark secondary-font fw-bold" href="' . get_the_permalink($post->ID) . '">' . $trimmed_title . '</a></div>';
	$html .= '<div class="text-muted"><small>' . $calendar_icon;
	ob_start();
	velocity_post_date($post->ID);
	$date = ob_get_clean();
	$html .= $date . '</small></div>';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}




function velocity_popular_posts(){
    ob_start();
    $args = array(
        'post_type'   => 'post',
        'orderby'     => 'comment_count',
        'order'       => 'DESC',
        'numberposts' => 10 // Batas maksimal post yang diambil
    );
    $posts = get_posts( $args );
    if ( $posts ) {
        echo '<div class="velocity-popular-posts">';
        foreach ( $posts as $post ) {
            setup_postdata( $post ); ?>
            <div class="velocity-popular-list mb-3">
                <div class="fw-bold mb-0"><a class="text-dark" href="<?php echo get_permalink($post->ID); ?>"><b><?php echo get_the_title($post->ID); ?></b></a></div>
                <small class="text-secondary fst-italic"><?php velocity_post_date($post->ID); ?></small>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
}
add_shortcode('velocity-popular-posts', 'velocity_popular_posts');


function velocity_recent_posts($atts){
    ob_start();
    $args = shortcode_atts( array(
        'style'         => 'list', // list, gallery, first_image
        'post_type'     => 'post',
        'category_name' => '',
        'numberposts'   => 4, // Batas maksimal post yang diambil
    ), $atts );
    
    $style = $args['style'];
    $posts = get_posts( $args );
    
    if ( $posts ) {
        if ($style == 'gallery') {
            $topclass = ' row';
            $colframe = ' col-6 mb-3';
            $col1 = ' mb-2';
            $col2 = '';
        } else {
            $topclass = '';
            $colframe = ' mb-3 row';
            $col1 = ' col-4 pe-0';
            $col2 = ' col-8';
        }
        
        echo '<div class="velocity-recent-posts'.$topclass.'">';
        $i = 0;
        foreach ( $posts as $post ) {
            setup_postdata( $post );
            $no = ++$i;
            if ($style == 'first_image' && $no == '1') {
                $class = 'col-12 mb-2';
            } else {
                $class = $col1;
            } ?>
            <div class="velocity-recent-list<?php echo $colframe;?>">
                <div class="col-image<?php echo $class;?>">
                    <?php echo velocity_berita_thumbnail_html($post->ID, 400, 280, 'w-100'); ?>
                </div>
                <div class="col-content<?php echo $col2;?>">
                    <div class="v-post-title fw-bold mb-0"><a class="text-dark" href="<?php echo get_permalink($post->ID); ?>"><b><?php echo get_the_title($post->ID); ?></b></a></div>
                    <small class="v-post-date text-secondary fst-italic"><?php velocity_post_date($post->ID);?></small>
                </div>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
}
add_shortcode('velocity-recent-posts', 'velocity_recent_posts');
