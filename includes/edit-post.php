<?php
	use WeDevs\Dokan\Walkers\CategoryDropdownSingle;
	use WeDevs\Dokan\Walkers\TaxonomyDropdown;
?>
<div class="dokan-dashboard-wrap">
    <?php do_action( 'dokan_dashboard_content_before' ); ?>
    <div class="dokan-dashboard-content">
        <?php do_action( 'dokan_dashboard_content_inside_before' ); ?>
            
       <?php if ( !empty($_GET['post']) ) { 

		    $post_id      = $_GET['post']; 
			$post = get_post( $post_id );	
			$post_title   = get_the_title($post_id); 
			$post_content = $post->post_content;
			$post_excerpt = get_the_excerpt($post_id);
		
		?>
            <form class="dokan-update-post-form" role="form" method="post">

                <div class="dokan-form-top-area">

                    <div class="content-half-part dokan-product-meta">

                        <div class="dokan-form-group">
							<input type="hidden" id="post_id" value="<?php echo $post_id; ?>">
                            <label for="post_title"  class="form-label"><?php esc_html_e( 'Title', 'dokan-lite' ); ?></label>
                            <?php dokan_post_input_box( '', 'post_title', array( 'placeholder' => __( 'Post title..', 'dokan-lite' ), 'value' => $post_title ,'required' => 'required' ) ); ?>
                            <div class="dokan-product-title-alert dokan-hide">
                                <?php esc_html_e( 'Please enter product title!', 'dokan-lite' ); ?>
                            </div>
                        </div>

                        <?php if ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ): ?>
                            <div class="dokan-form-group">
                                <label for="category" class="form-label"><?php esc_html_e( 'Category', 'dokan-lite' ); ?></label>
                                <?php
                                	$post_cat = -1;
									$categories = array();
									$categories = wp_get_post_terms( $post_id, 'category', array( 'fields' => 'ids') );
									if ( $categories ) {
										$post_cat = reset( $categories );
									}
                                include_once DOKAN_LIB_DIR.'/class.category-walker.php';

                                $category_args =  array(
                                    'show_option_none' => __( '- Select a category -', 'dokan-lite' ),
                                    'hierarchical'     => 1,
                                    'hide_empty'       => 0,
                                    'name'             => 'category',
                                    'id'               => 'category',
                                    'taxonomy'         => 'category',
                                    'title_li'         => '',
									'selected'		   => $post_cat,
                                    'class'            => 'category dokan-form-control dokan-select2',
                                    'exclude'          => '',
									'walker'           => new CategoryDropdownSingle( $post_id )
                                );

                                wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) );
                            ?>
                                <div class="dokan-product-cat-alert dokan-hide">
                                    <?php esc_html_e('Please choose a category!', 'dokan-lite' ); ?>
                                </div>
                            </div>
                        <?php elseif ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'multiple' ): ?>
                            <div class="dokan-form-group">
                                <label for="category" class="form-label"><?php esc_html_e( 'Category', 'dokan-lite' ); ?></label>
                                <?php
								$categories = array();
								$categories = wp_get_post_terms( $post_id, 'category', array( 'fields' => 'ids') );
                                $drop_down_category = wp_dropdown_categories( apply_filters( 'dokan_category_dropdown_args', array(
                                    'show_option_none' => __( '', 'dokan-lite' ),
                                    'hierarchical'     => 1,
                                    'hide_empty'       => 0,
                                    'name'             => 'category[]',
                                    'id'               => 'category',
                                    'taxonomy'         => 'category',
                                    'title_li'         => '',
									'selected'		   => $categories,
                                    'class'            => 'category dokan-form-control dokan-select2',
                                    'exclude'          => '',
                                    'echo'             => 0,
									'walker'           => new TaxonomyDropdown( $post_id )
                                ) ) );

                                echo str_replace( '<select', '<select data-placeholder="' . esc_html__( 'Select post category', 'dokan-lite' ) . '" multiple="multiple" ', $drop_down_category ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="dokan-form-group">
                            <label for="tag" class="form-label"><?php esc_html_e( 'Tags', 'dokan-lite' ); ?></label>
                            <?php 
							$terms = array();
							$terms  = get_the_terms( $post_id , 'post_tag' );
	                        if(!empty($terms)){
								$terms = wp_list_pluck($terms  , 'term_id');
							}else{
								$terms = array();
							}
							
	
								
							$drop_down_tags = wp_dropdown_categories(array(
                                'taxonomy'   => 'post_tag',
                                'hide_empty' => 0,
                                'name'             => 'post_tag[]',
                                'id'               => 'post_tag',
                                'taxonomy'         => 'post_tag',
                                'title_li'         => '',
                                'class'            => 'post_tag dokan-form-control dokan-select2',
                                'exclude'          => '',
                                'echo'             => 0,
								 'selected'		   => $terms,
								 'walker'           => new TaxonomyDropdown( $post_id )
                            ));
                            echo str_replace( '<select', '<select data-placeholder="' . esc_html__( 'Select post tags', 'dokan-lite' ) . '" multiple="multiple" ', $drop_down_tags);
                            
							/*
                             $terms  = wp_get_post_terms( $post_id, 'tag', array( 'fields' => 'all' ) );
                             $drop_down_tags = array(
                                 'hide_empty' => 0,
                             );
                             ?>
                             <select multiple="multiple" name="product_tag[]"  class=" post_tags dokan-form-control dokan-select2" data-placeholder="<?php echo esc_attr( 'Select post tags' ); ?>">
                             		<?php if ( ! empty( $terms ) ) : ?>
                                      	<?php foreach ( $terms as $tax_term ) : ?>
                                  			<option value="<?php echo esc_attr( $tax_term->term_id ); ?>" selected="selected" ><?php echo esc_html( $tax_term->name ); ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                             </select> */ ?>
                        </div>

                    
                    </div><!-- .content-half-part -->

                    <div class="content-half-part featured-image">

                        <div class="dokan-feat-image-upload dokan-new-product-featured-img">
                             <?php
                                  $wrap_class = ' dokan-hide';
                                  $instruction_class = '';
                                  $feat_image_id     = 0;

                                  if ( has_post_thumbnail( $post_id ) ) {
                             	       $wrap_class        = '';
                                       $instruction_class = ' dokan-hide';
                                       $feat_image_id     = get_post_thumbnail_id( $post_id );
                               	} ?>
                               
                                  <div class="instruction-inside<?php echo esc_attr( $instruction_class ); ?>">
                                      <input type="hidden" name="feat_image_id" id="feat_image_id" class="dokan-feat-image-id" value="<?php echo esc_attr( $feat_image_id ); ?>">
                                      <i class="fa fa-cloud-upload"></i>
                                      <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php esc_html_e( 'Upload a product cover image', 'dokan-lite' ); ?></a>
                                  </div>
								  <div class="image-wrap<?php echo esc_attr( $wrap_class ); ?>">
                                      <a class="close dokan-remove-feat-image">&times;</a>
                                      <?php if ( $feat_image_id ) { ?>
                                          <?php echo get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array( 'height' => '', 'width' => '' ));?>
                                      <?php } else { ?>
                                           <img height="" width="" src="" alt="">
                                      <?php } ?>
                                   </div>
							
                        </div><!-- .dokan-feat-image-upload -->

                    </div><!-- .content-half-part -->
                </div><!-- .dokan-form-top-area -->

                <div class="dokan-product-short-description">
                    <label for="post_excerpt" class="form-label"><?php esc_html_e( 'Short Description', 'dokan-lite' ); ?></label>
                    <?php wp_editor( $post_excerpt , 'post_excerpt', apply_filters( 'dokan_product_short_description', array( 'editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_excerpt' ) ) ); ?>
                </div>

                <div class="dokan-product-description">
                    <label for="post_content" class="form-label"><?php esc_html_e( 'Description', 'dokan-lite' ); ?></label>
                    <?php wp_editor( $post_content , 'post_content', apply_filters( 'dokan_product_description', array( 'editor_height' => 50, 'quicktags' => false, 'media_buttons' => true, 'teeny' => true, 'editor_class' => 'post_content' ) ) ); ?>
                </div>

                
            

            

                

                <?php wp_nonce_field( 'dokan_edit_product', 'dokan_edit_product_nonce' ); ?>
                <div class="action_buttons">
                    <!--hidden input for Firefox issue-->
                    <input type="hidden" name="dokan_update_post" value="<?php esc_attr_e( 'Update Post', 'dokan-lite' ); ?>"/>
                    <input type="submit" name="dokan_update_post" class="dokan-btn dokan-btn-theme dokan-btn-lg dokan-right" value="<?php esc_attr_e( 'Update Post', 'dokan-lite' ); ?>"/>
                </div>
                <div class="dokan-clearfix"></div>
            </form>
        <?php } else { ?>
            <div class="dokan-alert dokan-alert">
                <div class="dokan-alert dokan-alert-danger">
					<strong>Error!</strong>
					No Post Found to Edit
				</div>
            </div>
        <?php } ?>

            
        <?php do_action( 'dokan_dashboard_content_inside_after' ); ?>
    </div><!-- .dokan-dashboard-content -->
    <?php do_action( 'dokan_dashboard_content_after' ); ?>
</div><!-- .dokan-dashboard-wrap --> <?php ?>

<style>
    form.dokan-post-edit-form {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
    }
    .action_buttons{
        margin-top:20px;
    }
</style>