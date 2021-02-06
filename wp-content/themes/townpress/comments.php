<?php if ( comments_open() ) : ?>

    <!-- POST COMMENTS : begin -->
    <div class="post-comments" id="comments">
        <div class="c-content-box">

            <h2 class="post-comments__title">
                <?php echo sprintf( esc_html( _n( '%s Comment', '%s Comments', lsvr_townpress_get_post_comments_count(), 'townpress' ) ), lsvr_townpress_get_post_comments_count() ); ?>
            </h2>

            <?php // Comments list
            if ( lsvr_townpress_has_post_comments() ) : ?>

                <!-- COMMENTS LIST : begin -->
                <ul class="post-comments__list<?php if ( get_option( 'show_avatars' ) ) { echo ' post-comments__list--avatars'; } ?>">

                    <?php wp_list_comments(array(
                        'reply_text' => esc_html__( 'Reply to comment', 'townpress' ),
                        'avatar_size' => 40,
                        'format' => 'html5'
                    )); ?>

                </ul>
                <!-- COMMENTS LIST : end -->

                <?php paginate_comments_links(array(
                    'prev_next' => false,
                    'type' => 'list'
                )); ?>

            <?php else : ?>

                <?php lsvr_townpress_the_alert_message( esc_html__( 'There are no comments yet', 'townpress' ) ); ?>

            <?php endif; ?>

            <!-- COMMENT FORM : begin -->
            <div class="post-comments__form<?php if ( is_user_logged_in() ) { echo ' post-comments__form--logged-in'; } ?>">

                <?php comment_form(array(
                    'title_reply_before' => '<h4>',
                    'title_reply_after' => '</h4>',
                    'title_reply' => esc_html__( 'Leave a comment', 'townpress' ),
                )); ?>

            </div>
            <!-- COMMENT FORM : end -->

        </div>
    </div>
    <!-- POST COMMENTS : end -->

<?php endif; ?>