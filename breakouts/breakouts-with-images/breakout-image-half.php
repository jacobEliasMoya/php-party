<!-- custom shortcode template sections

[breakout_image_half image_src="{{image_src}}" sub_title="{{sub_title}}" title="{{title}}"]

{{content }}

[/breakout_image_half]


-->

<?php

function breakout_image_half($atts, $content = null) {
    $atts = shortcode_atts([
        'image_src' => '',
        'alt'       => '',
        'sub_title' => '',
        'title'     => '',
    ], $atts);

    // Auto-generate alt from filename if none provided
    if (empty($atts['alt']) && !empty($atts['image_src'])) {
        $path_parts = pathinfo($atts['image_src']);
        $filename = $path_parts['filename'] ?? '';
        $auto_alt = ucwords(str_replace(['-', '_'], ' ', $filename));
        $atts['alt'] = $auto_alt;
    }

    ob_start();
    ?>
    <div class="breakout text-md-left text-center">
        <div class="large-wrapper">
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-img bg-c" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>');"></div>
                </div>
                    <div class="col-md-6 px-md-5 mt-md-0 mt-4">
                    <?php if (!empty($atts['sub_title'])): ?>
                        <b class="spaced"><?php echo esc_html($atts['sub_title']); ?></b>
                    <?php endif; ?>

                    <?php if (!empty($atts['title'])): ?>
                        <h2><?php echo esc_html($atts['title']); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($content)): ?>
                        <div class="breakout-content">
                            <?php echo do_shortcode(wp_kses_post($content)); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('breakout_image_half', 'breakout_image_half');

?>
