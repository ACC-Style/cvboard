</div>
<div id="subfooter" class="bg_secondary-n3 br-t_3 br_solid br_primary c_white font_n2 p-x_4 p-y_4 grid grid-page-layout m-t_auto">



<ul class="ul_none display_none:print breakout ul_inline-pipe">
    <li class="m-r_auto">
        <?php
    $logo_url = wp_get_attachment_image_url(get_theme_mod('alternate_logo'), 'full');

    if ($logo_url) {
        echo '<a href="'.esc_url(home_url('/')).'" class="custom-logo-link" rel="home" itemprop="url"><img src="'.esc_url($logo_url).'" class="custom-logo" alt="'.get_bloginfo('name').'" /></a>';
    }
?>
    </li>
    <?php
        $pages = [
            'cookie-policy' => 'Privacy Policy',
            'registered-user-agreement' => 'Registered User Agreement',
            'terms-of-service' => 'Terms of Service',
            'privacy-policy' => 'Cookie Policy'
        ];

        foreach ($pages as $slug => $name) {
            $page = get_page_by_path($slug);
            if ($page) {
                $permalink = esc_url(get_permalink($page->ID));
                echo '<li><a href="' . $permalink . '" class="c_white-6 h:c_white">' . $name . '</a></li>';
            }
        }
    ?>
</ul><!-- /footer-bottom-links -->

    <div class="flex flex_column flex_row:lg breakout">
        <div class="flex_auto m-3_auto">
                <p class="text_right:lg p-t_3:lg p-r_3">
                    <span id="last-updated-date"><?php echo 'Last Updated: ' . get_last_updated_date(); ?></span>
                </p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php wp_footer(); ?>
</body>
</html>