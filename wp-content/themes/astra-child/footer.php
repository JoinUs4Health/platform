<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

astra_content_bottom(); ?>
	</div> <!-- ast-container -->
	</div><!-- #content -->
        <footer class="site-footer" id="colophon" itemtype="https://schema.org/WPFooter" itemscope="itemscope" itemid="#colophon">
            <div class="site-primary-footer-wrap ast-builder-grid-row-container site-footer-focus-item ast-builder-grid-row-full ast-builder-grid-row-tablet-full ast-builder-grid-row-mobile-full ast-footer-row-stack ast-footer-row-tablet-stack ast-footer-row-mobile-stack" data-section="section-primary-footer-builder">
                <div class="ast-builder-grid-row-container-inner">
                    <div class="ast-builder-footer-grid-columns site-primary-footer-inner-wrap ast-builder-grid-row">
                        <div class="site-footer-primary-section-1 site-footer-section site-footer-section-1">
                            <div class="footer-widget-area widget-area site-footer-focus-item ast-footer-html-1" data-section="section-fb-html-1">
                                <div class="ast-header-html inner-link-style-">
                                    <div class="footer-links">
                                        <a href="<?= home_url() ?>/privacy-policy/"><?= __('Privacy statement', 'joinus4health') ?></a>
                                        <div class="separator">&bull;</div>
                                        <a href="<?= home_url() ?>/terms-of-use/"><?= __('Terms of use', 'joinus4health') ?></a>
                                        <div class="separator">&bull;</div>
                                        <a href="<?= home_url() ?>/legal-notice/"><?= __('Legal notice', 'joinus4health') ?></a>
                                        <div class="space"></div>
                                        <div class="text"><?= __('To report abuse please email to', 'joinus4health') ?> <a href="mailto:abuse@joinus4health.eu">abuse@joinus4health.eu</a></div>
                                    </div>
                                    <div class="footer-separator">
                                    </div>
                                    <div class="footer-content-xtra">
                                        <img src="<?= home_url().'/wp-content/themes/astra-child/img/flag_eu-300x201.jpeg' ?>">
                                        <p><?= __('footer.text', 'joinus4health') ?></p>
                                    </div>
                                </div>		
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
	</div><!-- #page -->
<?php 
	astra_body_bottom();    
	wp_footer(); 
?>
	</body>
</html>