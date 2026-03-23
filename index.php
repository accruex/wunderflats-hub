<?php
/**
 * Wunderflats Hub — index.php
 * Fallback template for archives, search, and any page
 * not covered by a more specific template.
 */
get_header();
?>

<main id="main" class="site-main" role="main">

    <section class="content-section">
        <div class="container">
            <div class="content-sidebar">

                <div class="posts-area">

                    <?php if ( is_archive() || is_search() ) : ?>
                    <div class="sec-lbl">
                        <?php
                        if ( is_search() ) {
                            printf( esc_html__( 'Search results for: %s', 'wunderflats-hub' ), '<strong>' . get_search_query() . '</strong>' );
                        } elseif ( is_category() ) {
                            single_cat_title();
                        } elseif ( is_tag() ) {
                            single_tag_title();
                        } elseif ( is_author() ) {
                            the_author();
                        } else {
                            esc_html_e( 'Archives', 'wunderflats-hub' );
                        }
                        ?>
                    </div>
                    <?php else : ?>
                    <div class="sec-lbl"><?php esc_html_e( 'Latest Articles', 'wunderflats-hub' ); ?></div>
                    <?php endif; ?>

                    <?php if ( have_posts() ) : ?>

                    <div class="posts-grid">
                        <?php while ( have_posts() ) : the_post();
                            $cat = wfhub_first_category(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
                            <div class="card-img" style="aspect-ratio:16/9">
                                <a href="<?php the_permalink(); ?>">
                                    <?php wfhub_thumb_or_placeholder( 'wfhub-card', get_the_title() ); ?>
                                </a>
                            </div>
                            <div class="card-body">
                                <?php if ( $cat ) : ?>
                                <span class="tag <?php echo esc_attr( wfhub_tag_class( $cat ) ); ?>"><?php echo esc_html( $cat ); ?></span>
                                <?php endif; ?>
                                <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="card-exc"><?php the_excerpt(); ?></p>
                                <div class="card-meta">
                                    <span><?php the_author(); ?></span>
                                    <span><?php echo get_the_date(); ?></span>
                                    <span><?php echo wfhub_reading_time(); ?></span>
                                </div>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '&larr;',
                        'next_text' => '&rarr;',
                    ) );
                    ?>

                    <?php else : ?>
                    <p style="padding:2rem 0; color:var(--c-muted);">
                        <?php esc_html_e( 'No posts found.', 'wunderflats-hub' ); ?>
                    </p>
                    <?php endif; ?>

                </div><!-- .posts-area -->

                <aside class="sidebar" role="complementary">
                    <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
                        <?php dynamic_sidebar( 'sidebar-main' ); ?>
                    <?php else : ?>

                    <div class="widget widget-newsletter">
                        <h3 class="widget-title"><?php esc_html_e( 'Stay in the loop', 'wunderflats-hub' ); ?></h3>
                        <p><?php esc_html_e( 'Weekly insights for tenants and landlords in Germany.', 'wunderflats-hub' ); ?></p>
                        <input type="email" placeholder="<?php esc_attr_e( 'Your email address', 'wunderflats-hub' ); ?>">
                        <button type="button"><?php esc_html_e( 'Subscribe →', 'wunderflats-hub' ); ?></button>
                    </div>

                    <div class="widget">
                        <h3 class="widget-title"><?php esc_html_e( 'Browse Topics', 'wunderflats-hub' ); ?></h3>
                        <ul>
                            <?php wp_list_categories( array( 'title_li' => '', 'show_count' => true ) ); ?>
                        </ul>
                    </div>

                    <?php endif; ?>
                </aside>

            </div><!-- .content-sidebar -->
        </div>
    </section>

</main>

<?php get_footer(); ?>