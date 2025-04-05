<!-- custom shortcode template sections

[breakout_h1_simple sub_title="{{sub_title}}" title="{{title}}"] 

<p>{{content}}</p> 

[/breakout_h1_simple]

-->

<?php

function breakout_h1_simple($atts, $content = null) {
    $atts = shortcode_atts([
        'sub_title' => '',
        'title' => '',
    ], $atts);

    ob_start();
    ?>
    <div class="breakout text-center dk invert">
        <div class="medium-wrapper>
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

add_shortcode('breakout_h1_simple', 'breakout_h1_simple');

?>
