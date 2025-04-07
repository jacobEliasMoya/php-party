<!-- custom shortcode template sections - slider takes unlimited am of slides

[breakout_slider] 
    [breakout_slide image_src="image_src" sub_header="sub_header" header="header"] [/breakout_slide]
[/breakout_slider]

 -->

<?php
    function breakout_slider_shortcode($atts, $content = null) {
        ob_start();
    ?>
    <div class="breakout p-0">
        <section class="slider-wrapper">
            <ul class="slides-container d-flex" id="slides-container">
                <?php echo do_shortcode($content); ?>
            </ul>
        </section>
    </div>
    <?php
        return ob_get_clean();
    }
    add_shortcode('breakout_slider', 'breakout_slider_shortcode');

    function breakout_slide_shortcode($atts, $content = null) {
        $atts = shortcode_atts([
            'image_src'   => '',
            'header'      => '',
            'sub_header'  => '',
        ], $atts);

        ob_start();
    ?>
    <li class="slide " style="background-image: url('<?php echo esc_url($atts['image_src']); ?>')">
        <div class="slider-content d-flex justify-content-center">

            <?php if (!empty($atts['header'])): ?>
            <div class="slide-sub-header"><?php echo esc_html($atts['header']); ?></div>
            <?php endif; ?>

            <?php if (!empty($atts['sub_header'])): ?>
            <div class="slide-header"><?php echo esc_html($atts['sub_header']); ?></div>
            <?php endif; ?>

            <?php if (!empty($content)): ?>
            <div class="all-the-ctas">
                <?php echo do_shortcode(wpautop($content)); ?>
            </div>
            <?php endif; ?>

        </div>
    </li>
    <?php
        return ob_get_clean();
    }
    add_shortcode('breakout_slide', 'breakout_slide_shortcode');
 
?>