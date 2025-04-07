<!-- custom shortcode template sections

[breakout_slider_gn image_src="{{image_src}}" header="{{header}}" sub_header="{{sub_header}}"]
    CTA Buttons here
[/breakout_slider_gn]

 -->

<?php

function breakout_slider_gn_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'image_src'   => '',
        'header'      => '',
        'sub_header'  => '',
    ], $atts);

    ob_start();
    ?>
    <div class="breakout p-0">
        <section class="slider-wrapper">
            <ul class="slides-container" id="slides-container">
                <li class="slide" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>')">
                    <div class="slider-content d-flex justify-content-center">

                        <?php if (!empty($atts['sub_header'])): ?>
                            <div class="slide-sub-header"><?php echo esc_html($atts['sub_header']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($atts['header'])): ?>
                            <div class="slide-header"><?php echo esc_html($atts['header']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($content)): ?>
                            <div class="all-the-ctas"><?php echo do_shortcode(wpautop($content)); ?></div>
                        <?php endif; ?>
                        
                    </div>
                </li>
            </ul>
        </section>
    </div>
    <?php
    return ob_get_clean();
}


add_shortcode('breakout_slider_gn', 'breakout_slider_gn_shortcode');
?>