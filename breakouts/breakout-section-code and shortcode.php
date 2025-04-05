<!-- custom shortcode template sections

[breakout_section sub_title="{{sub_title}}" title="{{title}}"] 

<p>{{content}}</p> 

[/breakout_section]

-->

<?php

function breakout_section_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'sub_title' => '',
        'title' => '',
    ], $atts);

    ob_start();
    ?>
    <div class="breakout text-center lt invert">
        <div class="medium-wrapper not visible btm mt-4">
            <?php if (!empty($atts['sub_title'])): ?>
                <b class="spaced mb-4"><?php echo esc_html($atts['sub_title']); ?></b>
            <?php endif; ?>

            <?php if (!empty($atts['title'])): ?>
                <h1><?php echo esc_html($atts['title']); ?></h1>
            <?php endif; ?>

            <?php if (!empty($content)): ?>
                <?php echo do_shortcode($content); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('breakout_section', 'breakout_section_shortcode');

?>
