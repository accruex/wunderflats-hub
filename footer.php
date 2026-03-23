</div><!-- #content -->

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">

            <div class="footer-brand">
                <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    Wunder<span style="color:var(--c-gold)">Hub</span>
                </a>
                <p><?php bloginfo( 'description' ); ?></p>
                <div style="display:flex;gap:10px;margin-top:1.25rem">
                    <a href="https://instagram.com/wunderflats/" target="_blank" rel="noopener" style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:.72rem;color:rgba(255,255,255,.6)">ig</a>
                    <a href="https://www.facebook.com/wunderflats/" target="_blank" rel="noopener" style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:.72rem;color:rgba(255,255,255,.6)">fb</a>
                    <a href="https://www.linkedin.com/company/wunderflats/" target="_blank" rel="noopener" style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:.72rem;color:rgba(255,255,255,.6)">in</a>
                </div>
            </div>

            <div class="footer-col">
                <h4><?php esc_html_e( 'Landlords', 'wunderflats-hub' ); ?></h4>
                <ul>
                    <li><a href="#"><?php esc_html_e( 'Legal', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Renting With Wunderflats', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Creating Perfect Listings', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Renting in France', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Mid-Term Calculator', 'wunderflats-hub' ); ?></a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4><?php esc_html_e( 'Tenants', 'wunderflats-hub' ); ?></h4>
                <ul>
                    <li><a href="#"><?php esc_html_e( 'City Guides', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Moving to Germany', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Moving to France', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Anmeldung Guide', 'wunderflats-hub' ); ?></a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4><?php esc_html_e( 'Legal', 'wunderflats-hub' ); ?></h4>
                <ul>
                    <li><a href="https://wunderflats.com/en/tos" target="_blank" rel="noopener"><?php esc_html_e( 'Terms &amp; Conditions', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="https://wunderflats.com/en/datenschutz" target="_blank" rel="noopener"><?php esc_html_e( 'Privacy Policy', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="https://wunderflats.com/en/impressum" target="_blank" rel="noopener"><?php esc_html_e( 'Impressum', 'wunderflats-hub' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Patent Notice', 'wunderflats-hub' ); ?></a></li>
                </ul>
            </div>

        </div><!-- .footer-grid -->

        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> Wunderflats GmbH. <?php esc_html_e( 'All rights reserved.', 'wunderflats-hub' ); ?></p>
            <p>
                <?php esc_html_e( 'Made with ♥ in Berlin', 'wunderflats-hub' ); ?> &nbsp;&middot;&nbsp;
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">EN</a>
                <a href="<?php echo esc_url( home_url( '/de/' ) ); ?>">DE</a>
                <a href="<?php echo esc_url( home_url( '/fr/' ) ); ?>">FR</a>
            </p>
        </div>

    </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
