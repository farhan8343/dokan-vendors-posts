<div class="dokan-dashboard-wrap">
    <?php do_action( 'dokan_dashboard_content_before' ); ?>
    <div class="dokan-dashboard-content">
        <?php do_action( 'dokan_dashboard_content_inside_before' ); ?>
            <div class="product-listing-top dokan-clearfix" style="text-align:right;">
                <?php if ( dokan_is_seller_enabled( get_current_user_id() ) ): ?>
                    <span class="dokan-add-product-link" style="text-align:right;">
                        <?php if ( current_user_can( 'dokan_add_product' ) ): ?>
                            <a href="<?php echo esc_url( dokan_get_navigation_url( 'new-post' ) ); ?>" class="dokan-btn dokan-btn-theme">
                                <i class="fa fa-briefcase">&nbsp;</i>
                                <?php esc_html_e( 'Add new Post', 'dokan-lite' ); ?>
                            </a>
                        <?php endif ?>
                    </span>
                <?php endif; ?>
            </div>
            <?php if ( isset( $_GET['message'] ) && $_GET['message'] == 'success') { ?>
                <div class="dokan-message">
                    <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
                    <strong><?php esc_html_e( 'Success!', 'dokan-lite' ); ?></strong> <?php esc_html_e( 'The post has been saved successfully.', 'dokan-lite' ); ?>

                    <?php /*if (  $post->post_status == 'publish' ) { ?>
                        <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View Product &rarr;', 'dokan-lite' ); ?></a>
                    <?php }*/ ?>
                </div>
            <?php }elseif(isset( $_GET['message'] ) && $_GET['message'] == 'deleted'){?>
				<div class="dokan-message">
                    <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
                    <strong><?php esc_html_e( 'Success!', 'dokan-lite' ); ?></strong> <?php esc_html_e( 'The post has been deleted successfully.', 'dokan-lite' ); ?>

                </div>
			<?php }elseif(isset( $_GET['message'] ) && $_GET['message'] == 'updated'){?>
				<div class="dokan-message">
                    <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
                    <strong><?php esc_html_e( 'Success!', 'dokan-lite' ); ?></strong> <?php esc_html_e( 'The post has been updated successfully.', 'dokan-lite' ); ?>

                </div>
			<?php }
		
				$pagenum        = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
				$post_statuses  = apply_filters( 'dokan_product_listing_post_statuses', [ 'publish', 'draft', 'pending', 'future' ] );
				$stock_statuses = apply_filters( 'dokan_product_stock_statuses', [ 'instock', 'outofstock' ] );
																					
				$args = array(
					'post_type'		 => 'post',
					'posts_per_page' => 10,
					'paged'          => $pagenum,
					'author'         => dokan_get_current_user_id(),
					'post_status'    => $post_statuses,
				);

				$query = new WP_Query($args);
				
			   // echo '<pre>'; print_r($query); echo '</pre>';											   
			   
		
		 	if ( $query->have_posts() ) {?>

			<table style="margin-top: 30px;" class="dokan-table dokan-table-striped product-listing-table dokan-inline-editable-table" id="dokan-product-list-table">
				<thead>
					<tr>

						<th><?php esc_html_e( 'Name', 'dokan-lite' ); ?></th>
						<th><?php esc_html_e( 'Status', 'dokan-lite' ); ?></th>
						<th><?php esc_html_e( 'Date', 'dokan-lite' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
			
						while ($query->have_posts()) {
							$query->the_post(); ?>
							<tr>
								<td><?php the_title(); ?>
								
								<div class="row-actions">
									<span class="edit"><a href="<?php echo dokan_get_navigation_url('edit-post').'?post='.get_the_id(); ?>">Edit</a> | </span> <span class="delete"><a data-post-id="<?php echo get_the_id(); ?>">Delete Permanently</a> | </span> <span class="view"><a href="<?php the_permalink(); ?>">View</a></span>         							</div>
								
								</td>
								<td><?php echo get_post_status(); ?></td>
								<td><?php the_modified_date(); ?></td>
							</tr>
						<?php } ?>

				
				</tbody>

		</table>
		<?php wp_reset_postdata();

                        $pagenum  = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                        $base_url = dokan_get_navigation_url('vendor-posts');

                        if ( $query->max_num_pages > 1 ) {
                            echo '<div class="pagination-wrap">';
                            $page_links = paginate_links( array(
                                'current'   => $pagenum,
                                'total'     => $query->max_num_pages,
                                'base'      => $base_url. '%_%',
                                'format'    => '?pagenum=%#%',
                                'add_args'  => false,
                                'type'      => 'array',
                                'prev_text' => __( '&laquo; Previous', 'dokan-lite' ),
                                'next_text' => __( 'Next &raquo;', 'dokan-lite' )
                            ) );

                            echo '<ul class="pagination"><li>';
                            echo join("</li>\n\t<li>", $page_links ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                            echo "</li>\n</ul>\n";
                            echo '</div>';
                        }
                        ?>
		<?php  }?>
		
		

            
        <?php do_action( 'dokan_dashboard_content_inside_after' ); ?>
    </div><!-- .dokan-dashboard-content -->
    <?php do_action( 'dokan_dashboard_content_after' ); ?>
</div><!-- .dokan-dashboard-wrap --> <?php ?>


<style>
tr:hover .row-actions {
    display: block;
}
.row-actions .delete a{
	cursor:pointer;
}
tr .row-actions {
    display: none;
}
</style>