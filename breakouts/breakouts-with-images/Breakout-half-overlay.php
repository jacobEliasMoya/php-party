<!-- custom shortcode template sections

[breakout_half_overlay image_src="{{image_src}}" sub_header="{{sub_header}}" header="{{header}}"]

{{content}}

[/breakout_half_overlay]

-->
<?php

// Register [breakout_half_overlay] shortcode
function breakout_half_overlay_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'image_src'  => '',
        'sub_header' => '',
        'header'     => '',
    ], $atts);

    ob_start();
    ?>

    <div class="breakout text-center text-md-left bg-img half-overlayed invert" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>');">
        <div class="large-wrapper">
            <div class="row">
                <div class="col-md-6">
                    <?php if (!empty($atts['sub_header'])): ?>
                        <strong class="spaced"><?php echo esc_html($atts['sub_header']); ?></strong>
                    <?php endif; ?>

                    <?php if (!empty($atts['header'])): ?>
                        <h2><?php echo esc_html($atts['header']); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($content)): ?>
                        <?php echo do_shortcode(wp_kses_post($content)); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <!-- Empty right column (optional use) -->
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('breakout_half_overlay', 'breakout_half_overlay_shortcode');


?>