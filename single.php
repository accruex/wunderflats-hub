<?php get_header(); ?>

<main id="main" class="site-main" role="main">
<?php while ( have_posts() ) : the_post(); ?>

    <div class="post-hero">
        <div class="container container--narrow">
            <?php $cat = wfhub_first_category(); if ( $cat ) : ?>
                <span class="tag <?php echo esc_attr( wfhub_tag_class( $cat ) ); ?>"><?php echo wfhub_first_category_link(); ?></span>
            <?php endif; ?>
            <h1 class="post-hero__title"><?php the_title(); ?></h1>
            <div class="post-hero__meta">
                <span><?php esc_html_e( 'By', 'wunderflats-hub' ); ?> <strong><?php the_author_posts_link(); ?></strong></span>
                <span><?php echo get_the_date(); ?></span>
                <span><?php echo wfhub_reading_time(); ?></span>
            </div>
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-hero__image"><?php the_post_thumbnail( 'wfhub-hero', array( 'alt' => get_the_title() ) ); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="post-content">
        <div class="container container--narrow">
            <?php the_content(); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wunderflats-hub' ), 'after' => '</div>' ) ); ?>
        </div>
    </div>

    <div class="container container--narrow">
        <div class="post-footer">
            <?php if ( has_tag() ) : ?>
            <div class="post-tags"><?php the_tags( '' ); ?></div>
            <?php endif; ?>
            <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener" class="btn-read" style="font-size:.8rem;padding:.5rem 1rem">
                <?php esc_html_e( 'Share on X', 'wunderflats-hub' ); ?>
            </a>
        </div>
    </div>

    <div class="container container--narrow" style="margin-bottom:3rem">
        <div class="widget" style="display:flex;gap:1rem;align-items:flex-start">
            <?php echo get_avatar( get_the_author_meta( 'email' ), 64, '', '', array( 'style' => 'border-radius:50%;flex-shrink:0' ) ); ?>
            <div>
                <strong><?php the_author(); ?></strong>
                <p style="font-size:.875rem;color:var(--c-muted);margin-top:.25rem"><?php the_author_meta( 'description' ); ?></p>
            </div>
        </div>
    </div>

    <?php
    $rel = new WP_Query( array(
        'category__in'   => wp_get_post_categories( get_the_ID() ),
        'posts_per_page' => 3,
        'post__not_in'   => array( get_the_ID() ),
        'orderby'        => 'rand',
    ) );
    if ( $rel->have_posts() ) : ?>
    <section class="content-section" style="border-top:1px solid var(--c-border)">
        <div class="container">
            <div class="sec-lbl"><?php esc_html_e( 'Related Articles', 'wunderflats-hub' ); ?></div>
            <div class="posts-grid">
                <?php while ( $rel->have_posts() ) : $rel->the_post(); $rc = wfhub_first_category(); ?>
                <article <?php post_class( 'card' ); ?>>
                    <div class="card-img" style="aspect-ratio:16/9">
                        <a href="<?php the_permalink(); ?>"><?php wfhub_thumb_or_placeholder( 'wfhub-card', get_the_title() ); ?></a>
                    </div>
                    <div class="card-body">
                        <?php if ( $rc ) : ?><span class="tag <?php echo esc_attr( wfhub_tag_class( $rc ) ); ?>"><?php echo esc_html( $rc ); ?></span><?php endif; ?>
                        <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="card-meta"><span><?php echo get_the_date(); ?></span><span><?php echo wfhub_reading_time(); ?></span></div>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php comments_template(); ?>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>
