<div class="dokan-dashboard-wrap">
    <?php do_action( 'dokan_dashboard_content_before' ); ?>
    <div class="dokan-dashboard-content">
        <?php do_action( 'dokan_dashboard_content_inside_before' ); ?>
            
       <?php if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>
            <form class="dokan-post-edit-form" role="form" method="post">

                <div class="dokan-form-top-area">

                    <div class="content-half-part dokan-product-meta">

                        <div class="dokan-form-group">

                            <label for="post_title" class="form-label"><?php esc_html_e( 'Title', 'dokan-lite' ); ?></label>
                            <?php dokan_post_input_box( '', 'post_title', array( 'placeholder' => __( 'Post title..', 'dokan-lite' ), 'value' => '','required' => 'required' ) ); ?>
                            <div class="dokan-product-title-alert dokan-hide">
                                <?php esc_html_e( 'Please enter product title!', 'dokan-lite' ); ?>
                            </div>
                        </div>

                        <?php if ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ): ?>
                            <div class="dokan-form-group">
                                <label for="category" class="form-label"><?php esc_html_e( 'Category', 'dokan-lite' ); ?></label>
                                <?php
                                $product_cat = -1;
                                $term = array();
        

                                if ( $term ) {
                                    $product_cat = reset( $term );
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
                                    'class'            => 'category dokan-form-control dokan-select2',
                                    'exclude'          => ''
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
                                $drop_down_category = wp_dropdown_categories( apply_filters( 'dokan_category_dropdown_args', array(
                                    'show_option_none' => __( '', 'dokan-lite' ),
                                    'hierarchical'     => 1,
                                    'hide_empty'       => 0,
                                    'name'             => 'category[]',
                                    'id'               => 'category',
                                    'taxonomy'         => 'category',
                                    'title_li'         => '',
                                    'class'            => 'category dokan-form-control dokan-select2',
                                    'exclude'          => '',
                                    'echo'             => 0
                                ) ) );

                                echo str_replace( '<select', '<select data-placeholder="' . esc_html__( 'Select post category', 'dokan-lite' ) . '" multiple="multiple" ', $drop_down_category ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="dokan-form-group">
                            <label for="tag" class="form-label"><?php esc_html_e( 'Tags', 'dokan-lite' ); ?></label>
                            <?php
                            

                            $drop_down_tags = wp_dropdown_categories(array(
                                'taxonomy'   => 'post_tag',
                                'hide_empty' => 0,
                                'name'             => 'post_tag[]',
                                'id'               => 'post_tag',
                                'taxonomy'         => 'post_tag',
                                'title_li'         => '',
                                'class'            => 'post_tag dokan-form-control dokan-select2',
                                'exclude'          => '',
                                'echo'             => 0
                            ));
                            echo str_replace( '<select', '<select data-placeholder="' . esc_html__( 'Select post tags', 'dokan-lite' ) . '" multiple="multiple" ', $drop_down_tags);
                            ?>
                            <!-- <select multiple="multiple" name="tag[]" id=tag_search" class="tag_search tags dokan-form-control dokan-select2" data-placeholder="<?php esc_attr_e( 'Select tags', 'dokan-lite' ); ?>">
                                
                            </select> -->
                        </div>

                    
                    </div><!-- .content-half-part -->

                    <div class="content-half-part featured-image">

                        <div class="dokan-feat-image-upload dokan-new-product-featured-img">
                            <?php
                            $wrap_class        = ' dokan-hide';
                            $instruction_class = '';
                            $feat_image_id     = 0;

            
                            ?>

                            <div class="instruction-inside<?php echo esc_attr( $instruction_class ); ?>">
                                <input type="hidden" name="feat_image_id" id="feat_image_id" class="dokan-feat-image-id" value="<?php echo esc_attr( $feat_image_id ); ?>">

                                <i class="fa fa-cloud-upload"></i>
                                <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php esc_html_e( 'Upload a Post cover image', 'dokan-lite' ); ?></a>
                            </div>

                            <div class="image-wrap<?php echo esc_attr( $wrap_class ); ?>">
                                <a class="close dokan-remove-feat-image">&times;</a>
                               
                                    <img height="" width="" src="" alt="">
                                
                            </div>
                        </div><!-- .dokan-feat-image-upload -->

                    </div><!-- .content-half-part -->
                </div><!-- .dokan-form-top-area -->

                <div class="dokan-product-short-description">
                    <label for="post_excerpt" class="form-label"><?php esc_html_e( 'Short Description', 'dokan-lite' ); ?></label>
                    <?php wp_editor( '' , 'post_excerpt', apply_filters( 'dokan_product_short_description', array( 'editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_excerpt' ) ) ); ?>
                </div>

                <div class="dokan-product-description">
                    <label for="post_content" class="form-label"><?php esc_html_e( 'Description', 'dokan-lite' ); ?></label>
                    <?php wp_editor( '' , 'post_content', apply_filters( 'dokan_product_description', array( 'editor_height' => 50, 'quicktags' => false, 'media_buttons' => true, 'teeny' => true, 'editor_class' => 'post_content' ) ) ); ?>
                </div>

                
            

            

                

                <?php wp_nonce_field( 'dokan_edit_product', 'dokan_edit_product_nonce' ); ?>
                <div class="action_buttons">
                    <!--hidden input for Firefox issue-->
                    <input type="hidden" name="dokan_add_post" value="<?php esc_attr_e( 'Save Post', 'dokan-lite' ); ?>"/>
                    <input type="submit" name="dokan_add_post" class="dokan-btn dokan-btn-theme dokan-btn-lg dokan-right" value="<?php esc_attr_e( 'Save Post', 'dokan-lite' ); ?>"/>
                </div>
                <div class="dokan-clearfix"></div>
            </form>
        <?php } else { ?>
            <div class="dokan-alert dokan-alert">
                <?php echo esc_html( dokan_seller_not_enabled_notice() ); ?>
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