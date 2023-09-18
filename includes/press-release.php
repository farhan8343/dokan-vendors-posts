<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$vendor       = dokan()->vendor->get( get_query_var( 'author' ) );
$vendor_info  = $vendor->get_shop_info();
$map_location = $vendor->get_location();
$store_user   = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$layout       = get_theme_mod( 'store_layout', 'left' );

get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

    <?php if ( 'left' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

<div id="primary" class="content-area dokan-single-store">
    <div id="dokan-content" class="site-content store-review-wrap woocommerce" role="main">

        <?php dokan_get_template_part( 'store-header' ); ?>

        <div id="store-toc-wrapper">
            <div id="store-toc">

                <?php
				$args = array(
					'post_type'		 => 'post',
					'posts_per_page' => 10,
					//'paged'          => $pagenum,
					'author'         => $vendor->id,
					//'post_status'    => $post_statuses,
				);

				$query = new WP_Query($args);
				if($query->have_posts()){
					echo '<div class="store-posts">';
					while($query->have_posts()){ $query->the_post();
						echo '<div class="store-post"><a href="'.get_the_permalink().'">';
							the_post_thumbnail('thumbnail');
							echo '<h3>' . get_the_title() .'</h3>';
							echo '<p>' . get_the_modified_date() . '</p>';
						echo '</a></div>';
					
					}	
					echo '</div>';
				}else{
					echo '<div style="text-align:center; margin: 20px 0px;">No Posts Found</div>';
				}
				
				?>
            </div><!-- #store-toc -->
        </div><!-- #store-toc-wrap -->

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<div class="dokan-clearfix"></div>

    <?php if ( 'right' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

</div><!-- .dokan-store-wrap -->
<style>
.store-posts .store-post a {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
}
.store-posts {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
}
</style>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>