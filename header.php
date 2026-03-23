<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

<header class="site-header" role="banner">
    <div class="container">
        <div class="site-header__inner">

            <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    Wunder<span>Hub</span>
                <?php endif; ?>
            </a>

            <nav class="primary-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'wunderflats-hub' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>
                            <li><a href="#">Landlords</a></li>
                            <li><a href="#">Tenants</a></li>
                            <li><a href="#">News</a></li>
                            <li>
                                <div class="lang-switcher" style="display:flex;gap:6px;align-items:center">
                                    <a href="#" style="font-size:.72rem;font-weight:700;color:#fff;padding:3px 8px;border-radius:4px;border:1px solid rgba(255,255,255,.5)">EN</a>
                                    <a href="#" style="font-size:.72rem;font-weight:700;color:rgba(255,255,255,.4);padding:3px 8px;border-radius:4px;border:1px solid rgba(255,255,255,.15)">DE</a>
                                    <a href="#" style="font-size:.72rem;font-weight:700;color:rgba(255,255,255,.4);padding:3px 8px;border-radius:4px;border:1px solid rgba(255,255,255,.15)">FR</a>
                                </div>
                            </li>
                            <li><a class="btn-cta" href="https://wunderflats.com/en/create/address" target="_blank" rel="noopener">List your apartment</a></li>
                        </ul>';
                    },
                ) );
                ?>
            </nav>

            <button class="nav-toggle" id="nav-toggle" aria-controls="primary-nav" aria-expanded="false">
                <span></span><span></span><span></span>
                <span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'wunderflats-hub' ); ?></span>
            </button>

        </div>
    </div>
</header>

<div id="content" class="site-content">
