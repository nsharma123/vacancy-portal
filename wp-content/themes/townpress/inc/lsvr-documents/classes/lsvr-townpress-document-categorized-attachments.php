<?php
/**
 * Document archive tree walker
 */
if ( ! class_exists( 'Lsvr_Townpress_Document_Categorized_Attachments_Walker' ) ) {
    class Lsvr_Townpress_Document_Categorized_Attachments_Walker extends Walker_Category {

        function start_lvl( &$output, $depth = 0, $args = [] ) {
            // no output
        }

        function end_lvl( &$output, $depth = 0, $args = [] ) {
            // no output
        }

        function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {

            $depth = $depth + 1;

            // Check if current category is active
            if ( is_tax( 'lsvr_document_cat' ) && $item->term_id === get_queried_object_id() ) {
                $active_class .= ' post-tree__folder--active';
            } else {
                $active_class = '';
            }

            ob_start(); ?>

            <li class="post-tree__item post-tree__item--folder post-tree__item--level-<?php echo esc_attr( $depth ); ?><?php echo esc_attr( $active_class ); ?>">

                <div class="post-tree__item-link-holder post-tree__item-link-holder--folder">
                    <a href="<?php echo esc_url( get_term_link( $item ) ); ?>" class="post-tree__item-link post-tree__item-link--folder"><?php echo esc_attr( $item->name ); ?></a>
                </div>

                <ul class="post-tree__children post-tree__children--level-<?php echo esc_attr( $depth + 1 ); ?>">

            <?php $output .= ob_get_clean();

        }

        function end_el( &$output, $item, $depth = 0, $args = [] ) {

            $depth = $depth + 2;

            // Document posts query args
            $query_args = array(
                'post_type' => 'lsvr_document',
                'posts_per_page' => 1000,
                'fields' => 'ids',
                'has_password' => false,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'lsvr_document_cat',
                        'field' => 'id',
                        'terms' => $item->term_id,
                        'include_children' => false,
                    ),
                ),
            );

            // Order of posts
            $posts_order = get_theme_mod( 'lsvr_document_archive_attachments_order', 'filename_asc' );
            if ( 'date_asc' === $posts_order ) {
                $query_args['order'] = 'ASC';
                $query_args['orderby'] = 'date';
            }
            else if ( 'date_desc' === $posts_order ) {
                $query_args['order'] = 'DESC';
                $query_args['orderby'] = 'date';
            }

            // Get document posts
            $documents = get_posts( $query_args );

            ob_start(); ?>

            <?php if ( ! empty( $documents ) && function_exists( 'lsvr_documents_get_document_attachments' ) ) : ?>

                <?php // Save all attachments into a single array
                $category_attachments = array();

                foreach ( $documents as $document_id ) {
                    $document_attachments = lsvr_documents_get_document_attachments( $document_id );
                    if ( ! empty( $document_attachments ) ) {
                        foreach ( $document_attachments as $attachment ) {
                            array_push( $category_attachments, $attachment );
                        }
                    }
                }

                // If documents order is set to 'title', sort attachments by filename
                $attachments_order = get_theme_mod( 'lsvr_document_archive_attachments_order', 'filename_asc' );
                if ( ! empty( $category_attachments ) ) {

                    if ( 'filename_asc' === $attachments_order ) {
                        usort( $category_attachments, function( $a, $b ) {
                            return strcmp( $a['filename'], $b['filename'] );
                        });
                    }
                    else if ( 'filename_desc' === $attachments_order ) {
                        usort( $category_attachments, function( $a, $b ) {
                            return strcmp( $b['filename'], $a['filename'] );
                        });
                    }
                    else if ( 'title_asc' === $attachments_order ) {
                        usort( $category_attachments, function( $a, $b ) {
                            return strcmp( $a['title'], $b['title'] );
                        });
                    }
                    else if ( 'title_desc' === $attachments_order ) {
                        usort( $category_attachments, function( $a, $b ) {
                            return strcmp( $b['title'], $a['title'] );
                        });
                    }

                }
                ?>

                <?php if ( ! empty( $category_attachments ) ): ?>
                    <?php foreach ( $category_attachments as $attachment ) : ?>

                        <li class="post-tree__item post-tree__item--file post-tree__item--level-<?php echo esc_attr( $depth ); ?>">

                            <div class="post-tree__item-link-holder post-tree__item-link-holder--file">

                                <i class="post-tree__item-icon lsvr_document-attachment-icon lsvr_document-attachment-icon--<?php echo esc_attr( $attachment['extension'] ); ?><?php if ( ! empty( $attachment['filetype'] ) ) { echo ' lsvr_document-attachment-icon--' . esc_attr( $attachment['filetype'] ); } ?>"></i>
                                <a href="<?php echo esc_url( $attachment['url'] ); ?>"
                                    target="_blank"
                                    class="post-tree__item-link post-tree__item-link--file">
                                    <?php if ( true === get_theme_mod( 'lsvr_document_enable_attachment_titles', false ) && ! empty( $attachment['title'] ) ) {
                                        echo esc_html( $attachment['title'] );
                                    } else {
                                        echo esc_html( $attachment['filename'] );
                                    } ?>
                                </a>
                                <?php if ( ! empty( $attachment['filesize'] ) ) : ?>
                                    <span class="post-tree__item-size"><?php echo esc_html( $attachment['filesize'] ); ?></span>
                                <?php endif; ?>
                                <?php if ( true === $attachment['external'] ) : ?>
                                    <span class="post-tree__item-label"><?php esc_html_e( 'External', 'townpress' ); ?></span>
                                <?php endif; ?>

                            </div>

                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php endif; ?>

            <?php $output .= ob_get_clean();

            $output .= '</ul></li>';

        }

    }
}
?>