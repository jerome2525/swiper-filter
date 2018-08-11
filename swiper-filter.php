<?php
/*
  Plugin Name: Swiper Filter
  Plugin URI: http://localsurgemedia.com
  Description: a Swiper Filter plugin that has a filter.
  Author: Jerome Anyayahan
  Version: 1.0
  Author URI: http://localsurgemedia.com
 */
function my_scripts() {
    
    wp_enqueue_style( 'swiper-css', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css' );
    wp_enqueue_style( 'swiperbox', plugin_dir_url(__FILE__) . 'css/swipebox.css' );
    wp_enqueue_style( 'custom-swipe',  plugin_dir_url(__FILE__) . 'css/custom-swipe-css.css' );

    wp_enqueue_script( 'swiper-js', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js', true, array('jquery'), '1.0');
    wp_enqueue_script( 'swipebox', plugin_dir_url(__FILE__) . 'js/jquery.swipebox.js', true, array('jquery'), '1.0' );
    wp_enqueue_script( 'custom-swipe', plugin_dir_url(__FILE__) . 'js/custom-swipe-js.js', true, array('jquery'), '1.0');
}

if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'my_scripts', 20, 1);
}

function wp_isotope_get_filter_buttons($atts) {
    $tax='category';
    if( isset( $atts['taxonomy']) ) {
        $tax=$atts['taxonomy'];
    }
    
    $terms = get_terms([
        'taxonomy' => $tax,
        'hide_empty' => true,
    ]);

    echo '<select name="filter" id="filter">';
        echo '<option value="all">All</option>';
        foreach ( $terms as $key => $value ) {
            $par_id = $value->term_id;
            ?>
            <option value="<?php echo $value->slug ?>"><?php echo $value->name ?></option>
        <?php
        }
    echo '</select>';
}

function wp_subcat_show( $tax, $par_id ) {
    $termschild = get_terms([
        'taxonomy' => $tax,
        'parent' => $par_id
    ]);
    foreach ( $termschild as $key => $value ) {
        echo $value->slug;
        echo '<option value="'.$value->slug.'">'.$value->name.'</option>';
    }
}

function wp_isotope_get_filter_posts($atts) {
    global $post;
    $tax='category';
    if(isset($atts['taxonomy']))
    {
        $tax=$atts['taxonomy'];
    }
    $posttype='post';
    if(isset($atts['posttype']))
    {
        $posttype=$atts['posttype'];
    }
    $col='column';
    $colNumber='4';
    if(isset($atts['columns']))
    {
        $colNumber=$atts['columns'];
    }
    
    $mtextCenter='mtext-center';
    $thumbnail='mthumbnail';
    if(isset($atts['bootstrap']))
    {
        $col='col col-xs-12 col-sm-6 col-md-'.(12/(int)$colNumber);
        $mtextCenter='text-center';
        $thumbnail='thumbnail';
    }
    else {
        $col='column-'.$colNumber;
    }
    $args = array(
        'post_type' => $posttype,
        'posts_per_page' => -1
    );
    $loop = new WP_Query($args);
    while ( $loop->have_posts() ) : $loop->the_post();
        ?>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="slide-me swiper-slide" data-filter="<?php echo get_category_filter( $post, $tax ); ?>">    
                <a href="<?php the_post_thumbnail_url(); ?>" class="swipebox">Link</a>
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <h1><?php echo get_the_title(); ?></h1>        
            </div>
        <?php endif; ?>

        <?php
    endwhile;
    wp_reset_postdata();
}

function get_category_filter( $post, $tax ) {
    $cats = wp_get_post_terms( $post->ID, $tax, array("fields" => "all"));
    foreach ( $cats as $value ) {
        return $value->slug;
    }
}

function swiper_filter_func( $atts ) {
    global $content;
    ob_start();
    global $post;
    ?>
    <div class="post-filter">
        <div class="portfolioFilter text-center">
            <?php wp_isotope_get_filter_buttons($atts); ?>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php wp_isotope_get_filter_posts($atts); ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}

if ( !is_admin() ) {
    add_shortcode('swiper_filter', 'swiper_filter_func');
}

