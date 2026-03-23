<?php
/**
 * Wunderflats Hub — front-page.php
 * Homepage template
 */
get_header();
?>

<main id="main" class="site-main" role="main">

<?php /* ── Announcement Bar ─────────────────────── */ ?>
<div class="top-bar">
    <?php
    $ann_text = get_theme_mod( 'wfhub_ann_text', '🏠 New: German Rent Reform 2025 — what landlords need to know' );
    $ann_url  = get_theme_mod( 'wfhub_ann_url',  '#' );
    $ann_link = get_theme_mod( 'wfhub_ann_link', 'Read now →' );
    echo esc_html( $ann_text );
    if ( $ann_url ) : ?>
        <a href="<?php echo esc_url( $ann_url ); ?>"><?php echo esc_html( $ann_link ); ?></a>
    <?php endif; ?>
</div>

<?php /* ── Hero ─────────────────────────────────── */ ?>
<?php
$hero_id    = get_theme_mod( 'wfhub_hero_post' );
$hero_query = $hero_id
    ? new WP_Query( array( 'p' => absint( $hero_id ) ) )
    : new WP_Query( array( 'posts_per_page' => 1 ) );

$hero_pid = 0;

if ( $hero_query->have_posts() ) :
    $hero_query->the_post();
    $hero_pid = get_the_ID();
    $hero_cat = wfhub_first_category();
?>
<section class="hero" aria-label="<?php esc_attr_e( 'Featured article', 'wunderflats-hub' ); ?>">
    <div class="hero-inner">
        <div class="hero-content">
            <div class="h-eye">✦ <?php echo $hero_cat ? esc_html( $hero_cat ) : esc_html__( 'Latest', 'wunderflats-hub' ); ?></div>
            <h1 class="h-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <p class="h-exc"><?php the_excerpt(); ?></p>
            <div class="h-meta">
                <span><?php esc_html_e( 'By', 'wunderflats-hub' ); ?> <strong><?php the_author(); ?></strong></span>
                <span><?php echo get_the_date(); ?></span>
                <span><?php echo wfhub_reading_time(); ?></span>
            </div>
            <div class="h-btns">
                <a class="btn-p" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read Article →', 'wunderflats-hub' ); ?></a>
                <?php
                $cats = get_the_category();
                if ( $cats ) : ?>
                <a class="btn-g" href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>">
                    <?php printf( esc_html__( 'Browse %s', 'wunderflats-hub' ), esc_html( $cats[0]->name ) ); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="h-img">
            <?php wfhub_thumb_or_placeholder( 'wfhub-hero', get_the_title() ); ?>
            <?php if ( $hero_cat ) : ?>
                <span class="h-badge"><?php echo esc_html( $hero_cat ); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
    wp_reset_postdata();
endif;
?>

<?php /* ── Sub-Nav ──────────────────────────────── */ ?>
<nav class="subnav" aria-label="<?php esc_attr_e( 'Topic navigation', 'wunderflats-hub' ); ?>">
    <div class="subnav-inner container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="on"><?php esc_html_e( 'All', 'wunderflats-hub' ); ?></a>
        <?php
        $sub_cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10 ) );
        if ( $sub_cats ) :
            foreach ( $sub_cats as $sc ) : ?>
            <a href="<?php echo esc_url( get_category_link( $sc->term_id ) ); ?>"><?php echo esc_html( $sc->name ); ?></a>
        <?php endforeach;
        else : ?>
            <a href="#"><?php esc_html_e( 'Legal', 'wunderflats-hub' ); ?></a>
            <a href="#"><?php esc_html_e( 'Renting With Wunderflats', 'wunderflats-hub' ); ?></a>
            <a href="#"><?php esc_html_e( 'Creating Perfect Listings', 'wunderflats-hub' ); ?></a>
            <a href="#"><?php esc_html_e( 'City Guides', 'wunderflats-hub' ); ?></a>
            <a href="#"><?php esc_html_e( 'Moving to Germany', 'wunderflats-hub' ); ?></a>
            <a href="#"><?php esc_html_e( 'Finance', 'wunderflats-hub' ); ?></a>
        <?php endif; ?>
    </div>
</nav>

<?php /* ── Audience Tabs + Article Grid ─────────── */ ?>
<section class="aud-section">
    <div class="container">

        <div class="aud-tabs" role="tablist">
            <button class="aud-tab on" role="tab" aria-selected="true" data-target="landlords">
                <span class="dot"></span>
                <?php esc_html_e( 'For Landlords — guides, tips & legal updates', 'wunderflats-hub' ); ?>
            </button>
            <button class="aud-tab" role="tab" aria-selected="false" data-target="tenants">
                <span class="dot"></span>
                <?php esc_html_e( 'For Tenants — city guides & moving tips', 'wunderflats-hub' ); ?>
            </button>
        </div>

        <?php
        $landlord_cat = get_category_by_slug( 'landlord' );
        $tenant_cat   = get_category_by_slug( 'tenants' );

        $landlord_query = new WP_Query( array(
            'posts_per_page' => 8,
            'post__not_in'   => $hero_pid ? array( $hero_pid ) : array(),
            'category__in'   => $landlord_cat ? array( $landlord_cat->term_id ) : array(),
        ) );

        $tenant_query = new WP_Query( array(
            'posts_per_page' => 8,
            'post__not_in'   => $hero_pid ? array( $hero_pid ) : array(),
            'category__in'   => $tenant_cat ? array( $tenant_cat->term_id ) : array(),
        ) );

        /* Fall back to recent posts if categories don't exist yet */
        if ( ! $landlord_query->have_posts() ) {
            $landlord_query = new WP_Query( array(
                'posts_per_page' => 8,
                'post__not_in'   => $hero_pid ? array( $hero_pid ) : array(),
            ) );
        }

        $panels = array(
            'landlords' => array( 'query' => $landlord_query, 'active' => true,  'cat' => $landlord_cat, 'btn' => __( 'All Landlord Guides →', 'wunderflats-hub' ) ),
            'tenants'   => array( 'query' => $tenant_query,   'active' => false, 'cat' => $tenant_cat,   'btn' => __( 'All Tenant Guides →',   'wunderflats-hub' ) ),
        );

        foreach ( $panels as $panel_id => $panel ) :
            $q       = $panel['query'];
            $cat_url = $panel['cat'] ? get_category_link( $panel['cat']->term_id ) : home_url( '/' );
        ?>
        <div class="aud-panel <?php echo $panel['active'] ? 'is-active' : ''; ?>"
             id="panel-<?php echo esc_attr( $panel_id ); ?>"
             role="tabpanel">

            <?php if ( $q->have_posts() ) : ?>

                <div class="sec-lbl"><?php esc_html_e( 'Featured Articles', 'wunderflats-hub' ); ?></div>
                <div class="feat-grid">

                    <?php /* Large card — first post */ ?>
                    <?php if ( $q->have_posts() ) : $q->the_post(); $c = wfhub_first_category(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
                        <div class="card-img" style="height:220px">
                            <a href="<?php the_permalink(); ?>"><?php wfhub_thumb_or_placeholder( 'wfhub-card', get_the_title() ); ?></a>
                        </div>
                        <div class="card-body">
                            <?php if ( $c ) : ?><span class="tag <?php echo esc_attr( wfhub_tag_class( $c ) ); ?>"><?php echo esc_html( $c ); ?></span><?php endif; ?>
                            <h2 class="card-title card-title-lg"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="card-exc"><?php the_excerpt(); ?></p>
                            <div class="card-meta"><span><?php the_author(); ?></span><span><?php echo get_the_date(); ?></span><span><?php echo wfhub_reading_time(); ?></span></div>
                        </div>
                    </article>
                    <?php endif; ?>

                    <?php /* Horizontal cards — posts 2–4 */ ?>
                    <div class="feat-secondary">
                        <?php for ( $fi = 0; $fi < 3 && $q->have_posts(); $fi++ ) : $q->the_post(); $c = wfhub_first_category(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'card card--horiz' ); ?>>
                            <div class="card-horiz-img">
                                <a href="<?php the_permalink(); ?>"><?php wfhub_thumb_or_placeholder( 'wfhub-thumb', get_the_title() ); ?></a>
                            </div>
                            <div class="card-body">
                                <?php if ( $c ) : ?><span class="tag <?php echo esc_attr( wfhub_tag_class( $c ) ); ?>"><?php echo esc_html( $c ); ?></span><?php endif; ?>
                                <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="card-meta"><span><?php echo get_the_date(); ?></span></div>
                            </div>
                        </article>
                        <?php endfor; ?>
                    </div>

                </div><!-- .feat-grid -->

                <?php if ( $q->have_posts() ) : ?>
                <div class="sec-lbl" style="margin-top:2rem"><?php esc_html_e( 'Latest Articles', 'wunderflats-hub' ); ?></div>
                <div class="sub-grid">
                    <?php while ( $q->have_posts() ) : $q->the_post(); $c = wfhub_first_category(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
                        <div class="card-img" style="height:140px">
                            <a href="<?php the_permalink(); ?>"><?php wfhub_thumb_or_placeholder( 'wfhub-thumb', get_the_title() ); ?></a>
                        </div>
                        <div class="card-body">
                            <?php if ( $c ) : ?><span class="tag <?php echo esc_attr( wfhub_tag_class( $c ) ); ?>"><?php echo esc_html( $c ); ?></span><?php endif; ?>
                            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="card-meta"><span><?php the_author(); ?></span><span><?php echo get_the_date(); ?></span><span><?php echo wfhub_reading_time(); ?></span></div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>

                <div style="text-align:center;padding:2rem 0">
                    <a href="<?php echo esc_url( $cat_url ); ?>" class="btn-read"><?php echo esc_html( $panel['btn'] ); ?></a>
                </div>

            <?php else : ?>
                <p style="padding:2rem 0;color:var(--c-muted)"><?php esc_html_e( 'No articles found.', 'wunderflats-hub' ); ?></p>
            <?php endif;
            wp_reset_postdata(); ?>

        </div><!-- .aud-panel -->
        <?php endforeach; ?>

    </div><!-- .container -->
</section>

<?php /* ── Split — Landlords | Tenants digest ───── */ ?>
<section class="split-section">
    <div class="container split-inner">
        <?php
        $splits = array(
            array( 'label' => __( 'Landlords', 'wunderflats-hub' ), 'tag_cls' => 'tag-p', 'h2' => __( 'Guides for property owners', 'wunderflats-hub' ), 'desc' => __( 'Everything you need to rent out your furnished apartment in Germany — legally, efficiently and profitably.', 'wunderflats-hub' ), 'cat_slug' => 'landlord', 'btn' => __( 'All Landlord Guides →', 'wunderflats-hub' ), 'btn_cls' => 'btn-read' ),
            array( 'label' => __( 'Tenants',   'wunderflats-hub' ), 'tag_cls' => 'tag-b', 'h2' => __( 'Guides for renters',         'wunderflats-hub' ), 'desc' => __( 'Moving to Germany or France? City guides, relocation tips and everything you need to settle in fast.',          'wunderflats-hub' ), 'cat_slug' => 'tenants',  'btn' => __( 'All Tenant Guides →',   'wunderflats-hub' ), 'btn_cls' => 'btn-read btn-sky' ),
        );
        foreach ( $splits as $s ) :
            $sc    = get_category_by_slug( $s['cat_slug'] );
            $sq    = new WP_Query( array( 'posts_per_page' => 3, 'post__not_in' => $hero_pid ? array( $hero_pid ) : array(), 'category__in' => $sc ? array( $sc->term_id ) : array() ) );
            $s_url = $sc ? get_category_link( $sc->term_id ) : home_url( '/' );
        ?>
        <div class="split-block">
            <span class="tag <?php echo esc_attr( $s['tag_cls'] ); ?>" style="margin-bottom:10px"><?php echo esc_html( $s['label'] ); ?></span>
            <h2><?php echo esc_html( $s['h2'] ); ?></h2>
            <p><?php echo esc_html( $s['desc'] ); ?></p>
            <?php if ( $sq->have_posts() ) : while ( $sq->have_posts() ) : $sq->the_post(); $mc = wfhub_first_category(); ?>
            <div class="mini-card">
                <div class="mini-thumb"><a href="<?php the_permalink(); ?>"><?php wfhub_thumb_or_placeholder( 'wfhub-thumb', get_the_title() ); ?></a></div>
                <div>
                    <?php if ( $mc ) : ?><div class="mini-tag <?php echo esc_attr( wfhub_tag_class( $mc ) ); ?>"><?php echo esc_html( $mc ); ?></div><?php endif; ?>
                    <div class="mini-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                    <div class="mini-meta"><?php echo get_the_date(); ?> · <?php echo wfhub_reading_time(); ?></div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
            <div style="margin-top:18px"><a href="<?php echo esc_url( $s_url ); ?>" class="<?php echo esc_attr( $s['btn_cls'] ); ?>"><?php echo esc_html( $s['btn'] ); ?></a></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php /* ── Stats Bar ───────────────────────────── */ ?>
<div class="stats-bar">
    <div class="container stats-inner">
        <?php
        $stats = array(
            array( 'num' => '50K+', 'lbl' => __( 'Verified tenants on platform', 'wunderflats-hub' ) ),
            array( 'num' => '25K+', 'lbl' => __( 'Furnished apartments listed',  'wunderflats-hub' ) ),
            array( 'num' => '3',    'lbl' => __( 'Countries: DE, FR, AT',         'wunderflats-hub' ) ),
            array( 'num' => '4.8★', 'lbl' => __( 'Average landlord rating',       'wunderflats-hub' ) ),
        );
        foreach ( $stats as $st ) : ?>
        <div class="stat-item">
            <div class="stat-num"><?php echo esc_html( $st['num'] ); ?></div>
            <div class="stat-lbl"><?php echo esc_html( $st['lbl'] ); ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php /* ── Promo Banner ────────────────────────── */ ?>
<section class="promo-banner">
    <div class="container promo-inner">
        <div>
            <h2><?php esc_html_e( 'Ready to rent out your furnished apartment?', 'wunderflats-hub' ); ?></h2>
            <p><?php esc_html_e( 'Connect with thousands of verified professional tenants. Free to list — you only pay when you get booked.', 'wunderflats-hub' ); ?></p>
        </div>
        <div class="promo-btns">
            <a href="https://wunderflats.com/en/create/address" class="btn-gold" target="_blank" rel="noopener"><?php esc_html_e( 'Get Started Free →', 'wunderflats-hub' ); ?></a>
            <a href="#" class="btn-outline"><?php esc_html_e( 'Learn how it works', 'wunderflats-hub' ); ?></a>
        </div>
    </div>
</section>

<?php /* ── Newsletter ──────────────────────────── */ ?>
<section class="nl-section">
    <div class="nl-inner">
        <span class="tag tag-p" style="margin-bottom:14px"><?php esc_html_e( 'Newsletter', 'wunderflats-hub' ); ?></span>
        <h2><?php echo esc_html( get_theme_mod( 'wfhub_nl_heading', __( 'Stay ahead of the German rental market', 'wunderflats-hub' ) ) ); ?></h2>
        <p><?php echo esc_html( get_theme_mod( 'wfhub_nl_subheading', __( 'Weekly insights, legal updates and practical tips for landlords and tenants — straight to your inbox. Join 12,000+ readers.', 'wunderflats-hub' ) ) ); ?></p>
        <?php if ( function_exists( 'mc4wp_form' ) ) : ?>
            <?php mc4wp_form(); ?>
        <?php else : ?>
        <div class="nl-form">
            <input type="email" placeholder="<?php esc_attr_e( 'Enter your email address', 'wunderflats-hub' ); ?>">
            <button type="button"><?php esc_html_e( 'Subscribe →', 'wunderflats-hub' ); ?></button>
        </div>
        <p class="nl-note"><?php esc_html_e( 'No spam, ever. Unsubscribe any time.', 'wunderflats-hub' ); ?></p>
        <?php endif; ?>
    </div>
</section>

</main>

<?php get_footer(); ?>
